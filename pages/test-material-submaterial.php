<?php
session_start();
include '../db/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Material & Sub Material</title>

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>

    <style>
        .panel-card {
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(0,0,0,.08);
            border: 0;
        }
        .material-item {
            cursor: pointer;
            border-radius: 10px;
            padding: 10px 12px;
            transition: .15s;
        }
        .material-item:hover {
            background: #f4f6f9;
        }
        .material-item.active {
            background: #e9f5ff;
            border: 1px solid #b9e0ff;
        }
        .small-muted {
            font-size: 12px;
            color: #6c757d;
        }
        .badge-count {
            font-size: 11px;
            padding: 5px 8px;
            border-radius: 999px;
        }
        .list-scroll {
            max-height: 68vh;
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-light">

<div class="container-fluid py-4">
    <div class="row g-3">

        <!-- LEFT PANEL: MATERIAL -->
        <div class="col-lg-4">
            <div class="card panel-card">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Materials</h5>
                        <button class="btn btn-sm btn-primary" id="btnAddMaterial">
                            + Add Material
                        </button>
                    </div>
                    <div class="mt-3">
                        <input type="text" id="searchMaterial" class="form-control"
                               placeholder="Search material code / name...">
                    </div>
                </div>

                <div class="card-body pt-3">
                    <div id="materialList" class="list-scroll">
                        <div class="text-muted text-center py-4">Loading materials...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL: SUB MATERIAL -->
        <div class="col-lg-8">
            <div class="card panel-card">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Sub Materials</h5>
                            <div class="small-muted">
                                Selected Material: <span id="selectedMaterialText">-</span>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-success" id="btnAddSubMaterial" disabled>
                                + Add Sub Material
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" id="btnRefreshSub" disabled>
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <input type="hidden" id="selectedMatId" value="">

                    <div class="table-responsive">
                        <table id="subMaterialTable" class="display table table-striped w-100">
                            <thead>
                            <tr>
                                <th>Sub Code</th>
                                <th>Sub Name</th>
                                <th>Spec / Color</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- DataTables -->
                            </tbody>
                        </table>
                    </div>

                    <div id="subEmptyState" class="text-center text-muted py-5 d-none">
                        Select a material on the left to view sub materials.
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    let selectedMatId = "";
    let subTable;

    // Load material list
    function loadMaterials(keyword = "") {
        $.ajax({
            url: "ajax-material-submaterial.php",
            method: "POST",
            dataType: "json",
            data: {
                action: "fetch_material_list",
                keyword: keyword
            },
            success: function (res) {
                if (!res.success) {
                    $("#materialList").html(`<div class="text-danger text-center py-3">${res.message}</div>`);
                    return;
                }

                if (res.data.length === 0) {
                    $("#materialList").html(`<div class="text-muted text-center py-4">No material found</div>`);
                    return;
                }

                let html = "";
                res.data.forEach(function (m) {
                    html += `
                        <div class="material-item ${m.matid == selectedMatId ? "active" : ""}"
                             data-matid="${m.matid}"
                             data-matcode="${m.matcode}"
                             data-matname="${m.matname}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">${m.matno} - ${m.matdesc}</div>
                                    <div class="small-muted">Model: ${m.modelcode || "-"}</div>
                                </div>
                                <span class="badge bg-primary badge-count">Sub: ${m.sub_count}</span>
                            </div>
                        </div>
                    `;
                });

                $("#materialList").html(html);
            }
        });
    }

    // Init sub material datatable
    function initSubTable() {
        subTable = $("#subMaterialTable").DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false,
            pageLength: 10,
            order: [[0, "asc"]],
            ajax: {
                url: "ajax-material-submaterial.php",
                type: "POST",
                data: function (d) {
                    d.action = "fetch_sub_material_table";
                    d.matid = selectedMatId;
                }
            },
            columns: [
                {data: "subcode"},
                {data: "subname"},
                {data: "spec"},
                {data: "status_badge"},
                {data: "action", orderable: false}
            ],
            drawCallback: function () {
                if (!selectedMatId) {
                    $("#subEmptyState").removeClass("d-none");
                    $("#subMaterialTable_wrapper").addClass("d-none");
                } else {
                    $("#subEmptyState").addClass("d-none");
                    $("#subMaterialTable_wrapper").removeClass("d-none");
                }
            }
        });
    }

    // When select material
    $(document).on("click", ".material-item", function () {
        $(".material-item").removeClass("active");
        $(this).addClass("active");

        selectedMatId = $(this).data("matid");
        $("#selectedMatId").val(selectedMatId);

        let matText = $(this).data("matcode") + " - " + $(this).data("matname");
        $("#selectedMaterialText").text(matText);

        $("#btnAddSubMaterial").prop("disabled", false);
        $("#btnRefreshSub").prop("disabled", false);

        subTable.ajax.reload();
    });

    // Search material
    $("#searchMaterial").on("keyup", function () {
        let keyword = $(this).val().trim();
        loadMaterials(keyword);
    });

    // Refresh sub table
    $("#btnRefreshSub").on("click", function () {
        if (!selectedMatId) return;
        subTable.ajax.reload();
    });

    // Add Material button (placeholder)
    $("#btnAddMaterial").on("click", function () {
        alert("Open Add Material Modal here");
    });

    // Add Sub Material button (placeholder)
    $("#btnAddSubMaterial").on("click", function () {
        if (!selectedMatId) return;
        alert("Open Add Sub Material Modal for matid = " + selectedMatId);
    });

    // First load
    $(document).ready(function () {
        loadMaterials();
        initSubTable();
        $("#subEmptyState").removeClass("d-none");
        $("#subMaterialTable_wrapper").addClass("d-none");
    });
</script>

</body>
</html>
