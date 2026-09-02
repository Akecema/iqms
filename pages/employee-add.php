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

		#tableEmployee tbody tr td:last-child {
            text-align: left !important; 
        }

        #tableEmployee thead tr th:last-child{
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
                                        <h6 class="card-title">Employee Info</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="#" class="mt-2">
                                            <div class="row mb-4">
                                          
                                                <div class="col-md-3">
                                                    <!-- <label class="form-label mb-md-0">Photo</label> -->
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="d-inline-block position-relative me-4 mb-3 mb-lg-0 account-profile">
                                                        <div class="avatar-preview rounded">
                                                            <div id="imagePreview" class="rounded-4 profile-avatar" style="background-image: url('images/avatar/pic7.jpg');"></div>
                                                        </div>                                                        
                                                        <div class="upload-link" title="" data-toggle="tooltip" data-placement="right" data-original-title="update">
                                                            <input type="file" class="update-flie" id="imageUpload" accept="image/*">
                                                            <i class="fa-solid fa-pen-to-square fs-16"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>     
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Staff Id <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="estaff_id" value="">   
                                                </div>
                                            </div>                                         
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Identification No  <span class="text-danger">*</span></label> 
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="eic_no" value="">
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Full Name <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-sm-68">
                                                            <input type="text" class="form-control" id="efullname" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Short Name <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" id="eshortname" value="">
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Designation <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select class="form-control select2-width-50" id="edesignation">
                                                        <option value="">Select Designation</option>
                                                        <?php
                                                        $ds = mysqli_query($db_con,
                                                            "SELECT design_id, design_name FROM designation WHERE design_status='AC'  ORDER BY design_name ASC");
                                                            while ($row = mysqli_fetch_assoc($ds)) {
                                                                echo "<option value='{$row['design_id']}' $sel>{$row['design_name']}</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Contact Phone</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" id="econtact" value="">
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Company <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select class="form-control select2-width-50" id="ecompany" onchange="getBranch(this.value)">
                                                        <option value="">Select Company</option>
                                                        <?php
                                                        $q = mysqli_query($db_con,
                                                            "SELECT company_id, company FROM company WHERE company_status='AC' ORDER BY company ASC");
                                                                while ($c = mysqli_fetch_assoc($q)) {
                                                                    echo "<option value='{$c['company_id']}' $selected>{$c['company']}</option>";
                                                                }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Branch</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div id="div_type">
                                                        <select class="form-control select2-filter" id="ebranch">
                                                            <option value="">Select Branch</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Department <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select class="select2-width-50" style="width: 50%" id="edepartment">
                                                        <option value="">Select Department</option>
                                                        <?php
                                                        $d = mysqli_query($db_con,
                                                            "SELECT dept_id, dept_name FROM department WHERE dept_status='AC' ORDER BY dept_name ASC");
                                                        while ($row = mysqli_fetch_assoc($d)) {
                                                            echo "<option value='{$row['dept_id']}' $sel>{$row['dept_name']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Email <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="email" class="form-control" id="eemail" value="">
                                                </div>
                                            </div>                                             
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">HOD <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                   <select class="select2-width-50" id="eapproval">
                                                    <option value="">Select Approver</option>

                                                    <?php
                                                    $sql = "
                                                        SELECT DISTINCT
                                                            e.staff_id,
                                                            e.staff_name,
                                                            e.identification_no,
                                                            p.photo_name
                                                        FROM user_roles r
                                                        INNER JOIN employee_details e 
                                                            ON r.staff_id = e.staff_id
                                                        LEFT JOIN employee_photo p 
                                                            ON e.identification_no = p.identification_no
                                                        WHERE 
                                                            r.role != 4
                                                            AND e.account_status = 'AC'
                                                        ORDER BY e.staff_name ASC
                                                    ";

                                                    $result = mysqli_query($db_con, $sql);

                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                        $photo = '../photo/' . $row['photo_name'];

                                                        echo "<option value='{$row['staff_id']}' data-img='{$photo}' $sel>{$row['staff_name']}</option>";
                                                    }
                                                    ?>
                                                </select>    

                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Role <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select class="select2-width-50" style="width: 50%" id="erole">
                                                        <option value="">Select Role</option>
                                                        <?php
                                                        $d = mysqli_query($db_con,
                                                            "SELECT role_id, role_name FROM roles");
                                                        while ($row = mysqli_fetch_assoc($d)) {
                                                            echo "<option value='{$row['role_id']}' $sel>{$row['role_name']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Account Status</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="account_status" checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-light ms-2" onclick="window.location.href='employee-list.php';">Cancel</button>
                                        <button type="button" class="btn btn-black ms-2" id="btnSaveEmployee">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div> 
            </div>

            <a href="javascript:void(0);" class="btn btn-black btn-lg rounded-circle back-button" id="btnBack" title="Go Back">
                <i class="fa fa-arrow-left"></i>
            </a>
               
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

    function getBranch(compId){
        
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    $('#div_type').html(response); 
                } 
            }
        };
        xhr.open("GET", "find-branch.php?comp_id=" + compId, true);
        xhr.send();
    }

    </script>

    <script>

	$(function () {
		$('[data-bs-toggle="tooltip"]').tooltip(); // run on page load

		// run again after table draw
		$('#tableEmployee').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>

    <script>

    document.getElementById('btnBack').addEventListener('click', function () {
        history.back();
    });

    </script>

    <script>
    
    //Approver photo
    function formatUser(option) {
        if (!option.id) return option.text;

        const img = $(option.element).data('img');
        const name = option.text;

        return $(`
            <div style="display:flex; align-items:center; gap:10px;">
            <img src="${img}" 
                style="width:28px;height:28px;border-radius:50%;object-fit:cover;">
            <span>${name}</span>
            </div>
        `);
    }

    $('#eapproval').select2({
        placeholder: "Select user",
        allowClear: true,
        templateResult: formatUser,
        templateSelection: formatUser,
        minimumResultsForSearch: 0
    });

    </script>

    <script>

    $(document).ready(function () {
        loadAuthorization();
    });

    function loadAuthorization() {

        let staff_id = $('#auth_staff_id').val();
        if (!staff_id) return;

        $.ajax({
            url: 'fetch-employee.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_authorization',
                staff_id: staff_id
            },
            success: function (res) {

                if (res.status !== 'success') return;

                let a = res.data;

                // Inspection
                $('#pdi_reviewer').prop('checked', a.PDI_reviewer === 'Y');

                // Sorting Report
                $('#SR_reviewer').prop('checked', a.SR_reviewer === 'Y');

                // S2W
                $('#s2w_reviewer').prop('checked', a.S2W_reviewer === 'Y');
                $('#s2w_approver').prop('checked', a.S2W_approver === 'Y');

                // S2W Report
                $('#s2w_acknowledger').prop('checked', a.S2W_acknowledger === 'Y');
            }
        });
    }

    </script>

    <script>
    
    // ==============================
    // FORM VALIDATION (REUSABLE)
    // ==============================
    function validateField(id, label) {
        let val = $(id).val();

        // for Select2, value may be null
        if (!val || val.toString().trim() === "") {
            $(id).addClass("border-error");            
            $(id).next('.select2').find('.select2-selection').addClass('border-error');

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

    // Email validation
    function validateEmail(id) {
        let email = $(id).val().trim();
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!regex.test(email)) {
            $(id).addClass("border-error");
            Swal.fire("Invalid Email", "Please enter a valid email address.", "warning")
            .then(() => {
                scrollToField(id);
                $(id).focus();
            });

            return false;
        }

        $(id).removeClass("border-error");
        return true;
    }

    // Scroll helper
    function scrollToField(id) {
        $('html, body').animate({
            scrollTop: $(id).offset().top - 120
        }, 500);
    }

    function toUpperCaseField(id) {
        $(id).on('input', function () {
            this.value = this.value.toUpperCase();
        });
    }

    $(document).ready(function () {
        toUpperCaseField('#efullname');
        toUpperCaseField('#eshortname');
    });

    // Image upload
    $("#imageUpload").on("change", function () {

        let file = this.files[0];
        if (!file) return;

        // only images
        if (!file.type.match('image.*')) {
            Swal.fire("Invalid File","Please upload an image.","error");
            return;
        }

        let reader = new FileReader();

        reader.onload = function(e){
            $("#imagePreview").css("background-image", "url(" + e.target.result + ")");
        }

        reader.readAsDataURL(file);
    });

    // SAVE INFO
    $(document).on('click', '#btnSaveEmployee', function () {

        // =========================
        // VALIDATION (ORDERED)
        // =========================
        if (!validateField("#estaff_id", "Staff Id")) return;
        if (!validateField("#eic_no", "Identification No")) return;
        if (!validateField("#efullname", "Full Name")) return;
        if (!validateField("#eshortname", "Short Name")) return;
        if (!validateField("#edesignation", "Designation")) return;
        if (!validateField("#ecompany", "Company")) return;
        if (!validateField("#edepartment", "Department")) return;
        if (!validateField("#eemail", "Email")) return;
        if (!validateEmail("#eemail")) return;
        if (!validateField("#eapproval", "HOD")) return;
        if (!validateField("#erole", "Role")) return;

        let account_status = $('#account_status').is(':checked') ? 'AC' : 'IN';

        let formData = new FormData();

        formData.append("action","add_employee");
        formData.append("staff_id", $("#estaff_id").val());
        formData.append("staff_name", $("#efullname").val());
        formData.append("short_name", $("#eshortname").val());
        formData.append("icno", $("#eic_no").val());
        formData.append("staff_email", $("#eemail").val());
        formData.append("company", $("#ecompany").val());
        formData.append("branch", $("#ebranch").val());
        formData.append("department", $("#edepartment").val());
        formData.append("designation", $("#edesignation").val());
        formData.append("contact", $("#econtact").val());
        formData.append("approval", $("#eapproval").val());
        formData.append("account_status", account_status);
        formData.append("role", $("#erole").val());

        // Add photo ONLY if uploaded
        if ($('#imageUpload')[0].files.length > 0) {
            formData.append("photo", $('#imageUpload')[0].files[0]);
        }

        // =========================
        // CONFIRM SAVE
        // =========================
        Swal.fire({
            title: "Save",
            text: "Save this employee information?",
            icon: "question",
            iconColor: "#198754",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            confirmButtonColor: "#286912"
            }).then(res => {

                if (!res.isConfirmed) return;

                $.ajax({
                    url: "fetch-employee.php",
                    type: "POST",
                    dataType: "json",
                    data: formData,                    
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        Swal.fire({
                            title: "Saving...",
                            text: "Please wait while we save the employee record.",
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },
                    success: function (res) {

                        if (res.status === "success") {

                            Swal.fire({
                                title: "Saved!",
                                text: "Employee information saved successfully.",
                                icon: "success",
                                iconColor: "#198754",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#198754"
                            }).then(() => {
                                // window.location.href = "employee-list.php";
                                window.location.href = "employee-edit.php?sid=" + encodeURIComponent(res.staff_id);
                            });

                        } else {
                            Swal.fire({
                            title: "Error",
                            text: res.message || "Save failed.",
                            icon: "error",
                            iconColor: "#b02424ff",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#b02424ff"
                        });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: "Error",
                            text: "Server error. Please try again.",
                            icon: "error",
                            iconColor: "#b02424ff",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#b02424ff"
                        });
                    }
                });

            });
    });

    </script>  

</body>
</html>