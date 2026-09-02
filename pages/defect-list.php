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
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    
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

        <?php

        $sql = "
            SELECT areamax
            FROM defect_area
            LIMIT 1
        ";

        $stmt = $db_con->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        ?>

        <style>

		#tableDefect tbody tr td:last-child {
            text-align: left !important; 
        }

        #tableDefect thead tr th:last-child{
            text-align: left !important;
        }

        </style>

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
                                        <h6 class="card-title">Defect List</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tableDefect" class="display table mb-1 table-striped-thead table-wide table-md">
                                                <thead class="thead-black">
                                                    <tr>                                                  
                                                        <th>Defect Name</th>                                                     
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
                                                        Add Defect
                                                    </h4>
                                                    <small class="text-muted d-block">
                                                        Register new defect
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3 mb-3">
                                                    <label class="form-label">Defect Name</label>
                                                    <input type="text" class="form-control" id="defectname">
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="button" class="btn btn-black" id="btnSaveDefect">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="d-block w-100">
                                                    <h4 class="heading mb-1">
                                                        <i class="fa fa-cog me-2 text-black"></i>
                                                        Defect Area

                                                    </h4>
                                                    <small class="text-muted d-block">
                                                        State maximum area of defect. This value will be apply in inspection.
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3 mb-3">
                                                    <label class="form-label">Maximum Area</label>                                                    
                                                    <input type="number" class="form-control w-50" id="maxdefectarea" placeholder="" value="<?= $row['areamax'] ?>">
                                                    <div id="emailHelp1" class="form-text fs-12">
                                                        This range of number control the maximum area of defect.
                                                        <svg class="ms-1 c-pointer" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="<img src='images/Screenshot_defect_area.png' width='450' style='border-radius:6px'>" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        
                                                        <path d="M8.00016 14.6663C11.6821 14.6663 14.6668 11.6816 14.6668 7.99967C14.6668 4.31778 11.6821 1.33301 8.00016 1.33301C4.31826 1.33301 1.3335 4.31778 1.3335 7.99967C1.3335 11.6816 4.31826 14.6663 8.00016 14.6663Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M8 10.6667V8" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M8 5.33301H8.00667" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                       
                                                        </svg> 
                                                    </div>   
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="button" class="btn btn-black" id="btnSaveArea">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>

                            <!-- Modal update model -->
                            <div class="modal fade" id="defectEditModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content border-0 shadow-sm">

                                        <div class="modal-header border-bottom-0">
                                            <!-- <h5 class="modal-title fw-semibold text-dark">
                                                <i class="fa fa-building me-2 text-primary"></i>Edit Company
                                            </h5> -->
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body px-4 py-3">

                                            <input type="hidden" id="edit_defect_id">                                            
                                
                                            <div class="col-md-12 mb-4">
                                                <label class="form-label">Defect Name</label>
                                                <input type="text" class="form-control" id="edit_defect_name" placeholder="Enter Defect Name">
                                            </div>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Status</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="defect_status" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                            <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                                <i class="fa fa-times me-1"></i> Cancel
                                            </button>
                                            <button type="button" class="btn btn-black" id="btnUpdateDefect">
                                                <i class="fa fa-save me-1"></i> Save Changes
                                            </button>
                                        </div>

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

    <script src="vendor/nouislider/nouislider.min.js"></script>
    <script src="vendor/wnumb/wNumb.js"></script>
    <script src="js/plugins-init/nouislider-init.js"></script>

    


    <script>

    //to apply select style to non select2
    //select with no filter
    // $('.default-select').select2({
    //     minimumResultsForSearch: Infinity, // Hide search box if not needed
    //     width: '100%'
    // });

    </script>

    <script>

	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })

	</script>

    <script>

    let table; // global
    
    $(document).ready(function () {

        table = $('#tableDefect').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            pageLength: 10,
            order: [[0, 'asc']],
            ajax: {
                url: 'fetch-defect.php',
                type: 'POST',
                data: {
                    action: 'list_defect'
                }
            },
            language: {
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: '<i class="fa fa-angle-right"></i>'
                }
            }
        });

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
    $(document).on('click', '#btnSaveDefect', function () {

        if (!validateField('#defectname', 'Defect Name')) return;

        Swal.fire({
            title: 'Add Defect',
            text: 'Save this defect?',
            icon: 'question',
            iconColor: "#198754",
            showCancelButton: true,
            confirmButtonColor: '#198754'
        }).then(res => {

            if (!res.isConfirmed) return;

            $.ajax({
                url: 'fetch-defect.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'add_defect',
                    defect_name: $('#defectname').val().trim()
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
                            text: "defect added successfully.",
                            icon: "success",
                            iconColor: "#198754",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#198754"
                        }).then(() => {
                            // window.location.href = "employee-list.php";
                            // location.reload(); 
                            table.ajax.reload(null, false); // reload DataTable

                            // Reset form fields
                            $('#defectname').val('');

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

    //EDIT model
    $(document).on('click', '.btnEditDefect', function () {

        const defect_id = $(this).data('id');

        $.ajax({
            url: 'fetch-defect.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_defect',
                defect_id: defect_id
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
                $('#edit_defect_id').val(d.defectid);
                $('#edit_defect_name').val(d.defectname);

                if (d.defectstatus === 'Y') {
                    $('#defect_status').prop('checked', true);
                } else {
                    $('#defect_status').prop('checked', false);
                }

                // Show modal first
                $('#defectEditModal').modal('show');
            },
            error: function () {
                Swal.fire('Error', 'Failed to load type data', 'error');
            }
        });
    });

    //UPDATE
    $('#btnUpdateDefect').on('click', function () {

        let defectStatus = $('#defect_status').is(':checked') ? 'Y' : 'N';

        $.ajax({
            url: 'fetch-defect.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_defect',
                defect_id: $('#edit_defect_id').val(),
                defect_name: $('#edit_defect_name').val(),
                defectStatus : defectStatus
            },
            success: function (res) {
                if (res.status === 'success') {
                    if (res.status === 'success') {
                            Swal.fire({
                                title: "Saved",
                                text: "Defect updated successfully.",
                                icon: "success",
                                iconColor: "#198754",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#198754"
                            }).then(() => {                                
                                $('#defectEditModal').modal('hide');

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

    // // EDIT MAXIMUM NO
    $(document).on('click', '#btnSaveArea', function () {

        if (!validateField('#maxdefectarea', 'Maximum Area')) return;

        Swal.fire({
            title: 'Update maximum area',
            text: 'Save this maximum area of defect?',
            icon: 'question',
            iconColor: "#198754",
            showCancelButton: true,
            confirmButtonColor: '#198754'
        }).then(res => {

            if (!res.isConfirmed) return;

            $.ajax({
                url: 'fetch-defect.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'edit_area_defect',
                    defect_area: $('#maxdefectarea').val().trim()
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
                            text: "Maimum defect area added successfully.",
                            icon: "success",
                            iconColor: "#198754",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#198754"
                        }).then(() => {
                            // location.reload(); 
                            table.ajax.reload(null, false); // reload DataTable

                            // Remove error borders
                            $('.border-error').removeClass('border-error');
                            
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: res.message,
                            icon: 'error',
                            iconColor: '#b02424ff', 
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
                        iconColor: '#b02424ff', 
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754' 
                    });
                }
            });

        });
    });

    </script>

</body>
</html>