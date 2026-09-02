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
    <!-- <link href="css/button.css" rel="stylesheet"> -->
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
                b.branch_name,
                p.appraisor as hod,
                s.role_name, r.role
            FROM employee_details e
            LEFT JOIN employee_approval p ON e.staff_id = p.staff_id
            LEFT JOIN company c ON e.company = c.company_id
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
    
        // Authorization
        $isEdit = false;

        $sql = "
            SELECT staff_id 
            FROM user_authorization 
            WHERE staff_id = ?
            LIMIT 1
        ";

        $stmt = $db_con->prepare($sql);
        $stmt->bind_param("s", $staff_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $isEdit = true;
        }

        ?>

        <style>

		#tableEmployee tbody tr td:last-child {
            text-align: left !important; 
        }

        #tableEmployee thead tr th:last-child{
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
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title">Employee Info</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="#" class="mt-2">
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
                                                        <div class="upload-link" title="" data-toggle="tooltip" data-placement="right" data-original-title="update">
                                                            <input type="file" class="update-flie" id="imageUpload" accept="image/*">
                                                            <i class="fa-solid fa-pen-to-square fs-16"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>   
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Staff Id </label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="estaff_id" value="<?= htmlspecialchars($emp['staff_id']); ?>"  disabled>   
                                                </div>
                                            </div>                                         
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Identification No  <span class="text-danger">*</span></label> 
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" id="eic_no" value="<?= htmlspecialchars($emp['identification_no']); ?>">
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Full Name <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-sm-68">
                                                            <input type="text" class="form-control" id="efullname" value="<?= htmlspecialchars($emp['staff_name']); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Short Name <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" id="eshortname" value="<?= htmlspecialchars($emp['short_name']); ?>">
                                                </div>
                                            </div>
                                            <div class="row align-items-center mb-4">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-md-0">Designation <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <select class="form-control select2-width-50" id="edesignation">
                                                        <?php
                                                        $ds = mysqli_query($db_con,
                                                            "SELECT design_id, design_name FROM designation WHERE design_status='AC'  ORDER BY design_name ASC");
                                                            while ($row = mysqli_fetch_assoc($ds)) {
                                                                $sel = ($emp['designation'] == $row['design_id']) ? 'selected' : '';
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
                                                    <input type="text" class="form-control" id="econtact" value="<?= htmlspecialchars($emp['contact_no']); ?>">
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
                                                                    $selected = ($emp['company'] == $c['company_id']) ? 'selected' : '';
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
                                                            <?php
                                                            $q = mysqli_query($db_con,
                                                                "SELECT branch_id, branch_name FROM branch WHERE branch_status='AC' ORDER BY branch_name ASC");
                                                            while ($b = mysqli_fetch_assoc($q)) {
                                                                $sel = ($emp['branch'] == $b['branch_id']) ? 'selected' : '';
                                                                echo "<option value='{$b['branch_id']}' $sel> {$b['branch_name']} </option>";
                                                            }
                                                            ?>
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
                                                        <?php
                                                        $d = mysqli_query($db_con,
                                                            "SELECT dept_id, dept_name FROM department WHERE dept_status='AC'");
                                                        while ($row = mysqli_fetch_assoc($d)) {
                                                            $sel = ($emp['department'] == $row['dept_id']) ? 'selected' : '';
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
                                                    <input type="email" class="form-control" id="eemail" value="<?= htmlspecialchars($emp['staff_email']); ?>">
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

                                                        $sel = ($emp['hod'] == $row['staff_id']) ? 'selected' : '';
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
                                                            $sel = ($emp['role'] == $row['role_id']) ? 'selected' : '';
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
                                                        <input class="form-check-input" type="checkbox" role="switch" id="account_status"
                                                            <?= ($emp['account_status'] === 'AC') ? 'checked' : '' ?> checked>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-light ms-2" onclick="window.location.href='employee-list.php';">Cancel</button>
                                        <button type="button" class="btn btn-black ms-2" id="btnSaveEmployee">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="row">                                    
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="d-block w-100">
                                                    <h4 class="heading mb-1">
                                                        <i class="fa fa-user-check me-2 text-black"></i>
                                                        User Authorization
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
                                                            <div class="col-sm-4">
                                                                <label class="form-label mb-md-0">Inspection</label>
                                                            </div>
                                                            <div class="col-sm-2 col-6">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input mb-0" id="pdi_user">
                                                                    <label class="form-check-label mb-0" for="checkboxNotEmail">User</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2 col-6">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input mb-0" id="pdi_reviewer">
                                                                    <label class="form-check-label mb-0" for="checkboxNotEmail">Reviewer</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix border-bottom py-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-4">
                                                                <label class="form-label mb-md-0">Sorting Report </label>
                                                            </div>
                                                             <div class="col-sm-2 col-6">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input mb-0" id="SR_user">
                                                                    <label class="form-check-label mb-0" for="checkboxBillPhone">User</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2 col-6">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input mb-0" id="SR_reviewer">
                                                                    <label class="form-check-label mb-0" for="checkboxBillPhone">Reviewer</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix border-bottom py-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-4">
                                                                <label class="form-label mb-md-0">S2W</label>
                                                            </div>
                                                            <div class="col-sm-2 col-4">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input mb-0" id="s2w_user">
                                                                    <label class="form-check-label mb-0" for="checkboxTeamEmail">User</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2 col-4">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input mb-0" id="s2w_reviewer">
                                                                    <label class="form-check-label mb-0" for="checkboxTeamEmail">Reviewer</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2 col-4 ms-sm-4">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input mb-0" id="s2w_approver">
                                                                    <label class="form-check-label mb-0" for="">Approver</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix py-3 pb-0">
                                                        <div class="row align-items-start">
                                                            <!-- LABEL -->
                                                            <div class="col-sm-4">
                                                                <label class="form-label mb-md-0">S2W Reply</label>
                                                            </div>
                                                            <div class="col-sm-2 col-6">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input mb-0" id="s2w_reply_user">
                                                                    <label class="form-check-label mb-0" for="">User</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2 col-6">
                                                                <div class="form-check custom-checkbox me-4 mb-0 d-inline-block">
                                                                    <input type="checkbox" class="form-check-input mb-0" id="s2w_acknowledger">
                                                                    <label class="form-check-label mb-0" for="">Acknowledger</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                            <div class="mb-2 p-4">
                                                <div class="dd" id="nestable">
                                                    <ol class="dd-list accordion" id="accordionExample">
                                                        <!-- <div class="dd-handle"></div> -->
                                                        
                                                        <li class="accordion-item dd-item menu-ac-item" data-id="1">
                                                            <div class="accordion-header position-relative">
                                                                <div class="move-media dd-handle">
																	<i class="fa-solid fa-users fs-12"></i>
																</div>
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                                    Role Descriptions
                                                                </button>
                                                            </div>
                                                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <div class="d-block w-100 mb-2">
                                                                        <h6 class="heading mb-1 fs-14">
                                                                            <i class="fa fa-user-plus me-2 text-black fs-12"></i>
                                                                            User
                                                                        </h6>
                                                                        <small class="text-muted d-block fs-13">
                                                                            Create AND view list records
                                                                        </small>
                                                                    </div>
                                                                    <div class="d-block w-100 mb-2">
                                                                        <h6 class="heading mb-1 fs-14">
                                                                            <i class="fa fa-user-plus me-2 text-black fs-12"></i>
                                                                            Reviewer
                                                                        </h6>
                                                                        <small class="text-muted d-block fs-13">
                                                                            Review submitted records
                                                                        </small>
                                                                    </div>	
                                                                    <div class="d-block w-100 mb-2">
                                                                        <h6 class="heading mb-1 fs-14">
                                                                            <i class="fa fa-user-plus me-2 text-black fs-12"></i>
                                                                            Approver
                                                                        </h6>
                                                                        <small class="text-muted d-block fs-13">
                                                                            Final approval of submission
                                                                        </small>
                                                                    </div>
                                                                    <div class="d-block w-100 mb-2">
                                                                        <h6 class="heading mb-1 fs-14">
                                                                            <i class="fa fa-user-plus me-2 text-black fs-12"></i>
                                                                            Acknowledger
                                                                        </h6>
                                                                        <small class="text-muted d-block fs-13">
                                                                            Acknowledge user for S2W completion
                                                                        </small>
                                                                    </div>										
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>

                                            <div class="card-footer text-end">
                                                <button type="button" class="btn btn-black ms-2" id="btnSaveAuthorization"><?= $isEdit ? 'Save Changes' : 'Save' ?></button>
                                                <input type="hidden" id="auth_mode" value="<?= $isEdit ? 'edit' : 'add' ?>">
                                            </div>
                                        </div>
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
        window.location.href = "employee-list.php";
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

    let authMode = "add";

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

                    authMode = "edit";   // <<<< HERE

                    let a = res.data;

                    $('#pdi_user').prop('checked', a.PDI_user === 'Y');
                    $('#pdi_reviewer').prop('checked', a.PDI_reviewer === 'Y');
                    $('#SR_user').prop('checked', a.SR_user === 'Y');
                    $('#SR_reviewer').prop('checked', a.SR_reviewer === 'Y');
                    $('#s2w_user').prop('checked', a.S2W_user === 'Y');
                    $('#s2w_reviewer').prop('checked', a.S2W_reviewer === 'Y');
                    $('#s2w_approver').prop('checked', a.S2W_approver === 'Y');
                    $('#s2w_reply_user').prop('checked', a.S2W_reply_user === 'Y');
                    $('#s2w_acknowledger').prop('checked', a.S2W_acknowledger === 'Y');

                    // change button text
                    $('#btnSaveAuthorization').text('Save Changes');

                } else {

                    authMode = "add";

                    // make sure button says Save
                    $('#btnSaveAuthorization').text('Save');
                }
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
        if (!validateField("#efullname", "Full Name")) return;
        if (!validateField("#eshortname", "Short Name")) return;
        if (!validateField("#eic_no", "Identification No")) return;
        if (!validateField("#eemail", "Email")) return;
        if (!validateEmail("#eemail")) return;
        if (!validateField("#ecompany", "Company")) return;
        if (!validateField("#edepartment", "Department")) return;
        if (!validateField("#edesignation", "Designation")) return;
        if (!validateField("#eapproval", "HOD")) return;
        if (!validateField("#erole", "Role")) return;

        let account_status = $('#account_status').is(':checked') ? 'AC' : 'IN';

        let formData = new FormData();

        formData.append("action","update_employee");
        formData.append("staff_id", $("#staff_id").val());
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
        formData.append("role", $("#erole").val());
        formData.append("account_status", account_status);

        // PHOTO (optional)
        if ($("#imageUpload")[0].files.length > 0){
            formData.append("photo", $("#imageUpload")[0].files[0]);
        }

        // =========================
        // CONFIRM SAVE
        // =========================
        Swal.fire({
            title: "Save Changes",
            text: "Update this employee information?",
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
                    contentType:false,
                    processData:false,
                    beforeSend: function () {
                        Swal.fire({
                            title: "Saving...",
                            text: "Please wait while we update the employee record.",
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },
                    success: function (res) {

                        if (res.status === "success") {

                            Swal.fire({
                                title: "Updated!",
                                text: "Employee information updated successfully.",
                                icon: "success",
                                iconColor: "#198754",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#198754"
                            }).then(() => {
                                // window.location.href = "employee-list.php";
                                location.reload(); 
                            });

                        } else {
                            Swal.fire({
                            title: "Error",
                            text: res.message || "Update failed.",
                            icon: "error",
                            iconColor: "#b02424ff",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#198754"
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
                            confirmButtonColor: "198754"
                        });
                    }
                });

            });
    });

    //UPDATE AUTHORIZATION
    $('#btnSaveAuthorization').on('click', function () {

        let staff_id = $('#auth_staff_id').val();
        
        // if (!staff_id) {
        //     Swal.fire("Error","Staff ID not found","error");
        //     return;
        // }

        if (!staff_id) {
            Swal.fire({
                text: "Staff ID not found'",
                icon: "Error",
                iconColor: "#198754",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"                
            });
            return;
        }

        // Convert checkbox → Y / N
        let data = {
            staff_id: staff_id,
            PDI_user:     $('#pdi_user').is(':checked') ? 'Y' : 'N',
            PDI_reviewer: $('#pdi_reviewer').is(':checked') ? 'Y' : 'N',
            SR_user:      $('#SR_user').is(':checked') ? 'Y' : 'N',
            SR_reviewer:  $('#SR_reviewer').is(':checked')  ? 'Y' : 'N',
            S2W_user:     $('#s2w_user').is(':checked') ? 'Y' : 'N',
            S2W_reviewer: $('#s2w_reviewer').is(':checked') ? 'Y' : 'N',
            S2W_approver: $('#s2w_approver').is(':checked') ? 'Y' : 'N',
            S2W_reply_user: $('#s2w_reply_user').is(':checked') ? 'Y' : 'N',
            S2W_acknowledger: $('#s2w_acknowledger').is(':checked') ? 'Y' : 'N'
        };

        let authMode = $('#auth_mode').val();
        data.action = (authMode === "edit")
        ? "update_authorization"
        : "add_authorization";

        Swal.fire({
            title: 'Save Authorization',
            text: 'Apply authorization changes?',
            icon: 'question',
            iconColor: "#198754",
            showCancelButton: true,
            confirmButtonColor: '#198754'
        }).then(res => {

            if (!res.isConfirmed) return;

            $.ajax({
                url: 'fetch-employee.php',
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire({
                                title: "Saved",
                                text: "Authorization updated successfully.",
                                icon: "success",
                                iconColor: "#198754",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#198754"
                            }).then(() => {
                                // window.location.href = "employee-list.php";
                                location.reload(); 
                            });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: res.message,
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
                            text: "Server error.",
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