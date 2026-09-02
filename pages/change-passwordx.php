<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">

        <div class="modal-header">
            <h6 class="modal-title text-dark">Change Password</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <div class="mb-3">
            <label class="form-label">Current Password</label>
                <input type="password" class="form-control" id="current_password">
            </div>

            <div class="mb-3">
            <label class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password">
            </div>

            <div class="progress mt-2" style="height:6px;">
                <div id="passwordStrengthBar" class="progress-bar" style="width:0%"></div>
            </div>
            <small id="passwordStrengthText" class="text-muted"></small>

            <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirm_password">
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-black" id="btnChangePassword">
            Save
            </button>
        </div>

        </div>
    </div>
</div>

<script>

$(document).on('click', '#btnChangePassword', function () {

    console.log('Change password clicked');

    let current  = $('#current_password').val().trim();
    let password = $('#new_password').val().trim();
    let confirm  = $('#confirm_password').val().trim();

    if (!current || !password || !confirm) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'All fields are required'
        });
        return;
    }

    if (password.length < 8) {
        Swal.fire('Error', 'Password must be at least 8 characters', 'error');
        return;
    }

    if (password !== confirm) {
        Swal.fire('Error', 'Passwords do not match', 'error');
        return;
    }

    if (checkPasswordStrength(password) < 3) {
        Swal.fire('Error', 'Please use a stronger password', 'error');
        return;
    }

    $.ajax({
        url: 'fetch-user.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'change_password',
            current_password: current,
            new_password: password
        },
        success: function (res) {
            if (res.status === 'success') {
                Swal.fire({
                    title: 'Success',
                    text: res.message,
                    icon: 'success',
                    allowOutsideClick: false
                }).then(() => {
                    if (res.logout) {
                        window.location.href = 'login.php';
                    }
                });
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }
    });
});

$(document).on('input', '#current_password, #new_password, #confirm_password', function () {
    const filled =
        $('#current_password').val() &&
        $('#new_password').val() &&
        $('#confirm_password').val();

    $('#btnChangePassword').prop('disabled', !filled);
});

function checkPasswordStrength(password) {
    let score = 0;

    if (password.length >= 8) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;

    return score;
}

$('#new_password').on('keyup', function () {

    const password = $(this).val();
    const score = checkPasswordStrength(password);

    const bar = $('#passwordStrengthBar');
    const text = $('#passwordStrengthText');

    bar.removeClass('bg-danger bg-warning bg-success');

    if (score <= 1) {
        bar.addClass('bg-danger').css('width', '33%');
        text.text('Weak password');
    } 
    else if (score === 2 || score === 3) {
        bar.addClass('bg-warning').css('width', '66%');
        text.text('Medium strength');
    } 
    else {
        bar.addClass('bg-success').css('width', '100%');
        text.text('Strong password');
    }
});


</script>
