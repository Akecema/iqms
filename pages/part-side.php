<?php include "../system-header.php";?>
<?php include "session-start.php"; ?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $syst_title; ?> - Part Side Management</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/png" href="../icon/favicon.ico">
	<link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link class="main-css" href="css/style.css" rel="stylesheet">
	<link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
</head>
<body>

    <style>

    #tablePartSide tbody tr td:last-child {
        text-align: left !important; 
    }

    #tablePartSide thead tr th:last-child{
        text-align: left !important;
    }

    </style>

    <div id="preloader"><div></div></div>

    <div id="main-wrapper">
        <div class="nav-header"><?php include 'nav-hdr-logo.php'; ?></div>
		<div class="chatbox"><div class="chatbox-close"></div><?php include 'nav-hdr-chat-box.php'; ?></div>
		<div class="header"><div class="header-content"><?php include 'nav-hdr-top.php'; ?></div></div>
		<div class="deznav"><div class="deznav-scroll"><?php include 'nav-left-sidebar.php'; ?></div></div>

        <div class="content-body">
			<div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header flex-wrap">
                                <h4 class="heading mb-0">Part Side List</h4>
                                <div class="d-flex align-items-center">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tablePartSide" class="display table mb-1 table-striped-thead table-wide table-md">
                                        <thead class="thead-black">
                                            <tr>
                                                <th>No</th>
                                                <th>Side Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="row">                                    
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-block w-100">
                                            <h4 class="heading mb-1">
                                                <i class="fa fa-cog me-2 text-black"></i>
                                                Add Part Side
                                            </h4>
                                            <small class="text-muted d-block">
                                                Add new part side to be use in model type
                                            </small>
                                        </div>
                                    </div>
                                    <div class="card-body add-side">
                                        <div class="mb-3 mb-3">
                                            <label class="form-label">Side Name</label>
                                            <input type="text" class="form-control" id="add_side_name">
                                        </div>
                                        <div class="card-footer text-end">
                                            <button type="button" class="btn btn-black" id="btnSaveType">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>                                    
                        </div>
                    </div>
                </div>
			</div>
        </div>

        <div class="footer"><?php include 'nav-footer.php' ;?></div>
	</div>

    <!-- Modal Add -->
    <div class="modal fade" id="modalAddPartSide" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">Add New Part Side</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label">Side Name</label>
                        <input type="text" class="form-control" id="add_side_name" placeholder="E.g. FRONT, REAR">
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-dark light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-black" id="btnConfirmAddSide">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEditPartSide" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 text-dark">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">Edit Part Side</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <input type="hidden" id="edit_side_id">
                    <div class="mb-3">
                        <label class="form-label">Side Name</label>
                        <input type="text" class="form-control" id="edit_side_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label d-block text-black font-w500">Status</label>
                        <div class="form-check form-switch custom-switch-1">
                            <input type="checkbox" class="form-check-input" id="edit_side_status" checked>
                            <label class="form-check-label" for="edit_side_status">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-dark light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-black" id="btnConfirmUpdateSide">Update</button>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>

    <script>
    let tablePartSide;

    $(document).ready(function () {
        tablePartSide = $('#tablePartSide').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            pageLength: 10,
            ajax: {
                url: 'fetch-part-side.php',
                type: 'POST',
                data: { action: 'list_part_side' }
            },
            columns: [
                { data: 0 },
                { data: 1 },
                { data: 2 },
                { data: 3 }
            ],
            order: [[1, 'asc']],
            language: {
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: '<i class="fa fa-angle-right"></i>'
                }
            }
        });

        // Add
        $('#btnSaveType').on('click', function () {
            let sideName = $('#add_side_name').val().trim();
            if(!sideName) {
                return Swal.fire({
                    title: 'Error',
                    text: 'Side Name is required.',
                    icon: 'warning',
                    iconColor: '#198754',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#198754'
                });
            }

            $.ajax({
                url: 'fetch-part-side.php',
                type: 'POST',
                dataType: 'json',
                data: { action: 'add_part_side', side_name: sideName },
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: 'Side added successfully.',
                            icon: 'success',
                            iconColor: '#198754',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#198754'
                        }).then(() => {
                            $('#add_side_name').val('');
                            tablePartSide.ajax.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: res.message,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#198754'
                        });
                    }
                }
            });
        });

        // Edit
        $(document).on('click', '.btnEditSide', function () {
            let id = $(this).data('id');
            $.ajax({
                url: 'fetch-part-side.php',
                type: 'POST',
                dataType: 'json',
                data: { action: 'get_part_side', id: id },
                success: function (res) {
                    if (res.status === 'success') {
                        $('#edit_side_id').val(res.data.side_id);
                        $('#edit_side_name').val(res.data.side_name);
                        
                        if(res.data.side_status === 'AC'){
                            $('#edit_side_status').prop('checked', true);
                            $('label[for="edit_side_status"]').text('Active');
                        } else {
                            $('#edit_side_status').prop('checked', false);
                            $('label[for="edit_side_status"]').text('Inactive');
                        }

                        $('#modalEditPartSide').modal('show');
                    }
                }
            });
        });

        $('#btnConfirmUpdateSide').on('click', function () {
            let id = $('#edit_side_id').val();
            let sideName = $('#edit_side_name').val().trim();
            let sideStatus = $('#edit_side_status').is(':checked') ? 'AC' : 'IN';

            if(!sideName) {
                return Swal.fire({
                    text: 'Side Name is required.',
                    icon: 'warning',
                    iconColor: '#198754',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#198754'
                });
            }

            $.ajax({
                url: 'fetch-part-side.php',
                type: 'POST',
                dataType: 'json',
                data: { 
                    action: 'update_part_side', 
                    id: id, 
                    side_name: sideName,
                    side_status: sideStatus
                },
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: 'Side updated successfully.',
                            icon: 'success',
                            iconColor: '#198754',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#198754'
                        }).then(() => {
                            $('#modalEditPartSide').modal('hide');
                            tablePartSide.ajax.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: res.message,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#198754'
                        });
                    }
                }
            });
        });

        // Toggle label text on status change
        $('#edit_side_status').on('change', function() {
            if($(this).is(':checked')) {
                $('label[for="edit_side_status"]').text('Active');
            } else {
                $('label[for="edit_side_status"]').text('Inactive');
            }
        });
    });
    </script>
</body>
</html>
