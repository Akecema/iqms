<?php

include 'system-menu.php';
include 'system-status.php';
include '../timezone.php';
include '../shift.php';
include 'encrypt.php';
include 'get-financial-year.php';

?>

<!-- Sidebar Profile Info -->
<!-- <div class="sidebar-profile text-center p-3" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
    <img src="../photo/<?=$gst_photo?>" 
         alt="User Photo" 
         class="rounded-circle mb-2" 
         style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #fff;">
    <div class=""><?= $stf_name; ?></div>    
</div> -->

<ul class="metismenu" id="menu">

<?php 

if($session_role == 1)
{
    include 'nav-left-sp-admin.php';
}
elseif($session_role == 2)
{
    include 'nav-left-section-user.php';
}
elseif($session_role == 3)
{
    include 'nav-left-hod.php';
}
elseif($session_role == 4)
{
    include 'nav-left-user.php';
}

?>

</ul>