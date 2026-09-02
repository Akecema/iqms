<!-- System title -->
<?php include "../system-header.php";?>

<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> <?php echo $syst_title; ?> </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
	<meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- Favicon -->
    <link rel="icon" href="../icon/favicon.ico" type="image/x-icon">

    <!-- All CSS -->
    <?php include 'inc-css.php'; ?>

    <!-- searching -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="jquery.searcher.js"></script>

</head>

<body>

    <!-- Session start -->
    <?php include "session-start.php"; ?>   


    <!-- Loader -->
    <div id="loader" >
        <img src="../assets/images/media/loader.svg" alt="">
    </div>
    <!-- Loader -->

    <div class="page">
         <!-- app-header -->
         <header class="app-header">

            <!-- Start::main-header-container -->
            <div class="main-header-container container-fluid">

                <!-- Start::header-content-left -->
                <div class="header-content-left">

                    <?php include 'nav-top-left.php'; ?>

                </div>
                <!-- End::header-content-left -->

                <!-- Start::header-content-right -->
                <div class="header-content-right">
        
                    <?php include 'nav-top-right.php'; ?>

                </div>
                <!-- End::header-content-right -->

            </div>
            <!-- End::main-header-container -->

        </header>
        <!-- /app-header -->
        <!-- Start::app-sidebar -->
        <aside class="app-sidebar sticky" id="sidebar">

            <?php include 'nav-sidebar.php'; ?>
            
        </aside>
        <!-- End::app-sidebar -->

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">  
                
                <?php

                // Define target manhour (adjust this value as needed)
                include 'training-manhours.php';

                //if still have pending submission for training
                $query_findrcd = "SELECT * FROM training_score_temp WHERE created_by = ? ";
                $get_findrcd = $db_con->prepare($query_findrcd); 
                $get_findrcd->bind_param("s", $s_staffid);
                $get_findrcd->execute();

                $get_rst_findrcd = $get_findrcd->get_result(); 
                $get_row_findrcd = $get_rst_findrcd->fetch_array(); 

                if($get_row_findrcd > 0)
                {
                    $pagelink = 'training-upload-view.php';
                }
                else
                {
                    $pagelink = 'training-upload.php';
                }

                ?>

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-16 mb-0"></h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $side_menu_training; ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php echo $side_menu_training4; ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <!-- Start::row-1 -->
                <div class="file-manager-container p-2 gap-2 d-sm-flex">
                    <div class="file-manager-navigation" style="width:320px;">

                        <div class="d-flex align-items-center justify-content-between w-100 p-3 border-bottom">  
                            <div class="card custom-card card-bg-dark text-fixed-white">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-top p-4 flex-wrap">
                                        <div class="me-3 lh-1">
                                            <span class="avatar avatar-md avatar-rounded bg-white text-primary shadow-sm">
                                                <i class="ri-mark-pen-fill fs-18"></i>
                                            </span>
                                        </div>
                                        <div class="flex-fill">
                                            <h5 class="fw-semibold mb-1 text-fixed-white"><?php echo $target_manhour; ?></h5>
                                            <p class="op-7 mb-0 fs-13">Target Man Hours</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div>

                            <?php $iTab = "tupload"; ?>

                            <ul class="list-unstyled files-main-nav" id="files-main-nav">
                                <li class="<?php echo ($iTab == "tlist" ? "active" : "") ?> files-type mb-2">
                                    <a href="training.php">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="ri-list-unordered fs-16"></i>
                                            </div>
                                            <span class="flex-fill text-nowrap">
                                                List 
                                            </span>
                                        </div>
                                    </a>
                                </li>
                                <li class="<?php echo ($iTab == "tadd" ? "active" : "") ?> files-type mb-2">
                                    <a href="training-add.php">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="ri-add-line fs-16"></i>
                                            </div>
                                            <span class="flex-fill text-nowrap">
                                                Add Score
                                            </span>
                                        </div>
                                    </a>
                                </li>
                                <li class="<?php echo ($iTab == "tupload" ? "active" : "") ?> files-type mb-2">
                                    <a href='training-upload.php'>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="ri-upload-2-line fs-16"></i>
                                            </div>
                                            <span class="flex-fill text-nowrap">
                                                Upload Score
                                            </span>
                                        </div>
                                    </a>
                                </li> 
                            </ul>
                        </div>
                    </div>
                    <div class="file-manager-folders">

                        <div class="d-flex p-3 gap-2 flex-wrap align-items-center justify-content-between mb-3 p-2 border-bottom">
                            <div class="d-flex flex-fill align-items-center">
                                <div class="me-2">
                                    <span class="avatar avatar-md avatar-rounded p-2 bg-light">
                                        <img src="../assets/icon/settings-glyph.jpg" alt="">
                                    </span>
                                </div>
                                <div class="lh-1">
                                    <span class="fw-semibold d-block mb-2 text-default"><?php echo $prd_training_desc; ?></span>                                    
                                    <p class="mb-0 fs-12 text-danger fw-semibold"><?php echo $prd_training_yr; ?></p>
                                </div>
                            </div>
                            <!-- Download  Excel Templates-->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><!-- Latest Invoices --></h5>
                                <div class="d-flex align-items-center">
                                <button type="button" onclick="window.location.href='../system_templates/Training_Score.csv'" class="btn btn-primary btn-sm ms-2"><i class="ri-download-line"></i> Import Template</button>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 file-folders-container" id="file-folders-container">
      
                            <span id="disp_dup_message"></span>

                            <form method="POST" action="" id="uploadForm">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">File <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="file" id="tr_upld_score" accept=".csv">
                                        <div id="emailHelp" class="form-text text-success">File must be in CSV format</div>
                                    </div>

                                    <div class="px-4 py-3 d-sm-flex justify-content-end">
                                        <button type="submit" class="btn btn-black btn-sm" onClick="return UploadTraining()">Submit</button>
                                    </div> 
                                </div> 
                            </form> 

                            <div id="fileMsg"></div>
                          
                        </div>                         
                        <!-- <div id="training-table" style="display:none;">
                        <div class="p-3 col-xl-12">                        
                            <div class="table-responsive">
                                <table  id="table-list" class="table table-bordered text-nowrap w-100">
                                    <thead class="table-grey">
                                        <tr>
                                            <th>Staff Id</th>
                                            <th>Target Manhours</th>
                                            <th>Actual Manhours</th>
                                            <th>Training Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql_non_appraisor = "SELECT * FROM training_score_temp WHERE created_by = '$s_staffid' ORDER BY training_scid  ASC";
                                            $rst_non_appraisor = mysqli_query($db_con,$sql_non_appraisor);

                                            while($row_non_appraisor = mysqli_fetch_array($rst_non_appraisor))
                                            {   
                                            ?>
                                        <tr>
                                            <td><?php echo $row_non_appraisor['staff_id']; ?></td>
                                            <td><?php echo $row_non_appraisor['target_manhours']; ?></td>
                                            <td><?php echo $row_non_appraisor['actual_manhours']; ?></td>
                                            <td><?php echo $row_non_appraisor['training_score']; ?></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>

                                    </tbody>
                                </table> 
                               
                            </div>  
                            
                            <div class="hstack gap-2 mt-5 justify-content-end">
                                <a href="javascript:void(0);" class="btn btn-black btn-sm submit_rcd">Submit</a>
                                <a href="javascript:void(0);" class="btn btn-warning btn-sm cancel_rcd">Cancel</a>
                                <button type="button" class="btn btn-black btn-sm" onClick="UpdatePerformance()">Save Changes</button>
                                <input type="hidden" id="hidden_userid" value="<?php echo $s_staffid; ?>">
                            </div>

                            
                        </div>
                        </div> -->




                    </div>  
                    

                </div>  
                <!--End::row-1 -->
                </div>
            </div>
        </div>
        <!-- End::app-content -->

        
        <!-- Footer Start -->
        <footer class="footer mt-auto py-3 bg-white text-center">

           <?php include 'nav-footer.php'; ?>

        </footer>
        <!-- Footer End -->


    </div>
    
    <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script> -->
    
    
    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->   

    <!-- All javascript -->
    <?php include 'inc-js.php'; ?>

    <script>

    $(document).ready(function(e){
        $('#uploadForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url:'fetch-upload-training.php',
                type:'POST',
                data:new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                success:function(data){
                    console.log('Server response:', data);
                    
                    // Check for error responses
                    if(data.includes('NO_FILE') || data.includes('INVALID_FILE') || 
                       data.includes('FILE_OPEN_FAILED') || data.includes('UPLOAD_FAILED')) {
                        alert('Upload failed: ' + data);
                        return;
                    }
                    
                    // Check if there are any errors in the response
                    if(data.includes('Error') || data.includes('failed')) {
                        alert('Some records failed to upload:\n\n' + data);
                    } else {
                        alert('Training score has been uploaded successfully.');
                    }
                    
                    // location.reload();
                },
                error:function(){
                    // $("#fileMsg").html("Error to upload.");
                    alert("Error occurred while uploading the file. Please try again.");

                }

            });
        });
    });

    </script>

    
</body>

</html>