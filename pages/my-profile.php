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

        <?php
        
        
        if (!isset($_GET['sid'])) {
            exit('Invalid request');
        }

        $staff_id = base64_decode($_GET['sid']);

        $sql = "
            SELECT 
                e.staff_id,
                e.staff_name,
                e.short_name,
                e.identification_no,
                e.staff_email,
                e.company,
                e.branch,
                e.department,
                e.designation,
                e.contact_no,
                e.account_status,
                c.company AS company_name,
                n.design_name,
                t.dept_name,
                b.branch_name,
                p.appraisor as hod,
                h.staff_name as appraisor_name,
                s.role_name, 
                r.role
            FROM employee_details e
            LEFT JOIN employee_approval p ON e.staff_id = p.staff_id
            LEFT JOIN employee_details h ON p.appraisor = h.staff_id
            LEFT JOIN company c ON e.company = c.company_id
            LEFT JOIN designation n ON e.designation = n.design_id
            LEFT JOIN department t ON e.department = t.dept_id
            LEFT JOIN branch b ON e.branch = b.branch_id
            LEFT JOIN user_roles r ON e.staff_id = r.staff_id 
            LEFT JOIN roles s ON r.role = s.role_id 
            WHERE e.staff_id = ?";

        $stmt = $db_con->prepare($sql);
        $stmt->bind_param("s", $staff_id);
        $stmt->execute();
        $emp = $stmt->get_result()->fetch_assoc();

        if (!$emp) {
            exit('Employee not found');
        }

        //photo
        $gst_photo2 = ''; // default empty

        $gsel_cphoto2 = "
            SELECT photo_name 
            FROM employee_photo 
            WHERE identification_no = ?
            LIMIT 1
        ";

        $gstmtr_cphoto2 = $db_con->prepare($gsel_cphoto2);
        $gstmtr_cphoto2->bind_param("s", $emp['identification_no']);
        $gstmtr_cphoto2->execute();

        $grst_cphoto2 = $gstmtr_cphoto2->get_result();

        if ($grst_cphoto2 && $grst_cphoto2->num_rows > 0) {
            $grow_cphoto2 = $grst_cphoto2->fetch_assoc();
            $gst_photo2   = $grow_cphoto2['photo_name'];
        }

        $photoPath = (!empty($gst_photo2) && file_exists("../photo/".$gst_photo2))
                        ? "../photo/".$gst_photo2
                        : "images/avatar/pic7.jpg";
    
        //PRODUCTION
        // $imgServer = "http://172.18.1.14";

        // $path = "'.$imgServer.'/'.'Appraisal/photo/".$gst_photo2;
        // $path2 = "'.$imgServer.'/'.'Appraisal/assets/images/faces/9.jpg'";

        
        // if($gst_photo2 > 0 )
        // {    
        //     $profile_photo = $imgServer.'/'.'Appraisal/photo/'.$gst_photo2;
        // }
        // else
        // {
        //     $profile_photo = $imgServer.'/'.'Appraisal/assets/images/faces/9.jpg';
        // }
        
        // $photoPath = (!empty($gst_photo2) && file_exists($path))
        //                 ? $path
        //                 : $path2;
    
        ?>

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
                            <div class="col-xl-5">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title">Employee Info</h6>
                                    </div>
                                    <div class="card-body">

                                        <div class="row mb-4">
                                            <input type="hidden" id="staff_id" value="<?= $emp['staff_id']; ?>">
                                            <div class="col-md-3">
                                                <!-- <label class="form-label mb-md-0">Photo</label> -->
                                            </div>
                                            <div class="col-md-9">
                                                <div class="d-inline-block position-relative me-4 mb-3 mb-lg-0 account-profile">
                                                    <div class="avatar-preview rounded">
                                                        <div id="imagePreview" class="rounded-4 profile-avatar" style="background-image: url('<?= $photoPath ?>');"></div>
                                                    </div>
                                                    <!-- <div class="upload-link" title="" data-toggle="tooltip" data-placement="right" data-original-title="update">
                                                        <input type="file" class="update-flie" id="imageUpload">
                                                        <i class="fa-solid fa-pen-to-square fs-16"></i>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="d-flex align-items-center border-bottom py-3 text-primary">
                                            <div class="avatar avatar-md rounded d-flex align-items-center justify-content-center bg-white mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-badge" viewBox="0 0 16 16">
                                                    <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                                    <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492z"/>
                                                </svg>
                                            </div>
                                            <div class="clearfix ms-2">
                                                <h6 class="mb-0 fw-semibold">Name</h6>
                                                <span class="fs-13"><?= htmlspecialchars($emp['staff_name']); ?></span> <br>
                                                <span class="fs-13"><?= htmlspecialchars($emp['staff_id']); ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center border-bottom py-3 text-primary">
                                            <div class="avatar avatar-md rounded d-flex align-items-center justify-content-center bg-white mb-2 text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-vcard" viewBox="0 0 16 16">
                                                    <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5"/>
                                                    <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z"/>
                                                </svg>
                                            </div>
                                            <div class="clearfix ms-2">
                                                <h6 class="mb-0 fw-semibold">Identifiction No</h6>
                                                <span class="fs-13"><?= htmlspecialchars($emp['staff_id']); ?></span>
                                            </div>
                                        </div>
                                         <div class="d-flex align-items-center border-bottom py-3">
                                            <div class="avatar avatar-md rounded d-flex align-items-center justify-content-center bg-white mb-4 text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                                    <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                                                    <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z"/>
                                                </svg>
                                            </div>
                                            <div class="clearfix ms-2">
                                                <h6 class="mb-0 fw-semibold">Company</h6>
                                                <span class="fs-13"><?= $emp['company_name']; ?></span><br>
                                                <span class="fs-13"><?= $emp['branch_name']; ?></span>
                                            </div>
                                        </div>
                                         <div class="d-flex align-items-center border-bottom py-3">
                                            <div class="avatar avatar-md rounded d-flex align-items-center justify-content-center bg-white mb-4  text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-bounding-box" viewBox="0 0 16 16">
                                                    <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5"/>
                                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                                </svg>
                                            </div>
                                            <div class="clearfix ms-2">
                                                <h6 class="mb-0 fw-semibold">Designation</h6>
                                                <span class="fs-13"><?= $emp['design_name']; ?></span></br>
                                                <span class="fs-13"><?= $emp['dept_name']; ?></span>
                                            </div>
                                        </div>
                                         <div class="d-flex align-items-center border-bottom py-3 ">
                                            <div class="avatar avatar-md rounded d-flex align-items-center justify-content-center bg-white mb-2 text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                                                </svg>
                                            </div>
                                            <div class="clearfix ms-2">
                                                <h6 class="mb-0 fw-semibold">Email</h6>
                                                <span class="fs-13"><?= htmlspecialchars($emp['staff_email']); ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center border-bottom py-3">
                                            <div class="avatar avatar-md rounded d-flex align-items-center justify-content-center bg-white mb-0 text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                                                </svg>
                                            </div>
                                            <div class="clearfix ms-2">
                                                <h6 class="mb-0 fw-semibold">Contact No</h6>
                                                <span class="fs-13"><?= htmlspecialchars($emp['contact_no']); ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center border-bottom py-3">
                                            <div class="avatar avatar-md rounded d-flex align-items-center justify-content-center bg-white  mb-0 text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                                    <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                                </svg>
                                            </div>
                                            <div class="clearfix ms-2">
                                                <h6 class="mb-0 fw-semibold">HOD</h6>
                                                <span class="fs-13"><?= htmlspecialchars($emp['appraisor_name']); ?></span>
                                            </div>
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
                                                        <i class="fa fa-user-check me-2 text-black"></i>
                                                        Approval Authorization
                                                    </h4>
                                                    <small class="text-muted d-block">
                                                        Assign review, approval, and acknowledgment roles
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <form action="#">
                                                    <input type="hidden" id="auth_staff_id" value="<?= $emp['staff_id'] ?>">
                                                    <div class="clearfix border-bottom py-3 pt-0">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-6">
                                                                <label class="form-label mb-md-0">Inspection</label>
                                                            </div>
                                                            <div class="col-sm-3 col-6">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input readonly-check mb-0" id="pdi_reviewer">
                                                                    <label class="form-check-label mb-0" for="checkboxNotEmail">Reviewer</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix border-bottom py-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-6">
                                                                <label class="form-label mb-md-0">Sorting Report </label>
                                                            </div>
                                                            <div class="col-sm-3 col-6">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input readonly-check mb-0" id="SR_reviewer">
                                                                    <label class="form-check-label mb-0" for="checkboxBillPhone">Reviewer</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix border-bottom py-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-6">
                                                                <label class="form-label mb-md-0">S2W</label>
                                                            </div>
                                                            <div class="col-sm-3 col-6">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input readonly-check mb-0" id="s2w_reviewer">
                                                                    <label class="form-check-label mb-0" for="checkboxTeamEmail">Reviewer</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 col-6">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input readonly-check mb-0" id="s2w_approver">
                                                                    <label class="form-check-label mb-0" for="">Approver</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix py-3 pb-0">
                                                        <div class="row align-items-start">
                                                            <!-- LABEL -->
                                                            <div class="col-sm-6">
                                                                <label class="form-label mb-md-0">S2W Report</label>
                                                            </div>
                                                            <div class="col-sm-3 col-6">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input readonly-check mb-0" id="s2w_acknowledger">
                                                                    <label class="form-check-label mb-0" for="">Acknowledger</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>  
                    </div>
                </div> 
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
            <div class="copyright">
                <p>Copyright © Developed by Ingress Industrial (Malaysia) Sdn Bhd. <span class="current-year">2025</span></p>
            </div>
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
		$('#tableEmployee').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>

    <script>
    
    // ==============================
    // FORM VALIDATION (REUSABLE)
    // ==============================
   $('.readonly-check').on('click', function(e){
        e.preventDefault();
    });

    // Scroll helper
    function scrollToField(id) {
        $('html, body').animate({
            scrollTop: $(id).offset().top - 120
        }, 500);
    }

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

                if (res.status === 'success') {

                    let a = res.data;

                    $('#pdi_reviewer').prop('checked', a.PDI_reviewer === 'Y');
                    $('#SR_reviewer').prop('checked', a.SR_reviewer === 'Y');
                    $('#s2w_reviewer').prop('checked', a.S2W_reviewer === 'Y');
                    $('#s2w_approver').prop('checked', a.S2W_approver === 'Y');
                    $('#s2w_acknowledger').prop('checked', a.S2W_acknowledger === 'Y');
                }
            }
        });
    }

    </script>


</body>
</html>