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
    
    <!-- layout for tab IR, SR,S2W -->
    <link href="css/layout-style.css" rel="stylesheet">
    <link href="css/badge.css" rel="stylesheet">
    <link href="css/button.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <link href="css/form.css" rel="stylesheet">
    <link href="css/image.css" rel="stylesheet">
    
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

		#tableMaterial tbody tr td:last-child {
            text-align: left !important; 
        }

        #tableMaterial thead tr th:last-child{
            text-align: left !important;
        }

        .table-active {
            background-color: #eef6ff !important;
        }

        /* Table container that scrolls */
        .table-wrapper {
            height: calc(100vh - 560px); /* adjust once */
            overflow: auto;
        }

        /* DataTables fix */
        .dataTables_wrapper {
            height: 100%;
        }

        .dataTables_scrollBody {
            overflow-y: auto !important;
        }

        </style>

        <?php 

        // Fetch Models
        $model_options = "";
        $q_mod = $db_con->query("SELECT modid, modcode FROM model_details WHERE modstatus='Y' ORDER BY modcode");
        if($q_mod){
            while($row = $q_mod->fetch_assoc()){
                $model_options .= '<option value="'.$row['modid'].'">'.$row['modcode'].'</option>';
            }
        }

        // Fetch Types
        $type_options = "";
        $q_type = $db_con->query("SELECT typeid, typemodel FROM model_type WHERE typestatus='Y' ORDER BY typemodel");
        if($q_type){
            while($row = $q_type->fetch_assoc()){
                $type_options .= '<option value="'.$row['typeid'].'">'.$row['typemodel'].'</option>';
            }
        }

        // Fetch Side
        $side_options = "";
        $s_side = $db_con->query("SELECT side_id, side_name FROM part_side ORDER BY side_name");
        if($s_side){
            while($row = $s_side->fetch_assoc()){
                $side_options .= '<option value="'.$row['side_name'].'">'.$row['side_name'].'</option>';
            }
        }

        // Fetch Customers
        $cust_options = "";
        $q_cust = $db_con->query("SELECT rc_cust_id, rc_cust_name FROM related_customers WHERE rc_cust_status='AC' ORDER BY rc_cust_name");
        if($q_cust){
            while($row = $q_cust->fetch_assoc()){
                $cust_options .= '<option value="'.$row['rc_cust_id'].'">'.$row['rc_cust_name'].'</option>';
            }
        }
        ?> 

        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
                <div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">                        
                        <div class="row g-3">                           
                            <div class="col-12 col-xl-8">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Finished Goods List</h6>
                                        <a href="javascript:void(0);" class="text-black" id="btnAddMaterial"> + Add Finished Goods</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tableMaterial" class="display table mb-1 table-striped-thead table-wide table-md">
                                                <thead class="thead-black">
                                                    <tr>
                                                        <th>Part No</th>                                                     
                                                        <th>Model</th> 
                                                        <th>Type</th>                                                     
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal update material -->
                            <div class="modal fade" id="modelEditMaterial" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content border-0 shadow-sm">

                                        <div class="modal-header border-bottom-0">
                                            <!-- <h5 class="modal-title fw-semibold text-dark">
                                                <i class="fa fa-building me-2 text-primary"></i>Edit Company
                                            </h5> -->
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body px-4 py-3">

                                            <input type="hidden" id="edit_material_id">                                            
                                
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Part No</label>
                                                <input type="text" class="form-control" id="edit_part_no" placeholder="Enter part no">
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Part Name</label>
                                                <input type="text" class="form-control" id="edit_part_name" placeholder="Enter part name">
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Model</label>
                                                <select class="default-select form-control wide" id="edit_model">
                                                    <option value="">Select Model</option>
                                                    <?php echo $model_options; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Type</label>
                                                <select class="default-select form-control wide" id="edit_type">
                                                    <option value="">Select Type</option>
                                                    <?php echo $type_options; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Part Side</label>
                                                <select class="default-select form-control wide" id="edit_part_side">
                                                    <option value="">Select Part Side</option>
                                                    <?php echo $side_options; ?>
                                                </select>                                                
                                            </div>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Status</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="matrial_status" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                            <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                                <i class="fa fa-times me-1"></i> Cancel
                                            </button>
                                            <button type="button" class="btn btn-black" id="btnUpdateMaterial">
                                                <i class="fa fa-save me-1"></i> Save Changes
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Modal Upload Gallery -->
                            <div class="modal fade" id="modalUploadGallery" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-sm">
                                        <div class="modal-header border-bottom-0">
                                            <h5 class="modal-title fw-semibold text-dark">Upload Gallery</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body px-4 py-3">
                                            <input type="hidden" id="upload_mat_id">
                                            <div class="mb-3">
                                                <label class="form-label">Select Photos</label>
                                                <input type="file" class="form-control" id="gallery_files" multiple accept="image/*">
                                            </div>
                                            <div id="gallery_preview" class="row g-2 mt-3"></div>
                                        </div>
                                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                             <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                                <i class="fa fa-times me-1"></i> Cancel
                                            </button>
                                            <button type="button" class="btn btn-black" id="btnConfirmUpload">
                                                <i class="fa fa-upload me-1"></i> Upload
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Offcanvas View Images -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasGallery" aria-labelledby="offcanvasGalleryLabel" style="width: 50%;">
                                <div class="offcanvas-header">
                                    <h5 id="offcanvasGalleryLabel">Finished Goods Images</h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <input type="hidden" id="view_mat_id">
                                    <div id="loading_images" class="text-center my-5 d-none">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                    <div id="image_gallery_container" class="row g-3">
                                        <!-- Images will be loaded here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Modal ADD material -->
                            <div class="modal fade" id="modalAddMaterial" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content border-0 shadow-sm">

                                        <div class="modal-header border-bottom-0">
                                            <h5 class="modal-title fw-semibold text-dark">Add New Material</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body px-4 py-3">
                                
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Part No</label>
                                                <input type="text" class="form-control" id="add_part_no" placeholder="Enter part no">
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Part Name</label>
                                                <input type="text" class="form-control" id="add_part_name" placeholder="Enter part name">
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Model</label>
                                                <select class="default-select form-control wide" id="add_model">
                                                    <option value="">Select Model</option>
                                                    <?php echo $model_options; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Type</label>
                                                <select class="default-select form-control wide" id="add_type">
                                                    <option value="">Select Type</option>
                                                    <?php echo $type_options; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Part Side</label>
                                                <select class="default-select form-control wide" id="add_part_side">
                                                    <option value="">Select Part Side</option>
                                                    <?php echo $side_options; ?>
                                                </select>                                                
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Customer</label>
                                                <select class="default-select form-control wide" id="add_customer">
                                                    <option value="">Select Customer</option>
                                                    <?php echo $cust_options; ?>
                                                </select>
                                            </div>
                                            
                                        </div>

                                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                            <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                                <i class="fa fa-times me-1"></i> Cancel
                                            </button>
                                            <button type="button" class="btn btn-black" id="btnSaveNewMaterial">
                                                <i class="fa fa-save me-1"></i> Save
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Modal ADD BOM -->
                            <div class="modal fade" id="modalAddBOM" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content border-0 shadow-sm">

                                        <div class="modal-header border-bottom-0">
                                            <h5 class="modal-title fw-semibold text-dark">Add New Loose Parts</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body px-4 py-3">
                                
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">BOM Part No</label>
                                                <input type="text" class="form-control" id="add_bom_part_no" placeholder="Enter bom part no">
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Part Name</label>
                                                <input type="text" class="form-control" id="add_bom_part_name" placeholder="Enter bom part name">
                                            </div>
                                            
                                        </div>

                                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                            <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                                <i class="fa fa-times me-1"></i> Cancel
                                            </button>
                                            <button type="button" class="btn btn-black" id="btnSaveNewBOM">
                                                <i class="fa fa-save me-1"></i> Save
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Modal EDIT BOM -->
                            <div class="modal fade" id="modalEditBOM" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content border-0 shadow-sm">

                                        <div class="modal-header border-bottom-0">
                                            <h5 class="modal-title fw-semibold text-dark">Edit Loose Parts</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body px-4 py-3">
                                            <input type="hidden" id="edit_bom_id">
                                            
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Part No</label>
                                                <input type="text" class="form-control" id="edit_bom_part_no" placeholder="Enter bom part no">
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Part Name</label>
                                                <input type="text" class="form-control" id="edit_bom_part_name" placeholder="Enter bom part name">
                                            </div>

                                            <div class="row align-items-center mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Status</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="edit_bom_status" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                            <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                                <i class="fa fa-times me-1"></i> Cancel
                                            </button>
                                            <button type="button" class="btn btn-black" id="btnUpdateBOM">
                                                <i class="fa fa-save me-1"></i> Save Changes
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- BOM -->
                            <div class="col-12 col-xl-4">
                                <div class="card h-100">
                                    <div class="card-header border-0 flex-wrap">
                                        <h4 class="heading mb-0"><!--My To Do Items --></h4>
                                        <div>
                                            <a href="javascript:void(0);" class="text-black" id="btnAddBOM"> + Add Loose Parts</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                         <table id="tableBOM" class="display table mb-1 table-striped-thead table-wide table-md">
                                            <thead class="thead-black">
                                                <tr>
                                                    <th>Part No</th>                                                    
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>	
                                    </div>
                                </div>
                            </div>
                            
                        </div>  
                    </div>
                </div> 
            </div>

            <!-- <a href="javascript:void(0);" class="btn btn-black btn-lg rounded-circle back-button" id="btnBack" title="Go Back">
                <i class="fa fa-arrow-left"></i>
            </a> -->
               
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
   	<script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>	

    <!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/responsive/responsive.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>

    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="js/plugins-init/sweetalert.init.js"></script>

    <script>

    //to apply select style to non select2
    //select with no filter
    // $('.default-select').select2({
    //     minimumResultsForSearch: Infinity, // Hide search box if not needed
    //     width: '100%'
    // });

    </script>

    <script>

	$(function () {
		$('[data-bs-toggle="tooltip"]').tooltip(); // run on page load

		// run again after table draw
		$('#tableMaterial,#tableBOM').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>

    <script>

    function getTableHeight() {
        // Adjust offset depending on your header/footer/filter size
        return ($(window).height() - 200) + 'px';
    }

    let tableMaterial, tableBOM;
    let selectedMatId = null;

    $(document).ready(function () {

        // MATERIAL LIST
        tableMaterial = $('#tableMaterial').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            scrollX: true,            // horizontal scroll for wide columns
            scrollY: getTableHeight(), // dynamic vertical scroll (auto fits screen)
            scrollCollapse: true,     // collapses empty space if fewer rows
            autoWidth: false,
            pageLength: 10,
            order: [[0, 'asc']],
            ajax: {
                url: 'fetch-material-master.php',
                type: 'POST',
                data: { action: 'list_material' }
            },
            language: {
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: '<i class="fa fa-angle-right"></i>'
                }
            }
        });

        // BOM TABLE (empty first)
        tableBOM = $('#tableBOM').DataTable({
            processing: true,
            serverSide: true,
            searching: true, 
            lengthChange: false,
            pageLength: 10,
            orderMulti: true,          // enable multi sort
            order: [[1, 'asc'], [0, 'asc']], // default: Status → Part No

            columnDefs: [
                { targets: 2, orderable: false } // Action column
            ],
            ajax: {
                url: 'fetch-material-master.php',
                type: 'POST',
                data: function (d) {

                console.log("Selected matid:", selectedMatId);
                    d.action = 'list_bom';
                    d.matid  = selectedMatId; // linked
                }
            },
            language: {
                emptyTable: "Select a material to view BOM",
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: '<i class="fa fa-angle-right"></i>'
                }
            },
        });

        // CLICK MATERIAL ROW
        $('#tableMaterial').on('click', 'td', function () {

            let tr = $(this).closest('tr');
            let matid = tr.find('[data-matid]').first().attr('data-matid');

            console.log('Selected matid:', matid);

            if (!matid) return;

            selectedMatId = matid;
            $('#tableMaterial tbody tr').removeClass('table-active');
            tr.addClass('table-active');
            tableBOM.ajax.reload();
        });

    });

    </script>

    <script>

    function validateField(id, label) {
        let val = $(id).val();

        // for Select2, value may be null
        if (!val || val.toString().trim() === "") {
            $(id).addClass("border-error");

            Swal.fire({
                text: label + " is required.",
                icon: "warning",
                iconColor: "#198754",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            }).then(() => {
                scrollToField(id);
                $(id).focus();
            });

            return false;
        }

        $(id).removeClass("border-error");
        return true;
    }

    //EDIT material
    $(document).on('click', '.btnEditMaterial', function () {

        const material_id = $(this).data('id');

        $.ajax({
            url: 'fetch-material-master.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_material',
                material_id: material_id
            },
            success: function (res) {

                if (res.status !== 'success') {
                    Swal.fire({
                        title: 'Error',
                        text: res.message,
                        icon: 'error',
                        iconColor: "#198754",
                        showCancelButton: true,
                        confirmButtonColor: '#198754'
                    });
                    return;
                }

                const d = res.data;

                // Fill inputs
                $('#edit_material_id').val(d.matid);
                $('#edit_part_no').val(d.matno);
                $('#edit_part_name').val(d.matdesc);
                
                // Select2 or normal select trigger
                $('#edit_model').val(d.modelid).trigger('change');
                $('#edit_type').val(d.typeid).trigger('change');
                $('#edit_part_side').val(d.partside).trigger('change');

                // If bootstrap-select is used, it needs a refresh
                if ($.fn.selectpicker) {
                    $('#edit_model').selectpicker('refresh');
                    $('#edit_type').selectpicker('refresh');
                    $('#edit_part_side').selectpicker('refresh');
                }

                if (d.matstatus === 'Y') {
                    $('#matrial_status').prop('checked', true);
                } else {
                    $('#matrial_status').prop('checked', false);
                }

                // Show modal first
                $('#modelEditMaterial').modal('show');
            },
            error: function () {
                Swal.fire({
                    title: 'Error',
                    text: "Failed to load material data",
                    icon: 'error',
                    iconColor: '#198754', 
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#198754' 
                });

            }
        });
    });
 
    //UPDATE
    $('#btnUpdateMaterial').on('click', function () {

        let matStatus = $('#matrial_status').is(':checked') ? 'Y' : 'N';
        let matId = $('#edit_material_id').val();
        let partNo = $('#edit_part_no').val();
        let partName = $('#edit_part_name').val();
        let modelId = $('#edit_model').val();
        let typeId = $('#edit_type').val();
        let partSide = $('#edit_part_side').val();

        if(!validateField('#edit_part_no', 'Part No')) return;
        if(!validateField('#edit_part_name', 'Part Name')) return;
        if(!validateField('#edit_model', 'Model')) return;
        if(!validateField('#edit_type', 'Type')) return;

        $.ajax({
            url: 'fetch-material-master.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_material',
                matid: matId,
                matno: partNo,
                matdesc: partName,
                modelid: modelId,
                typeid: typeId,
                partside: partSide,
                matstatus : matStatus
            },
            success: function (res) {
                if (res.status === 'success') {
                    Swal.fire({
                        title: "Saved",
                        text: "Material updated successfully.",
                        icon: "success",
                        iconColor: "#198754",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#198754"
                    }).then(() => {                                
                        $('#modelEditMaterial').modal('hide');
                        tableMaterial.ajax.reload(null, false); 
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: res.message,
                        icon: 'error',
                        iconColor: '#198754', 
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754' 
                    });
                }
            },
            error: function () {
                Swal.fire({
                    title: 'Error',
                    text: "Failed to update material",
                    icon: 'error',
                    iconColor: '#198754', 
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#198754' 
                });
            }
        });
    });

    // OPEN ADD MODAL
    $('#btnAddMaterial').on('click', function(){
        // Reset fields
        $('#add_part_no').val('');
        $('#add_part_name').val('');
        $('#add_part_side').val('').trigger('change');
        $('#add_model').val('').trigger('change');
        $('#add_type').val('').trigger('change');
        $('#add_customer').val('').trigger('change');

        if ($.fn.selectpicker) {
            $('#add_model').selectpicker('refresh');
            $('#add_type').selectpicker('refresh');
            $('#add_customer').selectpicker('refresh');
            $('#add_part_side').selectpicker('refresh');
        }

        $('#modalAddMaterial').modal('show');
    });

    // OPEN ADD BOM MODAL
    $('#btnAddBOM').on('click', function(){
        if(!selectedMatId){
            Swal.fire({
                title: 'No Material Selected',
                text: 'Please select a material from the list first.',
                icon: 'warning',
                iconColor: '#198754', 
                confirmButtonText: 'OK',
                confirmButtonColor: '#198754' 
            });
            return;
        }
        
        // Reset fields
        $('#add_bom_part_no').val('');
        $('#add_bom_part_name').val('');

        $('#modalAddBOM').modal('show');
    });

    // SAVE NEW BOM
    $('#btnSaveNewBOM').on('click', function(){
        
        if(!selectedMatId){
            Swal.fire({
                title: 'Error',
                text: "No material selected",
                icon: 'error',
                iconColor: '#198754', 
                confirmButtonText: 'OK',
                confirmButtonColor: '#198754' 
            });
            
            return;
        }

        if(!validateField('#add_bom_part_no', 'BOM Part No')) return;
        if(!validateField('#add_bom_part_name', 'BOM Part Name')) return;

        let bomPartNo = $('#add_bom_part_no').val().trim();
        let bomPartName = $('#add_bom_part_name').val().trim();

        $.ajax({
            url: 'fetch-material-master.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'add_bom',
                matid: selectedMatId,
                bom: bomPartNo,
                bomdesc: bomPartName
            },
            success: function(res){
                if(res.status === 'success'){
                    Swal.fire({
                        title: "Saved",
                        text: "New BOM added successfully.",
                        icon: "success",
                        iconColor: "#198754",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#198754"
                    }).then(() => {                                
                        $('#modalAddBOM').modal('hide');
                        tableBOM.ajax.reload(null, false); 
                        tableMaterial.ajax.reload(null, false); // Update counts
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: res.message,
                        icon: 'error',
                        iconColor: '#198754', 
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754' 
                    });
                }
            },
            error: function(){
                Swal.fire({
                    title: 'Error',
                    text: "Failed to add Loose Parts",
                    icon: 'error',
                    iconColor: '#198754', 
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#198754' 
                });
            }
        });
    });

    // SAVE NEW MATERIAL
    $('#btnSaveNewMaterial').on('click', function(){
        
        // Validate
        if(!validateField('#add_part_no', 'Part No')) return;
        if(!validateField('#add_part_name', 'Part Name')) return;
        if(!validateField('#add_model', 'Model')) return;
        if(!validateField('#add_type', 'Type')) return;
        if(!validateField('#add_customer', 'Customer')) return;

        let partNo   = $('#add_part_no').val().trim();
        let partName = $('#add_part_name').val().trim();
        let modelId  = $('#add_model').val();
        let typeId   = $('#add_type').val();
        let partSide = $('#add_part_side').val();
        let custId   = $('#add_customer').val();

        $.ajax({
            url: 'fetch-material-master.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'add_material',
                matno: partNo,
                matdesc: partName,
                modelid: modelId,
                typeid: typeId,
                partside: partSide,
                matcustomer: custId
            },
            beforeSend: function(){
                // Optional loading state
            },
            success: function(res){
                if(res.status === 'success'){
                    Swal.fire({
                        title: "Saved",
                        text: "New material added successfully.",
                        icon: "success",
                        iconColor: "#198754",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#198754"
                    }).then(() => {                                
                        $('#modalAddMaterial').modal('hide');
                        tableMaterial.ajax.reload(null, false); 
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: res.message,
                        icon: 'error',
                        iconColor: '#198754', 
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754' 
                    });
                }
            },
            error: function(){
                Swal.fire({
                    title: 'Error',
                    text: "Failed to add Finished Goods",
                    icon: 'error',
                    iconColor: '#198754', 
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#198754' 
                });
            }
        });

    });

    // EDIT BOM
    $(document).on('click', '.btnEditBOM', function(){
        let bomId = $(this).data('id');
        
        $.ajax({
            url: 'fetch-material-master.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_bom',
                matdet_id: bomId
            },
            success: function(res){
                if(res.status === 'success'){
                    let d = res.data;
                    $('#edit_bom_id').val(d.matdet_id);
                    $('#edit_bom_part_no').val(d.bom);
                    $('#edit_bom_part_name').val(d.bomdesc);
                    
                    if (d.bomstatus === 'Y') {
                        $('#edit_bom_status').prop('checked', true);
                    } else {
                        $('#edit_bom_status').prop('checked', false);
                    }

                    $('#modalEditBOM').modal('show');
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: res.message,
                        icon: 'error',
                        iconColor: '#198754', 
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754' 
                    });
                    }
            },
             error: function(){
                Swal.fire({
                    title: 'Error',
                    text: "Failed to fetch Loose Parts details",
                    icon: 'error',
                    iconColor: '#198754', 
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#198754' 
                });
            }
        });
    });

    // UPDATE BOM
    $('#btnUpdateBOM').on('click', function(){
        
        if(!validateField('#edit_bom_part_no', 'BOM Part No')) return;
        if(!validateField('#edit_bom_part_name', 'BOM Part Name')) return;

        let bomId = $('#edit_bom_id').val();
        let bomPartNo = $('#edit_bom_part_no').val().trim();
        let bomPartName = $('#edit_bom_part_name').val().trim();
        let bomStatus = $('#edit_bom_status').is(':checked') ? 'Y' : 'N';

        $.ajax({
            url: 'fetch-material-master.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_bom',
                matdet_id: bomId,
                bom: bomPartNo,
                bomdesc: bomPartName,
                bomstatus: bomStatus
            },
            success: function(res){
                if(res.status === 'success'){
                    Swal.fire({
                        title: "Saved",
                        text: "BOM updated successfully.",
                        icon: "success",
                        iconColor: "#198754",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#198754"
                    }).then(() => {                                
                        $('#modalEditBOM').modal('hide');
                        tableBOM.ajax.reload(null, false); 
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: res.message,
                        icon: 'error',
                        iconColor: '#198754', 
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754' 
                    });
                }
            },
            error: function(){
                Swal.fire({
                    title: 'Error',
                    text: "Failed to to update Loose Parts",
                    icon: 'error',
                    iconColor: '#198754', 
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#198754' 
                });
            }
        });
    });

    
    // UPLOAD GALLERY JS
    // OPEN UPLOAD MODAL
    $(document).on('click', '.btnUploadGallery', function () {
        const matid = $(this).data('id');
        $('#upload_mat_id').val(matid);
        $('#gallery_files').val('');
        $('#gallery_preview').html('');
        $('#modalUploadGallery').modal('show');
    });

    // PREVIEW IMAGES
    $('#gallery_files').on('change', function() {
        const files = this.files;
        const previewContainer = $('#gallery_preview');
        previewContainer.html('');

        if (files) {
            [].forEach.call(files, function(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgCheck = `
                        <div class="col-4 col-md-3">
                            <div class="position-relative">
                                <img src="${e.target.result}" class="img-fluid rounded border" style="height: 100px; width: 100%; object-fit: cover;">
                            </div>
                        </div>`;
                    previewContainer.append(imgCheck);
                };
                reader.readAsDataURL(file);
            });
        }
    });

    // CONFIRM UPLOAD
    $('#btnConfirmUpload').on('click', function() {
        const matid = $('#upload_mat_id').val();
        const fileInput = $('#gallery_files')[0];
        const files = fileInput.files;

        if (files.length === 0) {
            Swal.fire('Warning', 'Please select at least one photo.', 'warning');
            return;
        }

        let formData = new FormData();
        formData.append('action', 'upload_gallery');
        formData.append('matid', matid);

        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        // Show loading
        Swal.fire({
            title: 'Uploading...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: 'fetch-material-master.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        title: 'Success',
                        text: res.message,
                        icon: 'success',
                        iconColor: '#198754',
                        confirmButtonColor: '#198754'
                    }).then(() => {
                        $('#modalUploadGallery').modal('hide');
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: res.message,
                        icon: 'error',
                        iconColor: '#198754', 
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754' 
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: "Upload failed",
                    icon: 'error',
                    iconColor: '#198754', 
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#198754' 
                });
            }
        });
    });

    // VIEW IMAGES - OFFCANVAS
    $(document).on('click', '.btnViewImages', function() {
        const matid = $(this).data('id');
        $('#view_mat_id').val(matid);
        
        const offcanvasEl = document.getElementById('offcanvasGallery');
        const bsOffcanvas = new bootstrap.Offcanvas(offcanvasEl);
        bsOffcanvas.show();
        
        loadGalleryImages(matid);
    });

    function loadGalleryImages(matid) {
        $('#image_gallery_container').html('');
        $('#loading_images').removeClass('d-none');
        
        $.ajax({
            url: 'fetch-material-master.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_material_images',
                matid: matid
            },
            success: function(res) {
                $('#loading_images').addClass('d-none');
                
                if (res.status === 'success' && res.data.length > 0) {
                    let html = '';
                    res.data.forEach(function(img) {
                        html += `
                            <div class="col-md-4 col-sm-6 position-relative">
                                <div class="card h-100 border shadow-sm">
                                    <a href="${img.path}" class="lightgallery-item" data-src="${img.path}">
                                        <img src="${img.path}" class="card-img-top" style="height: 150px; object-fit: cover; cursor: zoom-in;">
                                    </a>
                                    <div class="card-body p-2 text-center">
                                        <div class="input-group input-group-sm mb-2">
                                            <span class="input-group-text">Priority</span>
                                            <input type="number" class="form-control text-center px-1 image-priority-input" value="${img.priority || 0}" data-id="${img.id}" min="0">
                                            <button class="btn btn-black btnUpdatePriority" type="button" data-id="${img.id}" title="Update Priority">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                        ${img.status === 'Y' 
                                            ? `<button class="btn btn-primary btn-xs btnToggleImageStatus me-1" data-id="${img.id}" title="Click to Deactivate">Active</button>` 
                                            : `<button class="btn btn-meron btn-xs btnToggleImageStatus me-1" data-id="${img.id}" title="Click to Activate">Inactive</button>`
                                        }
                                        <button class="btn btn-meron btn-xs btnDeleteImage" data-id="${img.id}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    $('#image_gallery_container').html(html);
                    
                    // Init lightGallery
                    if ($('#image_gallery_container').data('lightGallery')) {
                         $('#image_gallery_container').data('lightGallery').destroy(true);
                    }
                    $('#image_gallery_container').lightGallery({
                        selector: '.lightgallery-item',
                        thumbnail: true
                    });
                    
                } else {
                    $('#image_gallery_container').html('<div class="col-12 text-center text-muted">No images found.</div>');
                }
            },
            error: function() {
                $('#loading_images').addClass('d-none');
                $('#image_gallery_container').html('<div class="col-12 text-center text-danger">Failed to load images.</div>');
            }
        });
    }

    // DELETE IMAGE
    $(document).on('click', '.btnDeleteImage', function() {
        const btn = $(this);
        const imageid = btn.data('id');
        const matid = $('#view_mat_id').val();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonColor: '#198754',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'fetch-material-master.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'delete_material_image',
                        imageid: imageid
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            loadGalleryImages(matid); // Reload
                        } else {
                            Swal.fire({
                            title: "Error",
                            text: res.message,
                            icon: "error",
                            iconColor: "#286912",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#28a745"
                        });
                            
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: "Error",
                            text: "Delete failed.",
                            icon: "error",
                            iconColor: "#286912",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#28a745"
                        });
                    }
                });
            }
        });
    });

    // TOGGLE IMAGE STATUS
    $(document).on('click', '.btnToggleImageStatus', function() {
        const btn = $(this);
        const imageid = btn.data('id');
        const matid = $('#view_mat_id').val();
        
        // Show small loading
        btn.html('<i class="fa fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: 'fetch-material-master.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'toggle_image_status',
                imageid: imageid
            },
            success: function(res) {
                if (res.status === 'success') {
                    // localized reload or full gallery reload
                    loadGalleryImages(matid); 
                } else {
                     Swal.fire('Error', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Update failed', 'error');
            }
        });
    });

    // UPDATE IMAGE PRIORITY
    $(document).on('click', '.btnUpdatePriority', function() {
        const btn = $(this);
        const imageid = btn.data('id');
        const matid = $('#view_mat_id').val();
        
        // Find the adjacent input
        const priorityInput = btn.closest('.input-group').find('.image-priority-input').val();
        
        btn.html('<i class="fa fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: 'fetch-material-master.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_image_priority',
                imageid: imageid,
                priority: priorityInput
            },
            success: function(res) {
                if (res.status === 'success') {
                    // Reload gallery images
                    loadGalleryImages(matid); 
                } else {
                     btn.html('<i class="fa fa-check"></i>');
                     Swal.fire('Error', res.message, 'error');
                }
            },
            error: function() {
                btn.html('<i class="fa fa-check"></i>');
                Swal.fire('Error', 'Update failed', 'error');
            }
        });
    });
</script>

</body>
</html>