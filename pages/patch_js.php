<?php
$file = 'c:\xampp_7\htdocs\iQims\pages\material-list.php';
$content = file_get_contents($file);

// Find the LAST </script> tag
$pos = strrpos($content, '</script>');

if ($pos !== false) {
    $jsCode = <<<'JS'

    // UPLOAD GALLERY JS
    // OPEN UPLOAD MODAL
    $(document).on('click', '.btnUploadGallery', function () {
        const matid = $(this).data('id');
        $('#upload_mat_id').val(matid);
        $('#gallery_files').val('');
        $('#gallery_preview').html('');
        $('#modalUploadGallery').modal('show');
    });

    // PREVIEW IMAGES
    $('#gallery_files').on('change', function() {
        const files = this.files;
        const previewContainer = $('#gallery_preview');
        previewContainer.html('');

        if (files) {
            [].forEach.call(files, function(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgCheck = `
                        <div class="col-4 col-md-3">
                            <div class="position-relative">
                                <img src="${e.target.result}" class="img-fluid rounded border" style="height: 100px; width: 100%; object-fit: cover;">
                            </div>
                        </div>`;
                    previewContainer.append(imgCheck);
                };
                reader.readAsDataURL(file);
            });
        }
    });

    // CONFIRM UPLOAD
    $('#btnConfirmUpload').on('click', function() {
        const matid = $('#upload_mat_id').val();
        const fileInput = $('#gallery_files')[0];
        const files = fileInput.files;

        if (files.length === 0) {
            Swal.fire('Warning', 'Please select at least one photo.', 'warning');
            return;
        }

        let formData = new FormData();
        formData.append('action', 'upload_gallery');
        formData.append('matid', matid);

        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        // Show loading
        Swal.fire({
            title: 'Uploading...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: 'fetch-material-master.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        title: 'Success',
                        text: res.message,
                        icon: 'success',
                        iconColor: '#198754',
                        confirmButtonColor: '#198754'
                    }).then(() => {
                        $('#modalUploadGallery').modal('hide');
                    });
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Upload failed.', 'error');
            }
        });
    });

JS;
    
    $content = substr_replace($content, $jsCode, $pos, 0); // Insert BEFORE </script>
    file_put_contents($file, $content);
    echo "JS appended.";
} else {
    echo "Script tag not found.";
}
?>
