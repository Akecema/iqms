<?php

$sid =  base64_encode($stf_staffid);

?>


<style>
.modal.fade .modal-dialog {
    transform: scale(0.95);
    transition: transform 0.2s ease-out;
}
.modal.show .modal-dialog {
    transform: scale(1);
}

.modal-custom-sm .modal-header
{
    border-color: #9e9b9bff !important;
}

.modal-custom-sm {
    width : 550px;
}

</style>


<div class="modal fade" id="forceChangePwdModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-custom-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h6 class="modal-title text-primary">Action Required</h6>
            </div>

            <div class="modal-body">
                <div class="any-card">
                    <div class="c-con">
                        <h4 class="heading mb-0">Dear <strong><?= $stf_name ?></strong></h4>
                        <!-- <span>Best seller of the week</span> -->
                        <p class="mt-3">You are required to change your password before continuing.</p>
                            
                        <button type="button" class="btn btn-primary btn-sm" id="btnGoChangePwd">OK</button>
                    </div>
                    <img src="images/red-cloud-computing.png" class="harry-img" alt="" style="background-image:none">
                    
                </div>	
            </div>

        </div>
    </div>
</div>

<?php if (!empty($_SESSION['force_password_change'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    new bootstrap.Modal(
        document.getElementById('forceChangePwdModal'),
        {
            backdrop: 'static',
            keyboard: false
        }
    ).show();
});
</script>
<?php endif; ?>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('btnGoChangePwd');

    if (btn) {
        btn.addEventListener('click', function () {
            window.location.href = 'change-password.php?sid=<?=$sid?>';
        });
    }

});
</script>