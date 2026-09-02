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

		#tableCompany tbody tr td:last-child {
            text-align: left !important; 
        }

        #tableCompany thead tr th:last-child{
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
                                        <h6 class="card-title">Company List</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tableCompany" class="display table mb-1 table-striped-thead table-wide table-md">
                                                <thead class="thead-black">
                                                    <tr>
                                                        <th>Company Name</th>
                                                        <th>Division</th>
                                                        <th>Branch</th>
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
                                                        <i class="fa fa-building me-2 text-black"></i>
                                                        Add Company
                                                    </h4>
                                                    <small class="text-muted d-block">
                                                        Register new company
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Company code</label>
                                                    <input type="text" class="form-control" id="compcode">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Company Name</label>
                                                    <input type="text" class="form-control" id="compname">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Code Company</label>
                                                    <input type="text" class="form-control" id="code">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Division</label>
                                                    <select class="select2-width-50" style="width: 50%" id="division">
                                                        <?php
                                                        $d = mysqli_query($db_con,
                                                            "SELECT division_id, division FROM division WHERE division_status='AC'");
                                                        while ($row = mysqli_fetch_assoc($d)) {                                                            
                                                            echo "<option value='{$row['division_id']}' $sel>{$row['division']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Country</label>
                                                    <select class="select2-width-50" style="width: 50%" id="country">
                                                        <?php
                                                        $d = mysqli_query($db_con,
                                                            "SELECT country_id, country FROM country WHERE country_status='AC'");
                                                        while ($row = mysqli_fetch_assoc($d)) {                                                            
                                                            echo "<option value='{$row['country_id']}' $sel>{$row['country']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="button" class="btn btn-black" id="btnSaveCompany">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>

                            <!-- Modal update company -->
                            <div class="modal fade" id="companyEditModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-sm">

                                        <div class="modal-header border-bottom-0">
                                            <!-- <h5 class="modal-title fw-semibold text-dark">
                                                <i class="fa fa-building me-2 text-primary"></i>Edit Company
                                            </h5> -->
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body px-4 py-3">

                                            <input type="hidden" id="edit_company_id">

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Company Code</label>
                                                    <input type="text" class="form-control" id="edit_company_code" placeholder="Enter Company Code">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Company Name</label>
                                                    <input type="text" class="form-control" id="edit_company_name" placeholder="Enter Company Name">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Code Company</label>
                                                    <input type="text" class="form-control" id="edit_code_comp" placeholder="Enter Code">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Division</label>
                                                    <select class="form-select form-select-sm select2" id="edit_division" style="width: 100%">
                                                        <?php
                                                        $d = mysqli_query($db_con,
                                                            "SELECT division_id, division FROM division WHERE division_status='AC'");
                                                        while ($row = mysqli_fetch_assoc($d)) {                                                            
                                                            echo "<option value='{$row['division_id']}' $sel>{$row['division']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-4">
                                                    <label class="form-label">Country</label>
                                                    <select class="form-select form-select-sm select2" id="edit_country" style="width: 100%">
                                                        <?php
                                                        $d = mysqli_query($db_con,
                                                            "SELECT country_id, country FROM country WHERE country_status='AC'");
                                                        while ($row = mysqli_fetch_assoc($d)) {                                                            
                                                            echo "<option value='{$row['country_id']}' $sel>{$row['country']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-md-3">
                                                        <label class="form-label mb-md-0">Status</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" role="switch" id="comp_status" checked>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                            <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                                <i class="fa fa-times me-1"></i> Cancel
                                            </button>
                                            <button type="button" class="btn btn-black" id="btnUpdateCompany">
                                                <i class="fa fa-save me-1"></i> Save Changes
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Modal view branch -->
                            <div class="modal fade" id="branchModal" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Branch List</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <ul id="branchList" class="list-group"></ul>
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

    <script>

    //to apply select style to non select2
    //select with no filter
    // $('.default-select').select2({
    //     minimumResultsForSearch: Infinity, // Hide search box if not needed
    //     width: '100%'
    // });

    </script>

    <script>

    document.getElementById('btnBack').addEventListener('click', function () {
        history.back();
    });

    </script>

    <script>

	$(function () {
		$('[data-bs-toggle="tooltip"]').tooltip(); // run on page load

		// run again after table draw
		$('#tableCompany').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>


    <script>

    let table; // global
    
    $(document).ready(function () {

        table = $('#tableCompany').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            pageLength: 10,
            order: [[0, 'asc']],
            ajax: {
                url: 'fetch-organizational.php',
                type: 'POST',
                data: {
                    action: 'list_company'
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

    // ADD COMPANY
    $(document).on('click', '#btnSaveCompany', function () {

        if (!validateField('#compcode', 'Company Code')) return;
        if (!validateField('#compname', 'Company Name')) return;
        if (!validateField('#code', 'Code Company')) return;
        if (!validateField('#division', 'Division')) return;
        if (!validateField('#country', 'Country')) return;

        Swal.fire({
            title: 'Add Company',
            text: 'Save this company information?',
            icon: 'question',
            iconColor: "#198754",
            showCancelButton: true,
            confirmButtonColor: '#198754'
        }).then(res => {

            if (!res.isConfirmed) return;

            $.ajax({
                url: 'fetch-organizational.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'add_company',
                    company_code: $('#compcode').val().trim(),
                    company_name: $('#compname').val().trim(),
                    code_comp: $('#code').val().trim(),
                    division_id: $('#division').val(),
                    country_id: $('#country').val()
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
                                text: "Company added successfully.",
                                icon: "success",
                                iconColor: "#198754",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#198754"
                            }).then(() => {
                                // window.location.href = "employee-list.php";
                                // location.reload(); 
                                table.ajax.reload(null, false); // reload DataTable

                                // Reset form fields
                                $('#compcode').val('');
                                $('#compname').val('');
                                $('#code').val('');
                                $('#division').val(null).trigger('change'); // Select2 reset
                                $('#country').val(null).trigger('change');  // Select2 reset

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

    $(document).ready(function () {
        $('#edit_division, #edit_country').select2({
            dropdownParent: $('#companyEditModal'),
            width: '50%'
        });
    });

    //EDIT COMPANY
    $(document).on('click', '.btnEditCompany', function () {

        const company_id = $(this).data('id');

        $.ajax({
            url: 'fetch-organizational.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_company',
                company_id: company_id
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
                $('#edit_company_id').val(d.company_id);
                $('#edit_company_code').val(d.company_code);
                $('#edit_company_name').val(d.company);
                $('#edit_code_comp').val(d.code_comp);

                // Show modal first
                $('#companyEditModal').modal('show');

                // Then set select2 values
                setTimeout(() => {
                    $('#edit_division').val(String(d.division_id)).trigger('change');
                    $('#edit_country').val(String(d.country_id)).trigger('change');
                }, 150);
            },
            error: function () {
                Swal.fire('Error', 'Failed to load company data', 'error');
            }
        });
    });

    //UPDATE
    $('#btnUpdateCompany').on('click', function () {

        let compStatus = $('#comp_status').is(':checked') ? 'AC' : 'IN';

        $.ajax({
            url: 'fetch-organizational.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_company',
                company_id: $('#edit_company_id').val(),
                company_code: $('#edit_company_code').val(),
                company_name: $('#edit_company_name').val(),
                code_comp: $('#edit_code_comp').val(),
                division_id: $('#edit_division').val(),
                country_id: $('#edit_country').val(),
                compStatus:compStatus
            },
            success: function (res) {
                if (res.status === 'success') {
                    if (res.status === 'success') {
                            Swal.fire({
                                title: "Saved",
                                text: "Company updated successfully.",
                                icon: "success",
                                iconColor: "#198754",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#198754"
                            }).then(() => {                                
                                $('#companyEditModal').modal('hide');

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

    // View all branch
    $(document).on("click", ".branch-badge", function () {

        let company = $(this).data("company");

        $.ajax({
            url: "fetch-branches.php",
            type: "POST",
            dataType: "json",
            data: { company_id: company },

            success: function(res){

                $("#branchList").empty();

                if(res.length === 0){
                    $("#branchList").append(
                        `<li class="list-group-item text-muted">No branches found</li>`
                    );
                } 
                else {
                    res.forEach(row => {
                        
                        let code = row.branch_code ?? '';
                        let name = row.branch_name ?? '';

                        $("#branchList").append(
                            `<li class="list-group-item">
                                <strong>${code}</strong> — ${name}
                            </li>`
                        );
                    });
                }

                let modal = new bootstrap.Modal(document.getElementById('branchModal'));
                modal.show();
            }
        });

    });

    </script>

</body>
</html>