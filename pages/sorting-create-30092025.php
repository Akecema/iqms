<!-- System title -->
<?php include "../system-header.php";?>

<!-- Session start -->
<?php include "session-start.php"; ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <!--Title-->
	<title><?php echo $syst_title; ?> </title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="index, follow">

	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="../icon/favicon.ico">
    
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="vendor/select2/css/select2.min.css">
	<link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link class="main-css" href="css/style.css" rel="stylesheet">
    <link class="main-css" href="css/add-style.css" rel="stylesheet">
	
    <!-- Tagify Css -->
	<link href="vendor/tagify/dist/tagify.css" rel="stylesheet">	
	<link href="vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">
    
	<link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
    
	<link href="vendor/nestable2/css/jquery.nestable.min.css" rel="stylesheet">
    <link href="vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    

</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
		<div>
			
            <?php //
            // include 'loading-images.php'; ?>

		</div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            
            <?php include 'nav-hdr-logo.php'; ?>

        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Chat box start
        ***********************************-->
		<div class="chatbox">
			<div class="chatbox-close"></div>
			
            <?php include 'nav-hdr-chat-box.php'; ?>

		</div>
		<!--**********************************
            Chat box End
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
		<div class="header">
            <div class="header-content">
                
            <?php include 'nav-hdr-top.php'; ?>

			</div>
		</div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
		<div class="deznav">
            <div class="deznav-scroll">
				
                <?php include 'nav-left-sidebar.php'; ?>
                
			</div>
        </div>

        <style>

        .form-control { background-color : #fff; }

        .select2-container--default .select2-selection--single {
            background-color: #fff !important;
        }

        .input-error, .border-error {
            border: 1px solid #e74c3c !important;  /* Red border */
            background-color: #fff6f6;
        }

        #relatedPartTable tbody tr td:last-child {
            text-align: left !important; 
        }

        #relatedPartTable thead tr th:last-child{
            text-align: left !important;
        }

        /* Floating button back  */
        .back-button {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 9999;
            width: 36px;
            height: 36px;
            padding: 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
            background-color: #1d1e1eff;
            color: white;
        }
        .back-button:hover {
            background-color: #5b5e5dff;
            border-color: #5b5e5dff;
            color: white;
        }

        #lightgallery img {
            width: 100%;              /* fills its column */
            height: 200px;            /* fixed height thumbnail */
            object-fit: cover;        /* fill box, crop if needed */
            border-radius: 6px;       /* optional rounded corners */
            background: #fff;
            border: 1px solid #eee;
        }

        #lightgallery a {
            padding: 5px;         /* internal spacing around image */
        }

        </style>

		<?php

        $eir_id = $_GET['erid'] ?? null;
        
        ?>

        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
				<div class="header-left mb-4">
                    <div class="dashboard_bar">
                        <?=$side_menu7;?>
                    </div>
                </div>

                <div id="detailsPreview" >
                    <div class="accordion accordion-with-icon accordion-header-bg accordion-bordered">
                        <div class="accordion-item">
                        <h2 class="accordion-header accordion-header-primary" id="headingOne6">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne6">
                        <span class="accordion-header-icon"></span>
                            <span class="accordion-header-text">Material Details</span>
                        </button>
                        </h2>
                    </div>

                    <div id="collapseOne6" class="accordion__body collapse" aria-labelledby="accord-6One" data-bs-parent="#accordion-six">
                        <div class="accordion-body-text p-0">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <div class="row">                                        
                                        <div class="col-xl-4">                                             
                                           <div class="product-detail-content" id="material_product_detail">
                                            <!-- Material Details will be display here via AJAX -->    
                                            </div>
                                        </div>                                        
                                        <div class="col-xl-6">
                                            <h5 class="text-primary d-inline">Gallery</h5>
                                            <div class="row mt-4 sp4" id="lightgallery">
                                                <?=$gallery_html;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                        
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card"> 
                    <div class="cm-content-body form excerpt rounded-0">
                        <div class="card-body">
                            <!-- <h6 class="mb-1">Menu Structure</h6>
                            <p class="fs-13 mb-4">Add menu items from the column on the left.</p> -->

                            <!-- Hidden -->
                            <input type="hidden" id="hidden_ir_id" name="hidden_ir_id" class="form-control" value="<?=$eir_id;?>">
                            <div class="accordion accordion-with-icon accordion-bordered" id="accordionExample">

                            <!-- 1. Report -->
                            <div class="accordion-item border-0 mb-4">
                                <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <i class="fa fa-file-alt me-2 text-black"></i> SORTING
                                </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form>
                                            <div class="row g-2 align-items-end mb-4 mt-4">
                                                <!-- QTY OK -->
                                                <div class="col-auto">
                                                    <label class="form-label mb-2">QTY OK</label>
                                                    <input type="number" id="sr_qty_ok" name="sr_qty_ok" class="form-control" value="">
                                                </div>

                                                <!-- QTY NG -->
                                                <div class="col-auto">
                                                    <label class="form-label mb-2">QTY NG</label>
                                                    <input type="number" id="sr_qty_ng" name="sr_qty_ng" class="form-control" value="">
                                                </div>

                                                <!-- Action Button -->
                                                <div class="col-auto ms-3">
                                                    <button type="button" class="btn btn-black text-white btn-sm" id="btnSave">
                                                        Save
                                                    </button>
                                                    <button type="button" class="btn btn-black text-white btn-sm" id="btnUpdate" style="display:none;">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <!-- 2. Department -->
                            <div class="accordion-item border-0 mb-4">
                                <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <i class="fa fa-building me-2 text-black"></i> RELATED LOOSE PART INVOLVE - In House Part (If any)
                                </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table class="isplay table mb-1 table-striped-thead table-wide table-md mt-4" id="relatedPartTable">
                                            <colgroup>
                                                <col style="width: 15%;">
                                                <col style="width: 20%;">
                                                <col style="width: 18%;">
                                                <col style="width: 35%;">
                                                <col style="width: 8%;">
                                                <col style="width: 8%;">
                                                <col style="width: 8%;">
                                            </colgroup>
                                            <thead class="thead-black">
                                                <tr>
                                                    <th>Related Dept</th>
                                                    <th>Type of Part </th>
                                                    <th>Part Number</th>
                                                    <th>Part Name</th>
                                                    <th>QTY OK</th>
                                                    <th>QTY NG</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select class="form-control filter-select  related_dept">
                                                        <option value="">Select Dept</option>
                                                        <!-- PHP loop: related_departments -->
                                                        <?php
                                                        $res = $db_con->query("SELECT rd_deptid, rd_deptname FROM related_departments WHERE rd_status = 'AC'");
                                                        while($r = $res->fetch_assoc()){
                                                            echo "<option value='{$r['rd_deptid']}'>{$r['rd_deptname']}</option>";
                                                        }
                                                        ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control filter-select  type_part">
                                                        <option value="">Select Type</option>
                                                        <?php
                                                        $res = $db_con->query("SELECT tp_partid, tp_partname FROM type_part WHERE tp_status = 'AC'");
                                                        while($r = $res->fetch_assoc()){
                                                            echo "<option value='{$r['tp_partid']}'>{$r['tp_partname']}</option>";
                                                        }
                                                        ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control filter-select  part_no">
                                                        <option value="">Part Number</option>
                                                        <?php
                                                        $res = $db_con->query("SELECT m.matdet_id, m.bom, m.bomdesc
                                                                                FROM material_details m
                                                                                INNER JOIN inspection_records i ON m. mathdr = i.ir_material
                                                                                WHERE i.ir_id = '$eir_id'");
                                                        while($r = $res->fetch_assoc()){
                                                            echo "<option value='{$r['matdet_id']}'>{$r['bom']}</option>";
                                                        }
                                                        ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control filter-select  part_name">
                                                        <option value="">Part Name</option>
                                                        <!-- Filled dynamically on part_no change -->
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control qty_ok" placeholder="" value="">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control qty_ng" placeholder="" value="">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-black btn-sm btnSaveRow">Save</button>                                                        
                                                        <button type="button" class="btn btn-black btn-sm btnUpdateRow" style="display:none;">Update</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <button type="button" id="btnAddRow" class="btn btn-primary btn-sm mt-2">+ Add New</button>

                                    </div>
                                </div>
                            </div>

                            <!-- 3. Vendor -->
                            <div class="accordion-item border-0 mb-4">
                                <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <i class="fa fa-truck me-2 text-black"></i> RELATED LOOSE PART INVOLVE - Tier 2 (If any)
                                </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Content for Vendor accordion...
                                </div>
                                </div>
                            </div>

                            <!-- 4. Customer -->
                            <div class="accordion-item border-0 mb-4">
                                <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <i class="fa fa-users me-2 text-black"></i> FINISHED GOODS PART INVOLVE - Customer (If any)
                                </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Content for Customer accordion...
                                </div>
                                </div>
                            </div>

                            </div>

                        </div>		
                    </div> 
                </div>                                             
                            
                <a href="javascript:void(0);" class="btn btn-primary btn-lg rounded-circle back-button" id="btnBack" title="Go Back">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>
               
			</div>
        </div>
		
        <!--**********************************
            Content body end
        ***********************************-->
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <?php include 'nav-footer.php' ;?>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->
		
        <!--**********************************
           Support ticket button end
        ***********************************-->

	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
       
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>   
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="vendor/select2/js/select2.full.min.js"></script>
    <script src="js/plugins-init/select2-init.js"></script>
	<script src="vendor/bootstrap-datepicker-master/js/bootstrap-datepicker.min.js"></script>
    <script src="vendor/chart-js/chart.bundle.min.js"></script>
	<!-- Apex Chart -->
	<script src="vendor/apexchart/apexchart.js"></script>

    <!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/responsive/responsive.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>

    <script src="vendor/wnumb/wNumb.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>
    <script src="js/highlight.min.js"></script>    
    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>
    
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="js/plugins-init/sweetalert.init.js"></script>

    <script>
    function initSelect2(row) {
        row.find("select").select2({
            width: '100%'   // makes Select2 stretch to <td> width
        });
    }

    // Initialize for first row on page load
    $(document).ready(function () {
        initSelect2($("#relatedPartTable tbody tr"));
    });
    </script>

    <script>
    document.getElementById('btnBack').addEventListener('click', function () {
        history.back();
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
    });
    </script>

    <script>

    $(document).on('click', '.zoomable-img', function() {
        const imgSrc = $(this).data('src') || $(this).attr('src');
        console.log("Clicked:", imgSrc);
        $('#zoomedImage').attr('src', imgSrc);
        const modal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
        modal.show();
    });

    </script>

    <script>
    function loadMaterialDetails(irid) {
        $.ajax({
            url: 'fetch-material-details.php',
            type: 'POST',
            dataType: 'json',
            data: { ir_id: irid },
            success: function (res) {
                // Inject images
                $('#lightgallery').html(res.gallery_html);

                // Inject details
                $('#material_product_detail').html(res.detail_html);

                // Re-init lightGallery
                if ($('#lightgallery').data('lightGallery')) {
                    $('#lightgallery').data('lightGallery').destroy(true);
                }
                $('#lightgallery').lightGallery({
                    selector: 'a',
                    thumbnail: true
                });
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error, xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const irid = urlParams.get('erid');
        if (irid) {
            loadMaterialDetails(irid);
        }
    });

    </script>

    <!-- ##Sorting Qty -->
    <script>

    $(document).on('click', '#btnSave, #btnUpdate', function() {

        let ir_id   = <?=$eir_id?> 
        let qty_ok  = $('#sr_qty_ok').val();
        let qty_ng  = $('#sr_qty_ng').val();

        var hasError = false;

        qty_ok = parseInt(qty_ok, 10);
        qty_ng = parseInt(qty_ng, 10);

        if(isNaN(qty_ok)) {
            alert("QTY OK is required.");
            $('#sr_qty_ok').addClass('border-error');
            hasError = true;
            return;
        }
        else {
            $('#sr_qty_ok').removeClass('border-error');
        }

        if(isNaN(qty_ng)) {
            alert("QTY NG is required.");
            $('#sr_qty_ng').addClass('border-error');
            hasError = true;
            return;
        }
        else {
            $('#sr_qty_ng').removeClass('border-error');
        }

        if (qty_ng <= 0) {
            alert("QTY NG cannot be less than or equal 0.");
            $('#sr_qty_ng').addClass('border-error');
            hasError = true;
            return;
        }
        else {
            $('#sr_qty_ng').removeClass('border-error');
        }

        Swal.fire({
            title: "Are you sure?",
            text: "Save this sorting quantity?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754",
            cancelButtonColor: "#dc3545"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "fetch-sorting-qty.php",
                    method: "POST",
                    dataType: "json",
                    data: { ir_id: ir_id, qty_ok: qty_ok, qty_ng: qty_ng, action: 'add_sorting_qty' },
                    success: function(res) {
                        if(res.status === "success"){
                            Swal.fire("Success", res.message, "success");

                            // change button to Edit after save
                            $("#btnSave").hide();
                            $("#btnUpdate").show();

                        } else {
                            Swal.fire("Error", res.message, "error");
                        }
                    },
                    error: function(xhr, status, err) {
                        Swal.fire("Error", "Something went wrong: " + err, "error");
                    }
                });
            }
        });
    });

    //Fetch record
    $(document).ready(function(){
        let ir_id = $("#hidden_ir_id").val(); // add hidden input for ir_id

        if(ir_id){
            $.post("fetch-sorting-qty.php", {
                action: "get_sorting_qty",
                ir_id: ir_id
            }, function(res){

                if(res.status === "success"){
                    $("#sr_qty_ok").val(res.qty_ok);
                    $("#sr_qty_ng").val(res.qty_ng);

                    $("#btnSave").hide();
                    $("#btnUpdate").show();
                }                
                else if(res.status === "empty") {
                    // No record → show Save button
                    $("#sr_qty_ok").val("");
                    $("#sr_qty_ng").val("");

                    $("#btnSave").show();
                    $("#btnUpdate").hide();
                } 
                else {
                   
                    console.error(res.message);
                }

            }, "json");

        } else {
            // No ir_id at all → new record
            $("#btnSave").show();
            $("#btnUpdate").hide();
        }
    });

    </script>

    <!-- #Related Part -->
    <script>

    // Save related loose part involve
    $(document).ready(function () {

        // Add new row
        $("#btnAddRow").on("click", function(){

            let newRow = $("#relatedPartTable tbody tr:first").clone();
            newRow.find('.related_dept').val(null).trigger('change');
            newRow.find("input").val("");
            newRow.find("button")
                .removeClass("btn-warning btnUpdateRow btnDeleteRow")
                .addClass("btn-success btnSaveRow")
                .text("Save xx");
            $("#relatedPartTable tbody").append(newRow);

        });

        // Load Part Name when Part No changes
        $(document).on("change", ".part_no", function(){
            let partNoId = $(this).val();
            let partNameSelect = $(this).closest("tr").find(".part_name");

            if(partNoId){
                $.post("get-partname.php", { part_no_id: partNoId }, function(data){
                    partNameSelect.html(data);
                });
            } else {
                partNameSelect.html('<option value="">Part Name</option>');
            }
        });

        // Save row
        $(document).on("click", ".btnSaveRow", '.btnUpdateRow', function(){

            let row = $(this).closest("tr");

            let related_dept = row.find(".related_dept").val();
            let type_part    = row.find(".type_part").val();
            let part_no      = row.find(".part_no").val();
            let part_name    = row.find(".part_name").val();
            let qty_ok       = row.find(".qty_ok").val();
            let qty_ng       = row.find(".qty_ng").val();

             if(!related_dept) {
                alert("Related Dept is required.");
                $('.related_dept').next('.select2').find('.select2-selection').addClass('border-error');
                hasError = true;
                return;
            }
            else {
                $('.related_dept').removeClass('border-error');
            }

            if(!type_part) {
                alert("Type of Part is required.");
                $('.type_part').next('.select2').find('.select2-selection').addClass('border-error');
                hasError = true;
                return;
            }
            else {
                $('.type_part').removeClass('border-error');
            }

            if(!part_no) {
                alert("Part Number is required.");
                $('.part_no').next('.select2').find('.select2-selection').addClass('border-error');
                hasError = true;
                return;
            }
            else {
                $('.part_no').removeClass('border-error');
            }
            
            if(!part_name) {
                alert("Part Name is required.");
                $('.part_name').next('.select2').find('.select2-selection').addClass('border-error');
                hasError = true;
                return;
            }
            else {
                $('.part_name').removeClass('border-error');
            }

            if(!qty_ok) {
                alert("QTY OK is required.");
                $('.qty_ok').addClass('border-error');
                hasError = true;
                return;
            }
            else {
                $('.qty_ok').removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                $('.qty_ng').addClass('border-error');
                hasError = true;
                return;
            }
            else {
                $('.qty_ng').removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                $('#qty_ng').addClass('select-error');
                hasError = true;
                return;
            }
            else {
                $('#qty_ng').removeClass('border-error');
            }

            $.post("fetch-related-part.php", {
                action: "add_related_part",
                ir_id: $("#hidden_ir_id").val(),
                related_dept, type_part, part_no, part_name, qty_ok, qty_ng

            }, function(res){

                if(res.status === "duplicate"){
                    Swal.fire("Duplicate", res.message, "warning");
                }

                if(res.status === "success"){
                   
                    Swal.fire("Success", res.message, "success");

                    row.find(".btnSaveRow")
                        .removeClass("btn-black btnSaveRow")
                        .addClass("btn-black btnUpdateRow")
                        .text("Update");
                    row.find("td:last").append(' <button type="button" class="btn btn-danger btn-sm btnDeleteRow"><i class="fa fa-trash" aria-hidden="true"></i></button>');
                } else {
                    alert("Error: " + res.message);
                }
            }, "json");

        });

        // Update row
        $(document).on("click", ".btnUpdateRow", function(){
            let row = $(this).closest("tr");
            // similar logic as save, but call update_sorting.php
        });

        // Delete row
        $(document).on("click", ".btnDeleteRow", function(){
            let row = $(this).closest("tr");
            if(confirm("Delete this record?")){
                // call delete_sorting.php with ID
                row.remove();
            }
        });
    });

    //Fetch record
    $(document).ready(function(){
        let ir_id = $("#hidden_ir_id").val();

        if(ir_id){
            $.post("fetch-related-part.php", {
                action: "get_related_part",
                ir_id: ir_id
            }, function(res){
                if(res.status === "success"){
                    let tbody = $("#relatedPartTable tbody");
                    tbody.empty(); // clear existing

                    res.data.forEach(function(item){
                        let row = `
                            <tr>
                                <td>
                                    <select class="form-control related_dept select2">
                                        <option value="">Select Dept</option>
                                        <?php
                                        $res = $db_con->query("SELECT rd_deptid, rd_deptname FROM related_departments WHERE rd_status = 'AC'");
                                        while($r = $res->fetch_assoc()){
                                            echo "<option value='{$r['rd_deptid']}'>{$r['rd_deptname']}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control type_part select2">
                                    <option value="">Select Type</option>
                                        <?php
                                        $res = $db_con->query("SELECT tp_partid, tp_partname FROM type_part WHERE tp_status = 'AC'");
                                        while($r = $res->fetch_assoc()){
                                            echo "<option value='{$r['tp_partid']}'>{$r['tp_partname']}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control part_no select2">
                                    <option value="">Part Number</option>
                                        <?php
                                        $res = $db_con->query("SELECT m.matdet_id, m.bom, m.bomdesc
                                                                FROM material_details m
                                                                INNER JOIN inspection_records i ON m.mathdr = i.ir_material
                                                                WHERE i.ir_id = '$eir_id'");
                                        while($r = $res->fetch_assoc()){
                                            echo "<option value='{$r['matdet_id']}'>{$r['bom']}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control part_name">
                                        <option value="">Part Name</option>
                                        <option value="${item.part_no}" selected>${item.part_name}</option>
                                    </select>
                                </td>
                                <td><input type="number" class="form-control" value="${item.qty_ok}" name="qty_ok[]"></td>
                                <td><input type="number" class="form-control" value="${item.qty_ng}" name="qty_ng[]"></td>
                                <td>
                                    <button type="button" class="btn btn-black btn-sm btnSaveRow" style="display:none;">Save</button>
                                    <button type="button" class="btn btn-black btn-sm btnUpdateRow">Update</button>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);

                        // Set dropdown values
                        tbody.find("tr:last .related_dept").val(item.related_dept);
                        tbody.find("tr:last .type_part").val(item.type_part);
                        tbody.find("tr:last .part_no").val(item.part_no);

                    });

                    // Re-init select2 after appending
                    $("#relatedPartTable .select2").select2({
                        width: "100%"
                    });
                      
                    // show update if records exist
                    $(".btnSaveRow").hide();
                    $(".btnUpdateRow").show();

                } else {
                    // no record → empty row
                    $("#relatedPartTable tbody").html(`
                        <tr>
                            <td>
                                <select class="form-control related_dept select2">
                                    <option value="">Select Dept</option>
                                    <?php
                                    $res = $db_con->query("SELECT rd_deptid, rd_deptname FROM related_departments WHERE rd_status = 'AC'");
                                    while($r = $res->fetch_assoc()){
                                        echo "<option value='{$r['rd_deptid']}'>{$r['rd_deptname']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select class="form-control type_part select2">
                                <option value="">Select Type</option>
                                    <?php
                                    $res = $db_con->query("SELECT tp_partid, tp_partname FROM type_part WHERE tp_status = 'AC'");
                                    while($r = $res->fetch_assoc()){
                                        echo "<option value='{$r['tp_partid']}'>{$r['tp_partname']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select class="form-control part_no select2">
                                <option value="">Part Number</option>
                                    <?php
                                    $res = $db_con->query("SELECT m.matdet_id, m.bom, m.bomdesc
                                                            FROM material_details m
                                                            INNER JOIN inspection_records i ON m.mathdr = i.ir_material
                                                            WHERE i.ir_id = '$eir_id'");
                                    while($r = $res->fetch_assoc()){
                                        echo "<option value='{$r['matdet_id']}'>{$r['bom']}</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select class="form-control filter-select  part_name">
                                <option value="">Part Name</option>
                                </select>
                            </td>
                            <td><input type="number" class="form-control" value= "" name="qty_ok[]"></td>
                            <td><input type="number" class="form-control" value= "" name="qty_ng[]"></td>
                            <td>
                                <button type="button" class="btn btn-black btn-sm btnSaveRow" style="display:none;">Save</button>
                                <button type="button" class="btn btn-black btn-sm btnUpdateRow">Update</button>
                            </td>
                        </tr>
                    `);

                    // Re-init select2 after appending
                    $("#relatedPartTable .select2").select2({
                        width: "100%"
                    });

                    $(".btnSaveRow").show();
                    $(".btnUpdateRow").hide();
                }
            }, "json");
        }

        // Init select2 for static dropdowns (in case no ajax runs)
        $("#relatedPartTable .select2").select2({ width: "100%" });

    });

    </script>


</body>
</html>