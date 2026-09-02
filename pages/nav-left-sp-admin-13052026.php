	<?php
	$current_page = basename($_SERVER['PHP_SELF']);   // e.g. inspection-rcd-list.php

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

	<li class="menu-title mt-2">QUALITY MANAGEMENT</li>

	<?php
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


	$is_dpu_active = in_array($current_page, $list_dpu_pages);

	$report_dpu_pages = [
		'setting-DPU.php',
		'setting-DPU-details.php'
	];

	$is_report_dpu_active = in_array($current_page, $report_dpu_pages);

	?>

	<li>
		<a class="has-arrow <?= $is_pdi_active ? 'mm-active' : '' ?>" href="javascript:void(0);" aria-expanded="<?= $is_pdi_active ? 'true' : 'false' ?>">
		<div class="menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ui-checks" viewBox="0 0 16 16">
				<path d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
			</svg>
		</div>
		<span class="nav-text">Pre Delivery Inspection</span>
		</a>
		<ul aria-expanded="<?= $is_pdi_active ? 'true' : 'false' ?>" class="<?= $is_pdi_active ? 'mm-show' : '' ?>">
			<li><a class="has-arrow <?= $is_list_active ? 'mm-active' : '' ?>" href="javascript:void(0);" aria-expanded="<?= $is_list_active ? 'true' : 'false' ?>">Inspections</a>
				<ul aria-expanded="<?= $is_list_active ? 'true' : 'false' ?>" class="<?= $is_list_active ? 'mm-show' : '' ?>">
					<li><a href="inspection-rcd-create.php">New Inspection</a></li>
					<li class="<?= $is_list_active ? 'mm-active' : '' ?>"><a href="inspection-rcd-list.php" class="<?= $is_list_active ? 'mm-active' : '' ?>">Inspections List</a></li>
					<li class="<?= $is_review_active ? 'mm-active' : '' ?>"><a href="inspection-rcd-pendingreview.php" class="<?= $is_review_active ? 'mm-active' : '' ?>">Review Inspections</a></li>
				</ul>
			</li>
			<li><a class="has-arrow <?= $is_sorting_list_active ? 'mm-active' : '' ?>" href="javascript:void(0);" aria-expanded="<?= $is_sorting_list_active ? 'true' : 'false' ?>">Sorting Report</a>
				<ul aria-expanded="<?= $is_sorting_list_active ? 'true' : 'false' ?>" class="<?= $is_sorting_list_active ? 'mm-show' : '' ?>">
					<li class="<?= $is_sorting_create_active ? 'mm-active' : '' ?>"><a href="ip-sorting.php" class="<?= $is_sorting_create_active ? 'mm-active' : '' ?>">Create Sorting Report</a></li>
					<li class="<?= $is_sorting_list_active ? 'mm-active' : '' ?>"><a href="ip-sorting-list-all.php" class="<?= $is_sorting_list_active ? 'mm-active' : '' ?>">Sorting Report List</a></li>
					<li class="<?= $rev_sorting_active ? 'mm-active' : '' ?>"><a href="ip-sorting-pendingreview.php" class="<?= $rev_sorting_active ? 'mm-active' : '' ?>">Review Sorting Report</a></li>
				</ul>
			</li>
			<li><a class="has-arrow <?= $is_s2w_menu_open ? 'mm-active' : '' ?>" href="javascript:void(0);" aria-expanded="<?= $is_s2w_menu_open ? 'true' : 'false' ?>">S2W</a>
				<ul aria-expanded="<?= $is_s2w_menu_open ? 'true' : 'false' ?>" class="<?= $is_s2w_menu_open ? 'mm-show' : '' ?>">
					<li class="<?= $is_s2w_create_active ? 'mm-active' : '' ?>"><a href="ip-s2w.php" class="<?= $is_s2w_create_active ? 'mm-active' : '' ?>">Create S2W</a></li>
					<li class="<?= $is_s2w_list_active ? 'mm-active' : '' ?>"><a href="ip-s2w-list-all.php" class="<?= $is_s2w_list_active ? 'mm-active' : '' ?>">S2W List</a></li>
					<li class="<?= $rev_s2w_active ? 'mm-active' : '' ?>"><a href="ip-s2w-pending.php" class="<?= $rev_s2w_active ? 'mm-active' : '' ?>">Approve S2W</a></li>
				</ul>
			</li>
			<li><a class="has-arrow <?= $is_s2w_reply_menu_open ? 'mm-active' : '' ?>" href="javascript:void(0);" aria-expanded="<?= $is_s2w_reply_menu_open ? 'true' : 'false' ?>">S2W Reply</a>
				<ul aria-expanded="<?= $is_s2w_reply_menu_open ? 'true' : 'false' ?>" class="<?= $is_s2w_reply_menu_open ? 'mm-show' : '' ?>">
					<li><a href="ip-s2w-sect.php">Reply S2W</a></li>
					<li class="<?= $is_s2w_reply_list_active ? 'mm-active' : '' ?>"><a href="ip-s2w-sect-list-all.php" class="<?= $is_s2w_reply_list_active ? 'mm-active' : '' ?>">S2W Reply List</a></li>
					<li class="<?= $rev_s2w_Reply_active ? 'mm-active' : '' ?>"><a href="ip-s2w-sect-pending.php" class="<?= $rev_s2w_Reply_active ? 'mm-active' : '' ?>">Approve S2W Reply</a></li>
					<li><a href="ip-s2w-sect-acknowledge.php">Acknowledge S2W Reply</a></li>
				</ul>
			</li>
			<li><a class="has-arrow <?= $is_report_list_active ? 'mm-active' : '' ?>" href="javascript:void(0);" aria-expanded="<?= $is_report_list_active ? 'true' : 'false' ?>">Reports</a>
				<ul aria-expanded="<?= $is_report_list_active ? 'true' : 'false' ?>" class="<?= $is_report_list_active ? 'mm-show' : '' ?>">
					<li class="<?= ($current_page == 'ip-inspection-report-defect-analysis.php') ? 'mm-active' : '' ?>"><a href="ip-inspection-report-defect-analysis.php" class="<?= ($current_page == 'ip-inspection-report-defect-analysis.php') ? 'mm-active' : '' ?>">Defect Analysis Report</a></li>
					<li class="<?= ($current_page == 'ip-inspection-report-defect-type.php') ? 'mm-active' : '' ?>"><a href="ip-inspection-report-defect-type.php" class="<?= ($current_page == 'ip-inspection-report-defect-type.php') ? 'mm-active' : '' ?>">Model Type Performance Report</a></li>
					<li class="<?= ($current_page == 'ip-inspection-report-defect-model.php') ? 'mm-active' : '' ?>"><a href="ip-inspection-report-defect-model.php" class="<?= ($current_page == 'ip-inspection-report-defect-model.php') ? 'mm-active' : '' ?>">Model Performance Report</a></li>
					<li class="<?= ($current_page == 'ip-inspection-report-monthly.php') ? 'mm-active' : '' ?>"><a href="ip-inspection-report-monthly.php" class="<?= ($current_page == 'ip-inspection-report-monthly.php') ? 'mm-active' : '' ?>">Monthly Trend</a></li>
					<li class="<?= ($current_page == 'ip-inspection-report-inspector.php') ? 'mm-active' : '' ?>"><a href="ip-inspection-report-inspector.php" class="<?= ($current_page == 'ip-inspection-report-inspector.php') ? 'mm-active' : '' ?>">Inspector Performance Report</a></li>
					<li class="<?= $is_report_inspection_active_2 || $is_report_inspection_active ? 'mm-active' : '' ?>"><a class="has-arrow <?= $is_report_inspection_active_2 || $is_report_inspection_active ? 'mm-active' : '' ?>" href="javascript:void(0);" aria-expanded="<?= $is_report_inspection_active_2 || $is_report_inspection_active ? 'true' : 'false' ?>">Detail Reports</a>
						<ul aria-expanded="<?= $is_report_inspection_active_2 || $is_report_inspection_active ? 'true' : 'false' ?>" class="<?= $is_report_inspection_active_2 || $is_report_inspection_active ? 'mm-show' : '' ?>">							
							<li class="<?= ($current_page == 'ip-inspection-report.php') ? 'mm-active' : '' ?>"><a href="ip-inspection-report.php" class="<?= ($current_page == 'ip-inspection-report.php') ? 'mm-active' : '' ?>">Inspection</a></li>
							<li class="<?= $is_report_sorting_active ? 'mm-active' : '' ?>"><a href="ip-sorting-report.php" class="<?= $is_report_sorting_active ? 'mm-active' : '' ?>">Sorting</a></li>
							<li class="<?= $is_report_s2w_active ? 'mm-active' : '' ?>"><a href="ip-s2w-report.php" class="<?= $is_report_s2w_active ? 'mm-active' : '' ?>">S2W</a></li>
							<li class="<?= $is_report_s2w_reply_active ? 'mm-active' : '' ?>"><a href="ip-s2w-reply-report.php" class="<?= $is_report_s2w_reply_active ? 'mm-active' : '' ?>">Reply S2W</a></li>
						</ul>
					</li>
					<li class="<?= $is_report_dpu_active || $is_report_inspection_active ? 'mm-active' : '' ?>"><a class="has-arrow <?= $is_report_dpu_active ? 'mm-active' : '' ?>" href="javascript:void(0);" aria-expanded="<?= $is_report_dpu_active || $is_report_inspection_active ? 'true' : 'false' ?>">DPU Performance Summary</a>
						<ul aria-expanded="<?= $is_report_dpu_active ? 'true' : 'false' ?>" class="<?= $is_report_dpu_active ? 'mm-show' : '' ?>">							
							<li class="<?= ($current_page == 'ip-inspection-report-dpu.php' || $current_page == 'ip-inspection-report-dpu-yearwise.php') ? 'mm-active' : '' ?>"><a href="ip-inspection-report-dpu.php" class="<?= ($current_page == 'ip-inspection-report-dpu.php' || $current_page == 'ip-inspection-report-dpu-yearwise.php') ? 'mm-active' : '' ?>">DPU Performance Summary</a></li>	
							<li class="<?= ($current_page == 'ip-inspection-report-dpu-pdi.php' || $current_page == 'ip-inspection-report-dpu-pdi.php') ? 'mm-active' : '' ?>"><a href="ip-inspection-report-dpu-pdi.php" class="<?= ($current_page == 'ip-inspection-report-dpu-pdi.php' || $current_page == 'ip-inspection-report-dpu-pdi-yearwise.php') ? 'mm-active' : '' ?>">PDI Performance</a></li>	
						</ul>					
					</li>					
				</ul>
			</li>
		</ul>
	</li>
	<li class="menu-title mt-2">ADMINISTRATION</li>
	<li>
		<a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
		<div class="menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
				<path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
			</svg>
		</div>
		<span class="nav-text">Users & Roles</span>
		</a>
		<ul aria-expanded="false">
			<li><a class="" href="employee-list.php" aria-expanded="false">Employee List</a></li>
			<li><a class="" href="employee-add.php" aria-expanded="false">Register Employee</a></li>
		</ul>
	</li>

	<li>
		<a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
		<div class="menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building-gear" viewBox="0 0 16 16">
				<path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6.5a.5.5 0 0 1-1 0V1H3v14h3v-2.5a.5.5 0 0 1 .5-.5H8v4H3a1 1 0 0 1-1-1z"/>
				<path d="M4.5 2a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-6 3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.386 1.46c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
			</svg>
		</div>
		<span class="nav-text">Company Setup</span>
		</a>
		<ul aria-expanded="false">
			<li><a href="company-list.php">Company</a></li>
			<li><a href="department-list.php" aria-expanded="false">Department</a></li>
			<li><a href="designation-list.php">Designation</a>
			</li>	
		</ul>
	</li>
	<li class="menu-title mt-2">MASTER DATA</li>
	<li>
		<a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
		<div class="menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
				<path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z"/>
			</svg>
		</div>
		<span class="nav-text">Finished Goods</span>
		</a>
		<ul aria-expanded="false">
			<li><a href="material-list.php">Finished Goods</a></li>
			<!-- <li><a href="material-gallery.php">Finished Goods Gallery</a></li> -->
		</ul>
	</li>

	<li>
		<a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
		<div class="menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sliders" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1z"/>
			</svg>
		</div>
		<span class="nav-text">Model Configuration</span>
		</a>
		<ul aria-expanded="false">
			<li><a href="model-type.php" aria-expanded="false">Model Type</a></li>
			<li><a href="part-side.php">Part Side</a></li>
			<li><a href="model-list.php">Model</a></li>
			<li><a href="part-type.php">Type of Parts</a></li>	
		</ul>
	</li>

	<li>
		<a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
		<div class="menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-x" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708"/>
				<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
				<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
			</svg>
		</div>
		<span class="nav-text">Defect Classification</span>
		</a>
		<ul aria-expanded="false">
			<li><a href="defect-list.php">Defect</a></li>
		</ul>
	</li>

	<li>
		<a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
		<div class="menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-check-fill" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
				<path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
			</svg>
		</div>
		<span class="nav-text">Related Parties</span>
		</a>
		<ul aria-expanded="false">
			<li><a href="related-department.php">Related Department</a></li>
			<li><a href="related-vendor.php">Related Vendors</a></li>
			<li><a href="related-customer.php">Related Customer</a></li>
		</ul>
	</li>
	<li>
		<a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
		<div class="menu-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
				<path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5m0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78zM5.048 3.967l-.087.065zm-.431.355A4.98 4.98 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8zm.344 7.646.087.065z"/>
			</svg>
		</div>
		<span class="nav-text">System Settings</span>
		</a>
		<ul aria-expanded="false">
			<li><a href="setting-financial-year.php">Financial Year</a></li><li><a class="has-arrow <?= $is_dpu_active ? 'mm-active' : '' ?>" href="javascript:void(0);" aria-expanded="<?= $is_dpu_active ? 'true' : 'false' ?>">Defect of Per Unit</a>
				<ul aria-expanded="">
					<li class=""><a href="setting-dpu-target.php">Target DPU</a></li>
					<li class=""><a href="setting-dpu-volume.php">DPU Volume</a></li>
				</ul>
			</li>
			<li><a href="setting-shift.php">Shift</a></li>
			<li><a href="setting-timedelay.php">Time Delay</a></li>
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
