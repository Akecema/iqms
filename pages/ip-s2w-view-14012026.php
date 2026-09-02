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
    <link href="css/timeline.css" rel="stylesheet">
    
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

        $s2widEnc = $_GET['encs2wid'] ?? '';
        $eir_id = $_GET['irid'] ?? '';

        //decrypt
        $es2w_id = decryptData($s2widEnc);

        $sql = "SELECT s2w_ir_id, s2w_sr_id FROM inspection_s2w WHERE s2w_id = ?";
        $stmt = $db_con->prepare($sql);
        $stmt->bind_param("i", $es2w_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $esr_id = $row['s2w_sr_id'];

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
                        <?=$side_menu10;?>
                    </div>
                </div>

               <ul class="nav nav-pills mt-3 mt-sm-0" id="myTab2" role="tablist">
                                    <li class="nav-item ms-1" role="presentation">
                                        <button class="btn btn-sm btn-lime me-2 viewRightDetail" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" 
                                        data-bs-title="View inspection details" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-irid="<?= $eir_id ?>">
                                        Inspection <i class="fa fa-angle-double-right fa-xs" aria-hidden="true"></i>
                                    </button>
                                    </li>
                                    <li class="nav-item ms-1" role="presentation">
                                        <button class="btn btn-sm btn-darklime me-2 viewRightDetailSr" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight-SR" aria-controls="offcanvasRight" 
                                        data-bs-title="View sorting details" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-srid="<?= $esr_id ?>">
                                        Sorting <i class="fa fa-angle-double-right fa-xs" aria-hidden="true"></i></button>
                                    </li>
                                </ul>

                
                <!-- Offcanvas Inspection -->
                <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasRightLabel">Inspection</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <!-- Inspection details -->
                        <div id="inspectionRightDetail"></div>
                    </div>
                </div>

                <!-- Offcanvas Sorting -->
                <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight-SR" aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasRightLabel">Sorting</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <!-- Sorting details -->
                        <div id="sortingRightDetail"></div>
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
    </script>

    <script>
    document.getElementById('btnBack').addEventListener('click', function () {
        window.location.href = "ip-s2w-list-all-pre.php";
    });
    </script>

    <script>
    function initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')); 
        
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // run on page load
    document.addEventListener("DOMContentLoaded", function(){
        initTooltips();
    });
    </script>

    <script>

    let zoomImages = [];   // list of URLs for zooming
    let zoomIndex = 0;     // currently viewed index

    // Zoom images
    // When avatar is clicked
    $(document).on('click', '.viewAvatar', function () {
        const fullImg = $(this).data('full');
        console.log('Image clicked:', fullImg); 
        $('#previewImage').attr('src', fullImg);

        const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        modal.show();
    });

    function initTooltips() {
        const list = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        list.map(el => new bootstrap.Tooltip(el));
    }

    // When any image (old or new) is clicked
    $(document).on('click', '.position-relative', function (e) {

        // Gather all visible images
        imageList = $('.position-relative').map(function () {
            let bg = $(this).css('background-image');
            return bg ? bg.replace(/^url\(["']?/, '').replace(/["']?\)$/, '') : null;
        }).get();

        // Current index
        currentIndex = $(this).index('.position-relative');

        // Show clicked image in modal
        $("#zoomedImg").attr("src", imageList[currentIndex]);
        $("#imgZoomModal").modal("show");
    });

    </script>

    <script>
      
    // Load mateiral details
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

    // Link
    $(document).ready(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const irid = urlParams.get('irid');
        if (irid) {
            loadMaterialDetails(irid);
        }
    });

    </script>

    <script>

    $(document).ready(function() {
        const ir_id = $("#hidden_ir_id").val();  // or however you store it
        const sr_id = $("#hidden_sr_id").val();
        const s2w_id = $("#hidden_s2w_id").val();

        loadTimeline(ir_id, sr_id, s2w_id);
    });

    function loadTimeline(ir_id, sr_id, s2w_id) {
        $.ajax({
            url: "fetch-timeline-s2w.php",
            type: "POST",
            data: { 
                ir_id: ir_id, 
                sr_id: sr_id,
                s2w_id : s2w_id,
                t: new Date().getTime() 
            },
            cache: false,
            success: function (html) {
                $(".recent-post").html(html);

                $(document).off("click", "[data-bs-target='#remarkModal']").on("click", "[data-bs-target='#remarkModal']", function () {
                    const remark = $(this).data("remark") || "No remark provided.";
                    const reviewedBy = $(this).data("by") || "-";
                    const reviewedDate = $(this).data("date") || "-";

                    $("#remarkContent").text(remark);
                });
                
                // run tooltip
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            error: function () {
                $(".recent-post").html("<div class='alert alert-danger'>Failed to load timeline.</div>");
            }
        });
    }

    // Handle remark icon click
    $(document).on('click', '[data-bs-target="#remarkModal"]', function () {
        const remark = $(this).data('remark') || 'No remark provided.';
        $('#remarkContent').text(remark);
    });

    </script>

    <!--///////////////////////////////////////////////////////////////////////////-->
    <script>

        //--## S2W
        let existing_defect_photos = [];   // Photos already stored in DB
        let new_defect_files = [];         // Newly selected files not saved yet
        
        // Preview Renderer
        function renderDefectPhotos() {
            const box = $("#defect_photo_existing");
            box.empty();

            // --- EXISTING PHOTOS (from DB) ---
            existing_defect_photos.forEach(img => {
                box.append(`
                    <div class="position-relative me-2 mb-2 zoom-item"
                        style="width:80px;height:80px;border-radius:8px;
                        background-image:url('${img.url}');
                        background-size:cover;background-position:center;
                        border:1px solid #ddd;cursor:pointer"
                        data-id="${img.id}" data-s2w="${img.s2w_id}">

                        <span class="remove-old no-zoom"
                            style="position:absolute;top:-10px;right:-10px;
                            cursor:pointer;font-size:20px;z-index:10;">&times;</span>
                    </div>
                `);
            });

            // --- NEW PHOTOS (selected from PC) ---
            new_defect_files.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = e => {
                    box.append(`
                        <div class="position-relative me-2 mb-2 zoom-item"
                            style="width:80px;height:80px;border-radius:8px;
                            background-image:url('${e.target.result}');
                            background-size:cover;background-position:center;
                            border:1px solid #ddd;cursor:pointer">

                            <span class="remove-new no-zoom" data-idx="${idx}"
                                style="position:absolute;top:-10px;right:-10px;
                                cursor:pointer;font-size:20px;z-index:10;">&times;</span>
                        </div>
                    `);
                };
                reader.readAsDataURL(file);
            });
        }

        // Load Photos from get_s2w_details
        function loadS2W(sr_id) {
            $.post("fetch-ip-s2w-rcd-all.php", { action: "get_s2w_details", sr_id }, res => {
                
                if (res.status !== "success") return;

                const d = res.data;

                existing_defect_photos = [];
                new_defect_files = [];

                if (d.photo_defect) {
                    d.photo_defect.forEach(p => {
                        existing_defect_photos.push({
                            id: p.defect_photoid,
                            s2w_id: d.s2w_id,
                            url: `gallery/inspection_s2w/photo_defect/${d.s2w_id}/${p.file}`
                        });
                    });
                }

                renderDefectPhotos();
            }, "json");
        }

        // Add New Photo
        $("#defect_photo_s2w").on("change", function () {

            for (let f of this.files) {
                new_defect_files.push(f);
            }

            renderDefectPhotos();
            this.value = ""; // Reset file selector
        });

        //Remove New Photo (not uploaded yet)
        $(document).on("click", ".remove-new", function (e) {

            e.stopPropagation();   // HARD stop
            e.preventDefault();   

            new_defect_files.splice($(this).data("idx"), 1);
            renderDefectPhotos();
        });

        //Remove Existing Photo (stored in DB)
        $(document).on("click", ".remove-old", function (e) {

            e.stopPropagation();   // HARD stop
            e.preventDefault(); 

            const id = $(this).parent().data("id");
            const s2w_id = $(this).parent().data("s2w");

            Swal.fire({
                title: "Delete this photo?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "#d33"
            }).then(r => {
                if (!r.isConfirmed) return;

                $.post("fetch-ip-s2w-rcd-all.php",
                    { action: "delete_defect_photo", id, s2w_id },
                    resp => {
                        if (resp.status === "success") {
                            existing_defect_photos =
                            existing_defect_photos.filter(x => x.id !== id);
                            renderDefectPhotos();
                        }
                    },
                    "json"
                );
            });
        });

        // Save / Update — Send New Files Only

        //For add
        new_defect_files.forEach(f =>
            formData.append("defect_photo_s2w[]", f)
        );

        //For update
        new_defect_files.forEach(f =>
            formData.append("defect_photo_s2w[]", f)
        );

        // CLICK ZOOM — Works for new + existing photos
        $(document).on("click", ".zoom-item", function (e) {

            // Ignore clicks on delete buttons
            if ($(e.target).hasClass("no-zoom") || $(e.target).hasClass("remove-old") || $(e.target).hasClass("remove-new"))
                return;

            const clickedUrl = $(this).data("url");

            // Build full list of all images
            zoomImages = [];

            // Existing images
            existing_defect_photos.forEach(p => zoomImages.push(p.url));

            // New (preview) images
            new_defect_files.forEach((f, i) => {
                zoomImages.push(
                    $("#defect_photo_existing .zoom-item").eq(i + existing_defect_photos.length).data("url")
                );
            });

            // Find index of clicked image
            zoomIndex = zoomImages.indexOf(clickedUrl);

            // Set modal image
            $("#zoomedImg").attr("src", clickedUrl);

            // Show modal
            $("#imgZoomModal").modal("show");
        });


        // Add/create S2W
        $(document).on('click', '#btnSave', function() {

            let add_info  = $("#fd_addinfo").val().trim();
            let send_dept = $(".fd_dept").val();

            if (!send_dept) {
                Swal.fire("Validation", "Sending To is required.", "warning");
                $('.fd_dept').next('.select2-container').find('.select2-selection').addClass('border-error');
                return false;
            } else {
                $(".fd_dept").removeClass("border-error");
            }

            let formData = new FormData();
            formData.append("action", "add_s2w");
            formData.append("ir_id", $("#hidden_ir_id").val());
            formData.append("sr_id", $("#hidden_sr_id").val());
            formData.append("add_info", add_info);
            formData.append("send_dept", send_dept);

            // Add new photos only
            new_defect_files.forEach(f => formData.append("defect_photo_s2w[]", f));

            Swal.fire({
                title: "Confirm Save?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Save",
                confirmButtonColor: "#198754"
            }).then(res => {
                if (!res.isConfirmed) return;

                $.ajax({
                    url: "fetch-ip-s2w-rcd-all.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",

                    success: function(data) {
                        if (data.status === "success") {

                            // Reset new images
                            defectFiles = [];
                            $("#defect_photo_s2w").val("");

                            const s2w_id = data.insert_id;
                            const ir_id = data.ir_id;
                            const sr_id = data.sr_id;
                            const s2w_status = data.s2w_status;

                            // Attach the correct S2W ID to both update buttons
                            $("#btnUpdate").attr({
                                "data-s2wid": s2w_id,
                                "data-irid": ir_id,
                                "data-srid": sr_id
                            });

                            $("#btnSubmit").attr({
                                "data-s2wid": s2w_id,
                                "data-irid": ir_id,
                                "data-srid": sr_id,
                                "data-s2wstatus": s2w_status
                            });

                            // Store hidden S2W ID
                            if (!$("#hidden_s2w_id").length) {
                                $("<input>", {
                                    type: "hidden",
                                    id: "hidden_s2w_id",
                                    value: s2w_id
                                }).appendTo(".card-body");
                            } else {
                                $("#hidden_s2w_id").val(s2w_id);
                            }

                            // Switch buttons
                            $("#btnSave").addClass("d-none");
                            $("#btnUpdate").removeClass("d-none");
                            $("#btnSubmit").removeClass("d-none");

                            Swal.fire({
                                title: "Saved!",
                                text: "S2W record saved successfully.",
                                icon: "success",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#28a745"   // <-- GREEN button
                            });
                        }
                    }
                });
            });
        });

        // Remove border error on slect 2
        $('.fd_dept').on('change', function() {
            if ($(this).val()) {
                $(this).next('.select2-container').find('.select2-selection').removeClass('border-error');
            }
        });

        // Load Existing Record 
        $(document).ready(function () {

            const s2w_id = $("#hidden_s2w_id").val();
            if (!s2w_id) return;

            $.ajax({
                url: "fetch-ip-s2w-rcd-all.php",
                type: "POST",
                data: { action: "get_s2w_details", s2w_id },
                dataType: "json",

                success: function (res) {

                    if (res.status !== "success") return;

                    const d = res.data;

                    // Store S2W ID & STATUS into hidden inputs (always)
                    $("#hidden_s2w_id").val(d.s2w_id);
                    $("#hidden_s2w_status").val(d.s2w_status);

                    // Also store in localStorage
                    localStorage.setItem("s2w_id", d.s2w_id);
                    localStorage.setItem("s2w_status", d.s2w_status);

                    console.log("AFTER AJAX -> S2W ID:", d.s2w_id, "Status:", d.s2w_status, "IR ID:", d.ir_id, "SR ID:", d.sr_id);

                    /* -----------------------------------------
                    1. Fill basic fields
                    --------------------------------------------*/
                    $("#fd_addinfo").val(d.s2w_additional_desc || "");
                    $(".fd_dept").val(d.s2w_send_to || "").trigger("change");

                    /* -----------------------------------------
                    2. Reset new image selection
                    --------------------------------------------*/
                    defectFiles = [];
                    $("#defect_photo_s2w").val("");

                    existing_defect_photos = [];

                    if (d.photo_defect && d.photo_defect.length > 0) {
                        d.photo_defect.forEach(p => {
                            existing_defect_photos.push({
                                id: p.defect_photoid,
                                s2w_id: d.s2w_id,
                                url: `gallery/inspection_s2w/photo_defect/${d.s2w_id}/${p.file}`
                            });
                        });
                    }

                    renderDefectPhotos();

                    /* -----------------------------------------
                    4. Set hidden s2w_id properly
                    --------------------------------------------*/
                    if ($("#hidden_s2w_id").length === 0) {
                        $("<input>", {
                            type: "hidden",
                            id: "hidden_s2w_id",
                            value: d.s2w_id || ""
                        }).appendTo(".card-body");
                    } else {
                        $("#hidden_s2w_id").val(d.s2w_id || "");
                    }

                    if (!$("#hidden_s2w_status").length) {
                        $("<input>", {
                            type: "hidden",
                            id: "hidden_s2w_status",
                            value: d.s2w_status
                        }).appendTo(".card-body");
                    } else {
                        $("#hidden_s2w_status").val(d.s2w_status);
                    }

                    /* -----------------------------------------
                    5. Button visibility logic (clean version)
                    --------------------------------------------*/

                    // STATUS LOGIC
                    const s2w_status = parseInt(d.s2w_status);

                    // NEW ENTRY (no s2w_id yet)
                    // Disable all form fields
                    $(".profile-blog input, .profile-blog textarea, .profile-blog select")
                    .prop("disabled", true);

                    // DISABLE IMAGE UPLOAD
                    $("#defect_photo_s2w").prop("disabled", true);
                    $("label[for='defect_photo_s2w']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });

                    $("#ok_photo_s2w").prop("disabled", true);
                    $("label[for='ok_photo_s2w']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });

                    // DISABLE DELETE ICONS
                    $(".remove-old, .remove-new").remove();
                    $(".remove-old-ok, .remove-new-ok").remove();

                    // ALLOW ZOOM ONLY
                    $("#defect_photo_existing .zoom-item").css("pointer-events", "auto");
                    $("#ok_photo_existing .zoom-item").css("pointer-events", "auto");

                    /* -----------------------------------------
                    7. Re-init tooltips
                    --------------------------------------------*/
                    initTooltips();
                }
            });
        });

        // Right box Inspection details
        function loadRightDetail(ir_id) {
            $.ajax({
                url: "get-inspection-details.php",
                method: "POST",
                dataType: 'html',
                data: { ir_id: ir_id },
                beforeSend: function() {
                    $("#inspectionRightDetail").html("<div class='text-center p-3'>Loading...</div>");
                },
                success: function(html) {
                    $("#inspectionRightDetail").html(html);
                }
            });
        }

        $(document).on("click", ".viewRightDetail", function () {
            let ir_id = $(this).data("irid");
            loadRightDetail(ir_id);
        });

        $(document).ready(function () {
            let ir_id = $(".viewRightDetail.active, .viewRightDetail.show").data("irid");

            if (ir_id) {
                loadRightDetail(ir_id);
            }
        });

        // Right box Sorting details
        function loadRightDetailSr(sr_id) {
            $.ajax({
                url: "get-sorting-details.php",
                method: "POST",
                dataType: 'html',
                data: { sr_id: sr_id },
                beforeSend: function() {
                    $("#sortingRightDetail").html("<div class='text-center p-3'>Loading...</div>");
                },
                success: function(html) {
                    $("#sortingRightDetail").html(html);
                }
            });
        }

        $(document).on("click", ".viewRightDetailSr", function () {
            let sr_id = $(this).data("srid");
            loadRightDetailSr(sr_id);
        });

    </script>
    
</body>
</html>