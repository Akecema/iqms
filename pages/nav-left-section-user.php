	<?php
	$current_page = basename($_SERVER['PHP_SELF']);   
	include 'get-authorization-pdi.php';

	// Check if current page is in Pre Delivery Inspection section
	$pdi_pages = ['inspection-rcd-create.php', 'inspection-rcd-list.php', 'inspection-rcd-pallet-list.php', 'inspection-rcd-pallet-list-all.php', 'inspection-rcd-pendingreview.php',
				  'inspection-rcd-reviewed.php', 'inspection-rcd-completed.php',
	              'ip-sorting.php', 'ip-sorting-list-all.php', 'ip-sorting-pendingreview.php', 'inspection-rcd-pendingreview-pre.php' , 'inspection-rcd-reviewed-pre.php' , 'inspection-rcd-completed-pre.php',
	              'ip-s2w.php', 'ip-s2w-list-all.php', 'ip-s2w-pending.php',
	              'ip-s2w-sect.php', 'ip-s2w-sect-list-all.php', 'ip-s2w-sect-pending.php', 'ip-s2w-sect-acknowledge.php',
	              'ip-inspection-report.php', 'ip-sorting-report.php', 'ip-s2w-report.php', 'ip-replys2w-report.php'];
	$is_pdi_active = in_array($current_page, $pdi_pages);
	

	$list_pages = [
		'inspection-rcd-list.php',
		'inspection-rcd-pallet-list.php',
		'inspection-rcd-pallet-list-all.php',
		'inspection-rcd-list-pre.php',
		'inspection-rcd-pallet-list-all-pre.php'
	];

	$is_list_active = in_array($current_page, $list_pages);

	$review_pages = [
		'inspection-rcd-pendingreview.php',
		'inspection-rcd-reviewed.php',
		'inspection-rcd-completed.php',
		'inspection-rcd-pendingreview-pre.php',
		'inspection-rcd-reviewed-pre.php',
		'inspection-rcd-completed-pre.php'
	];

	$is_review_active = in_array($current_page, $review_pages);

	//Sorting
	$sorting_create_pages = [
		'ip-sorting-create.php',
		'ip-sorting-part-involve.php'
	];

	$is_sorting_create_active = in_array($current_page, $sorting_create_pages);

	$sorting_list_pages = [
		'ip-sorting-list-all.php',
		'ip-sorting-edit.php',
		'ip-sorting-part-involve-edit.php',
		'ip-sorting-list-all-pre.php',
		'ip-sorting-view.php',
		'ip-sorting-part-involve-view.php'
	];

	$is_sorting_list_active = in_array($current_page, $sorting_list_pages);

	$sorting_review_pages = [
		'ip-sorting-pendingreview.php',
		'ip-sorting-approved-pre.php',
		'ip-sorting-approved.php',
		'ip-sorting-pendingreview-det.php',
		'ip-sorting-pendingreview-detpre.php',
		'ip-sorting-pendingreview-pre.php',
		'ip-sorting-pendingreview.php'
	];

	$rev_sorting_active = in_array($current_page, $sorting_review_pages);

	//S2W
	$s2w_create_pages = [
		'ip-s2w.php',
		'ip-s2w-create.php'
	];

	$is_s2w_create_active = in_array($current_page, $s2w_create_pages);

	$s2w_list_pages = [
		'ip-s2w-list-all.php',
		'ip-s2w-list-all-pre.php',
		'ip-s2w-view.php',
		'ip-s2w-edit.php'
	];

	$is_s2w_list_active = in_array($current_page, $s2w_list_pages);

	$s2w_review_pages = [
		'ip-s2w-pending-det.php',
		'ip-s2w-pending-detpre.php',
		'ip-s2w-pending-pre.php',
		'ip-s2w-pending.php',
		'ip-s2w-reviewed-pre.php',
		'ip-s2w-reviewed.php',
		'ip-s2w-approved.php',
		'ip-s2w-approved-pre.php'
	];

	$rev_s2w_active = in_array($current_page, $s2w_review_pages);

	//S2W Reply
	$s2w_reply_list_pages = [
		'ip-s2w-sect-create.php',
		'ip-s2w-sect-edit.php',
		'ip-s2w-sect-list-all.php',
		'ip-s2w-sect-list-all-pre.php',
		'ip-s2w-sect-view.php',
		'ip-s2w-sectedit.php'
	];

	$is_s2w_reply_list_active = in_array($current_page, $s2w_reply_list_pages);

	$s2w_reply_review_pages = [
		'ip-s2w-sect-pending.php.php',
		'ip-s2w-sect-pending-detpre.php',
		'ip-s2w-sect-pending-pre.php',
		'ip-s2w-sect-pending.php',
		'ip-s2w-sect-reviewed-pre.php',
		'ip-s2w-sect-reviewed.php',
		'ip-s2w-sect-approved.php',
		'ip-s2w-sect-approved-pre.php'
	];

	$rev_s2w_reply_active = in_array($current_page, $s2w_reply_review_pages);

	$is_s2w_menu_open = $is_s2w_list_active || $rev_s2w_active || ($current_page == 'ip-s2w.php');
	$is_s2w_reply_menu_open = $is_s2w_reply_list_active || $rev_s2w_reply_active || ($current_page == 'ip-s2w-sect.php') || ($current_page == 'ip-s2w-sect-acknowledge.php');

	?>

	<li>
		<a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
		<div class="menu-icon">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M9.13478 20.7733V17.7156C9.13478 16.9351 9.77217 16.3023 10.5584 16.3023H13.4326C13.8102 16.3023 14.1723 16.4512 14.4393 16.7163C14.7063 16.9813 14.8563 17.3408 14.8563 17.7156V20.7733C14.8539 21.0978 14.9821 21.4099 15.2124 21.6402C15.4427 21.8705 15.756 22 16.0829 22H18.0438C18.9596 22.0024 19.8388 21.6428 20.4872 21.0008C21.1356 20.3588 21.5 19.487 21.5 18.5778V9.86686C21.5 9.13246 21.1721 8.43584 20.6046 7.96467L13.934 2.67587C12.7737 1.74856 11.1111 1.7785 9.98539 2.74698L3.46701 7.96467C2.87274 8.42195 2.51755 9.12064 2.5 9.86686V18.5689C2.5 20.4639 4.04738 22 5.95617 22H7.87229C8.55123 22 9.103 21.4562 9.10792 20.7822L9.13478 20.7733Z" fill="#90959F"/>
			</svg>
		</div>
		<span class="nav-text">Dashboard</span>
		</a>
		<ul aria-expanded="false">
			<li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Inspection Dashboard</a>
				<ul aria-expanded="false">
					<li><a href="dashboard-ip.php">Dashboard</a></li>
					<li><a href="dashboard-ip2.php">Dashboard 2</a></li>
				</ul>
			</li>
		</ul>
	</li>

	<li>
		<a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
		<div class="menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
				<path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
				<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
				<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
			</svg>
		</div>
		<span class="nav-text">Pre Delivery Inspection</span>
		</a>
		<ul aria-expanded="false">

			<?php if($pdi_reviewer == 'Y') { ?>
			<!-- AUT-->
			<li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Inspections</a>
				<ul aria-expanded="false">	
					<li><a href="inspection-rcd-create.php">New Inspection</a></li>								
					<li class="<?= $is_list_active ? 'mm-active' : '' ?>"><a href="inspection-rcd-list.php" class="<?= $is_list_active ? 'mm-active' : '' ?>">Inspections List</a></li>
					<li class="<?= $is_review_active ? 'mm-active' : '' ?>"><a class="<?= $is_review_active ? 'mm-active' : '' ?>" href="inspection-rcd-pendingreview.php">Review Inspections</a></li>
				</ul>
			</li>
			<?php } ?>

			<?php if($SR_reviewer == 'Y') { ?>
			<!-- AUT-->
			<li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Sorting Report</a>
				<ul aria-expanded="false">
					<li class="<?= $rev_sorting_active ? 'mm-active' : '' ?>"><a class="<?= $rev_sorting_active ? 'mm-active' : '' ?>" href="ip-sorting-pendingreview.php">Review Sorting Report</a></li>
				</ul>
			</li>
			<?php } ?>

			<li><a class="has-arrow <?= $is_s2w_menu_open ? 'mm-active' : '' ?>" href="javascript:void(0);" aria-expanded="<?= $is_s2w_menu_open ? 'true' : 'false' ?>">S2W</a>
				<ul aria-expanded="<?= $is_s2w_menu_open ? 'true' : 'false' ?>" class="<?= $is_s2w_menu_open ? 'mm-show' : '' ?>">
					<li class="<?= $is_s2w_create_active ? 'mm-active' : '' ?>"><a class="<?= $is_s2w_create_active ? 'mm-active' : '' ?>" href="ip-s2w.php">Create S2W</a></li>
					<li class="<?= $is_s2w_list_active ? 'mm-active' : '' ?>"><a class="<?= $is_s2w_list_active ? 'mm-active' : '' ?>" href="ip-s2w-list-all.php">S2W List</a></li>

					<!-- AUT-->
					<?php if($S2W_reviewer == 'Y' || $S2W_approver == 'Y') { ?>
					<li class="<?= $rev_s2w_active ? 'mm-active' : '' ?>"><a class="<?= $rev_s2w_active ? 'mm-active' : '' ?>" href="ip-s2w-pending.php">Approve S2W</a></li>
					<?php } ?>
				</ul>
			</li>
			<li><a class="has-arrow <?= $is_s2w_reply_menu_open ? 'mm-active' : '' ?>" href="javascript:void(0);" aria-expanded="<?= $is_s2w_reply_menu_open ? 'true' : 'false' ?>">S2W Reply</a>
				<ul aria-expanded="<?= $is_s2w_reply_menu_open ? 'true' : 'false' ?>" class="<?= $is_s2w_reply_menu_open ? 'mm-show' : '' ?>">
					<li><a class="<?= $is_s2w_create_active ? 'mm-active' : '' ?>" href="ip-s2w-sect.php">S2W Reply</a></li>
					<li class="<?= $is_s2w_reply_list_active ? 'mm-active' : '' ?>"><a class="<?= $is_s2w_reply_list_active ? 'mm-active' : '' ?>"  href="ip-s2w-sect-list-all.php">S2W Reply List</a></li>
					<li class="<?= $rev_s2w_Reply_active ? 'mm-active' : '' ?>"><a class="<?= $rev_s2w_Reply_active ? 'mm-active' : '' ?>" href="ip-s2w-sect-pending.php">Approve S2W Reply</a></li>
					
					<!-- AUT-->
					<?php if($S2W_acknowledger == 'Y') { ?>
					<li><a href="ip-s2w-sect-acknowledge.php">Acknowledge S2W Reply</a></li>
					<?php } ?>

				</ul>
			</li>
		</ul>
	</li>

	<li class="menu-title mt-2">ACCOUNT</li>
	<li><a href="my-profile.php?sid=<?php echo base64_encode($stf_staffid);?>" class="" aria-expanded="false">
		<div class="menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-video3" viewBox="0 0 16 16">
				<path d="M14 9.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0m-6 5.7c0 .8.8.8.8.8h6.4s.8 0 .8-.8-.8-3.2-4-3.2-4 2.4-4 3.2"/>
				<path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h5.243c.122-.326.295-.668.526-1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v7.81c.353.23.656.496.91.783Q16 12.312 16 12V4a2 2 0 0 0-2-2z"/>
			</svg>
		</div>	
			<span class="nav-text">Profile</span>
		</a>
	</li>

	<li>
		<a class="" href="logout.php" aria-expanded="false">
		<div class="menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
				<path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
			</svg>
		</div>
		<span class="nav-text">Logout</span>
		</a>
	</li>

	<li class="menu-title mt-2">HELPDESK</li>
	<li><a href="User Manual/i-QIMS - User manual.pdf" target="_blank" class="" aria-expanded="false">
		<div class="menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
				<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
				<path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/>
			</svg>
		</div>	
			<span class="nav-text">Help</span>
		</a>
	</li>
