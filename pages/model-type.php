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
    
    <!-- layout for tab IR, SR,S2W -->
    <link href="css/layout-style.css" rel="stylesheet">
    <link href="css/badge.css" rel="stylesheet">
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

        #tableModelType tbody tr td:last-child {
            text-align: left !important; 
        }

        #tableModelType thead tr th:last-child{
            text-align: left !important;
        }

        td.dt-control {
            text-align: center;
            cursor: pointer;
            width: 30px;
        }
        td.dt-control:before {
            content: "\f055"; /* fa-plus-circle */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            color: #198754;
            font-size: 12px;
        }
        tr.dt-hasChild td.dt-control:before {
            content: "\f056"; /* fa-minus-circle */
            color: #ea5330;
        }

        .child-row-table {
            background: #f8f9fa !important;
            margin: 10px 0 10px 20px !important;
            width: calc(100% - 40px) !important;
            border-radius: 8px;
            box-shadow: inset 0 0 5px rgba(0,0,0,0.05);
        }
        .child-row-table thead th {
            background: #e9ecef !important;
            color: #333 !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            padding: 8px 12px !important;
        }
        .child-row-table tbody td {
            padding: 8px 12px !important;
            font-size: 12px !important;
        }

        </style>
        
        <?php
        // Fetch Side
        $side_options = "";
        $s_side = $db_con->query("SELECT side_id, side_name FROM part_side WHERE side_status = 'AC'ORDER BY side_name");
        if($s_side){
            while($row = $s_side->fetch_assoc()){
                $side_options .= '<option value="'.$row['side_name'].'">'.$row['side_name'].'</option>';
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
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Model List</h6>
                                        <a href="javascript:void(0);" class="text-black" id="btnAddMaterial" data-bs-toggle="modal" data-bs-target="#modalAddType"> + Add New Model Type</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tableModelType" class="display table mb-1 table-striped-thead table-wide table-md">
                                                <thead class="thead-black">
                                                    <tr>
                                                        <th style="width: 30px;"></th>
                                                        <th>Model Type</th>                                                   
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
                                                        Add Model Type
                                                    </h4>
                                                    <small class="text-muted d-block">
                                                        Register new type for model
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3 mb-3">
                                                    <label class="form-label">Type Name</label>
                                                    <input type="text" class="form-control" id="typename">
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="button" class="btn btn-black" id="btnSaveType">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>

                            <!-- Modal update model -->
                            <div class="modal fade" id="typeEditModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content border-0 shadow-sm">

                                        <div class="modal-header border-bottom-0">
                                            <!-- <h5 class="modal-title fw-semibold text-dark">
                                                <i class="fa fa-building me-2 text-primary"></i>Edit Company
                                            </h5> -->
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body px-4 py-3">

                                            <input type="hidden" id="edit_type_id">                                            
                                
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Model Name</label>
                                                <input type="text" class="form-control" id="edit_type_name" placeholder="Enter Model Name">
                                            </div>
                                            <div class="col-md-9">                                                
                                                <label class="form-label mb-md-0">Status</label> 
                                                <div class="form-check form-switch custom-switch-1">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="type_status" checked>
                                                    <label class="form-check-label" for="type_status">Active</label>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                            <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                                <i class="fa fa-times me-1"></i> Cancel
                                            </button>
                                            <button type="button" class="btn btn-black" id="btnUpdateType">
                                                <i class="fa fa-save me-1"></i> Save Changes
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Modal update side -->
                            <div class="modal fade" id="sideEditModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content border-0 shadow-sm">
                                        <div class="modal-header border-bottom-0">
                                            <h5 class="modal-title fw-semibold text-dark">
                                                Edit Part Side
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body px-4 py-3">
                                            <input type="hidden" id="edit_side_id">                                            
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Part Side Name</label>
                                                <select class="default-select form-control wide" id="edit_side_name">
                                                    <option value="">Select Part Side</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label mb-md-0">Status</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="edit_side_status" checked>
                                                    <label class="form-check-label" for="edit_side_status">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                            <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                                <i class="fa fa-times me-1"></i> Cancel
                                            </button>
                                            <button type="button" class="btn btn-black" id="btnUpdateSide">
                                                <i class="fa fa-save me-1"></i> Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <!-- Modal Add New Type -->
                        <div class="modal fade" id="modalAddType" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content border-0 shadow-sm">
                                    <div class="modal-header border-bottom-0">
                                        <h5 class="modal-title fw-semibold text-dark">
                                            Add New Model Type
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body px-4 py-3">
                                        <div class="col-md-12 mb-4">
                                            <label class="form-label">Type Name</label>
                                            <input type="text" class="form-control" id="add_typename" placeholder="Enter Type Name">
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                        <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                            <i class="fa fa-times me-1"></i> Cancel
                                        </button>
                                        <button type="button" class="btn btn-black" id="btnConfirmAddType">
                                            <i class="fa fa-save me-1"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Add Part Side -->
                        <div class="modal fade" id="modalAddSide" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content border-0 shadow-sm">
                                    <div class="modal-header border-bottom-0">
                                        <h5 class="modal-title fw-semibold text-dark">
                                            Add New Part Side
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body px-4 py-3">
                                        <input type="hidden" id="add_side_type_id">
                                        <div class="col-md-12 mb-4">
                                            <label class="form-label">Part Side</label>
                                            <select class="default-select form-control wide" id="new_part_side">
                                                <option value="">Select Part Side</option>
                                                <?php echo $side_options; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                        <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                            <i class="fa fa-times me-1"></i> Cancel
                                        </button>
                                        <button type="button" class="btn btn-black" id="btnConfirmAddSide">
                                            <i class="fa fa-save me-1"></i> Save
                                        </button>
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
		$('#tableModelType').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>

    <script>

    let table; // global
    
    $(document).ready(function () {

        table = $('#tableModelType').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            pageLength: 10,
            order: [[1, 'asc']],
            ajax: {
                url: 'fetch-model.php',
                type: 'POST',
                data: {
                    action: 'list_model_type'
                }
            },
            columns: [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: ''
                },
                { data: 0 }, // Model Type
                { data: 1 }, // Status
                { data: 2 }  // Action
            ],
            language: {
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: '<i class="fa fa-angle-right"></i>'
                }
            }
        });

        // Add event listener for opening and closing details
        $('#tableModelType tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('dt-hasChild');
            } else {
                // Open this row
                let typeData = row.data();
                // Get typeid from the Action column's data-id attribute (if possible) or update backend to send it.
                // Looking at fetch-model.php, it's in the button's data-id.
                let tempDiv = $('<div>').append(typeData[2]); 
                let typeId = tempDiv.find('.btnEditModel').data('id');

                formatDetailRow(typeId, function(html) {
                    row.child(html).show();
                    tr.addClass('dt-hasChild');
                });
            }
        });

        function formatDetailRow(typeId, callback) {
            // Return a placeholder first
            let placeholder = `
                <div class="p-3 text-center">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>`;
            
            $.ajax({
                url: 'fetch-model.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'get_type_details',
                    type_id: typeId
                },
                success: function(res) {
                    if (res.status === 'success') {
                        let html = `
                            <table class="table child-row-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Part Side Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>`;
                        
                        if (res.data.length > 0) {
                            res.data.forEach((item, index) => {
                                let statusBadge = item.typestatus === 'Y' 
                                    ? '<span class="badge badge-rounded badge-dark fs-12">AC</span>' 
                                    : '<span class="badge badge-rounded badge-meron fs-12">IN</span>';
                                
                                html += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${item.typeside}</td>
                                        <td>${statusBadge}</td>
                                        <td>
                                            <button type="button" class="btn btn-rounded btn-primary btn-xxs btnEditSide"
                                                data-id="${item.typeside_id}"
                                                data-side="${item.typeside}"
                                                data-status="${item.typestatus}"
                                                title="Edit Side">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>`;
                            });
                        } else {
                            html += `
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No side details found for this model type.</td>
                                </tr>`;
                        }
                        
                        html += `</tbody></table>`;
                        callback(html);
                    } else {
                        callback('<div class="p-3 text-danger text-center">Failed to load details.</div>');
                    }
                },
                error: function() {
                    callback('<div class="p-3 text-danger text-center">Connection error.</div>');
                }
            });

            return placeholder;
        }

    });

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

    // // ADD MODEL
    $(document).on('click', '#btnSaveType', function () {

        if (!validateField('#typename', 'Type Name')) return;

        Swal.fire({
            title: 'Add Type',
            text: 'Save this model type?',
            icon: 'question',
            iconColor: "#198754",
            showCancelButton: true,
            confirmButtonColor: '#198754'
        }).then(res => {

            if (!res.isConfirmed) return;

            $.ajax({
                url: 'fetch-model.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'add_type',
                    type_name: $('#typename').val().trim()
                },
                beforeSend: function () {
                    Swal.fire({
                        title: 'Saving...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            title: "Saved",
                            text: "Model type added successfully.",
                            icon: "success",
                            iconColor: "#198754",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#198754"
                        }).then(() => {
                            // window.location.href = "employee-list.php";
                            // location.reload(); 
                            table.ajax.reload(null, false); // reload DataTable

                            // Reset form fields
                            $('#typename').val('');

                            // Remove error borders
                            $('.border-error').removeClass('border-error');
                            
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
                        text: res.message,
                        icon: 'error',
                        iconColor: '#198754', 
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754' 
                    });
                }
            });

        });
    });

    // CONFIRM ADD TYPE (MODAL)
    $(document).on('click', '#btnConfirmAddType', function () {
        let type_name = $('#add_typename').val();

        if (!validateField('#add_typename', 'Type Name')) return;

        Swal.fire({
            title: 'Add New Type',
            text: 'Are you sure you want to add this type?',
            icon: 'question',
            iconColor: "#198754",
            showCancelButton: true,
            confirmButtonColor: '#198754'
        }).then(res => {
            if (!res.isConfirmed) return;

            $.ajax({
                url: 'fetch-model.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'add_type',
                    type_name: type_name
                },
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: 'Model Type added successfully.',
                            icon: 'success',
                            iconColor: "#198754",
                            confirmButtonColor: '#198754'
                        }).then(() => {
                            $('#modalAddType').modal('hide');
                            $('#add_typename').val('');
                            table.ajax.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: res.message,
                            icon: 'error',
                            confirmButtonColor: '#198754'
                        });
                    }
                }
            });
        });
    });

    //EDIT model
    $(document).on('click', '.btnEditModel', function () {

        const type_id = $(this).data('id');

        $.ajax({
            url: 'fetch-model.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_type',
                type_id: type_id
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
                $('#edit_type_id').val(d.typeid);
                $('#edit_type_name').val(d.typemodel);

                if (d.typestatus === 'Y') {
                    $('#type_status').prop('checked', true);
                    $('label[for="type_status"]').text('Active');
                } else {
                    $('#type_status').prop('checked', false);
                    $('label[for="type_status"]').text('Inactive');
                }

                // Show modal first
                $('#typeEditModal').modal('show');
            },
            error: function () {
                Swal.fire('Error', 'Failed to load type data', 'error');
            }
        });
    });

    // OPEN ADD SIDE MODAL
    $(document).on('click', '.btnAddSide', function () {
        const type_id = $(this).data('id');
        $('#add_side_type_id').val(type_id);
        $('#new_part_side').val('').trigger('change');
        if ($.fn.selectpicker) $('#new_part_side').selectpicker('refresh');
        $('#modalAddSide').modal('show');
    });

    // CONFIRM ADD SIDE
    $(document).on('click', '#btnConfirmAddSide', function () {
        let type_id = $('#add_side_type_id').val();
        let typeside = $('#new_part_side').val();

        if (!validateField('#new_part_side', 'Part Side')) return;

        $.ajax({
            url: 'fetch-model.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'add_type_side_mapping',
                typeid: type_id,
                typeside: typeside
            },
            success: function (res) {
                if (res.status === 'success') {
                    Swal.fire({
                        title: 'Success',
                        text: 'Part Side added successfully.',
                        icon: 'success',
                        iconColor: "#198754",
                        confirmButtonColor: '#198754'
                    }).then(() => {
                        $('#modalAddSide').modal('hide');
                        table.ajax.reload(null, false);
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: res.message,
                        icon: 'error',
                        confirmButtonColor: '#198754'
                    });
                }
            }
        });
    });

    // OPEN SIDE EDIT MODAL
    let availableSides = [];
    $(document).on('click', '.btnEditSide', function() {
        const _id = $(this).data('id');
        const _side = $(this).data('side');
        const _status = $(this).data('status');

        $('#edit_side_id').val(_id);
        
        if (_status === 'Y') {
            $('#edit_side_status').prop('checked', true);
        } else {
            $('#edit_side_status').prop('checked', false);
        }

        const populateModal = () => {
            let html = '<option value="">Select Part Side</option>';
            availableSides.forEach(s => {
                html += `<option value="${s}" ${s === _side ? 'selected' : ''}>${s}</option>`;
            });
            $('#edit_side_name').html(html);
            if ($.fn.selectpicker) {
                $('#edit_side_name').selectpicker('refresh');
            }
            $('#sideEditModal').modal('show');
        };

        if (availableSides.length === 0) {
            $.ajax({
                url: 'fetch-model.php',
                type: 'POST',
                dataType: 'json',
                data: { action: 'get_part_sides' },
                success: function(res) {
                    if(res.status === 'success') {
                        availableSides = res.data;
                        populateModal();
                    }
                }
            });
        } else {
            populateModal();
        }
    });

    // UPDATE SIDE
    $('#btnUpdateSide').on('click', function() {
        if(!validateField('#edit_side_name', 'Part Side Name')) return;

        let statusVal = $('#edit_side_status').is(':checked') ? 'Y' : 'N';

        $.ajax({
            url: 'fetch-model.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_type_side',
                typeside_id: $('#edit_side_id').val(),
                typeside: $('#edit_side_name').val(),
                typestatus: statusVal
            },
            success: function(res) {
                if(res.status === 'success') {
                    Swal.fire({
                        title: "Saved",
                        text: res.message,
                        icon: "success",
                        iconColor: "#198754",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#198754"
                    }).then(() => {
                        $('#sideEditModal').modal('hide');
                        // Fast reload by destroying child rows and triggering rebuild logic if desired,
                        // For now we can reload the whole table and user will need to re-expand.
                        table.ajax.reload(null, false);
                    });
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Failed to update part side', 'error');
            }
        });
    });

    //UPDATE
    $('#btnUpdateType').on('click', function () {

        let typeStatus = $('#type_status').is(':checked') ? 'Y' : 'N';

        $.ajax({
            url: 'fetch-model.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_type',
                type_id: $('#edit_type_id').val(),
                type_name: $('#edit_type_name').val(),
                typeStatus : typeStatus
            },
            success: function (res) {
                if (res.status === 'success') {
                    if (res.status === 'success') {
                            Swal.fire({
                                title: "Saved",
                                text: "Model Type updated successfully.",
                                icon: "success",
                                iconColor: "#198754",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#198754"
                            }).then(() => {                                
                                $('#typeEditModal').modal('hide');

                                console.log('Reloading table...');
                                table.ajax.reload(null, false); // reload DataTable
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
            }
        });
    });

    $(document).on('change', '#type_status', function() {
        if($(this).is(':checked')) {
            $('label[for="type_status"]').text('Active');
        } else {
            $('label[for="type_status"]').text('Inactive');
        }
    });

    </script>

</body>
</html>