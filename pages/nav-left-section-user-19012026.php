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
			<li><a href="home.php">Dashboard</a></li>
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
					<li><a href="inspection-rcd-pendingreview.php">Review Inspections</a></li>
				</ul>
			</li>
			<?php } ?>

			<?php if($SR_reviewer == 'Y') { ?>
			<!-- AUT-->
			<li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">Sorting Report</a>
				<ul aria-expanded="false">
					<li><a href="ip-sorting-pendingreview.php">Approve Sorting Report</a></li>
				</ul>
			</li>
			<?php } ?>

			<li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">S2W</a>
				<ul aria-expanded="false">
					<li><a href="ip-s2w.php">Create S2W</a></li>
					<li><a href="ip-s2w-list-all.php">S2W List</a></li>

					<!-- AUT-->
					<?php if($S2W_approver == 'Y') { ?>
					<li><a href="ip-s2w-pending.php">Approve S2W</a></li>
					<?php } ?>
				</ul>
			</li>
			<li><a class="has-arrow" href="javascript:void(0);" aria-expanded="false">S2W Report</a>
				<ul aria-expanded="false">
					<li><a href="ip-s2w-sect.php">Reply S2W Report</a></li>
					<li><a href="ip-s2w-sect-list-all.php">S2W Report List</a></li>

					<!-- AUT-->
					<?php if($S2W_approver == 'Y') { ?>
					<li><a href="ip-s2w-sect-pending.php">Approve S2W Report</a></li>
					<?php } ?>

					<!-- AUT-->
					<?php if($S2W_acknowledger == 'Y') { ?>
					<li><a href="ip-s2w-sect-acknowledge.php">Acknowledge S2W Report</a></li>
					<?php } ?>

				</ul>
			</li>
		</ul>
	</li>
