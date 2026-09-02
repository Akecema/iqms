<?php
$file = 'c:\xampp_7\htdocs\iQims\pages\material-list.php';
$content = file_get_contents($file);

// Find the LAST </script> tag
$pos = strrpos($content, '</script>');

if ($pos !== false) {
    $jsCode = <<<'JS'

    // VIEW IMAGES - OFFCANVAS
    $(document).on('click', '.btnViewImages', function() {
        const matid = $(this).data('id');
        $('#view_mat_id').val(matid);
        
        const offcanvasEl = document.getElementById('offcanvasGallery');
        const bsOffcanvas = new bootstrap.Offcanvas(offcanvasEl);
        bsOffcanvas.show();
        
        loadGalleryImages(matid);
    });

    function loadGalleryImages(matid) {
        $('#image_gallery_container').html('');
        $('#loading_images').removeClass('d-none');
        
        $.ajax({
            url: 'fetch-material-master.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_material_images',
                matid: matid
            },
            success: function(res) {
                $('#loading_images').addClass('d-none');
                
                if (res.status === 'success' && res.data.length > 0) {
                    let html = '';
                    res.data.forEach(function(img) {
                        html += `
                            <div class="col-md-4 col-sm-6 position-relative">
                                <div class="card h-100 border shadow-sm">
                                    <a href="${img.path}" class="lightgallery-item" data-src="${img.path}">
                                        <img src="${img.path}" class="card-img-top" style="height: 150px; object-fit: cover; cursor: zoom-in;">
                                    </a>
                                    <div class="card-body p-2 text-center">
                                        <button class="btn btn-danger btn-xs btnDeleteImage" data-id="${img.id}">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    $('#image_gallery_container').html(html);
                    
                    // Init lightGallery
                    if ($('#image_gallery_container').data('lightGallery')) {
                         $('#image_gallery_container').data('lightGallery').destroy(true);
                    }
                    $('#image_gallery_container').lightGallery({
                        selector: '.lightgallery-item',
                        thumbnail: true
                    });
                    
                } else {
                     $('#image_gallery_container').html('<div class="col-12 text-center text-muted">No images found.</div>');
                }
            },
            error: function() {
                $('#loading_images').addClass('d-none');
                $('#image_gallery_container').html('<div class="col-12 text-center text-danger">Failed to load images.</div>');
            }
        });
    }

    // DELETE IMAGE
    $(document).on('click', '.btnDeleteImage', function() {
        const btn = $(this);
        const imageid = btn.data('id');
        const matid = $('#view_mat_id').val();
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'fetch-material-master.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'delete_material_image',
                        imageid: imageid
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            loadGalleryImages(matid); // Reload
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Delete failed', 'error');
                    }
                });
            }
        });
    });

JS;
    
    $content = substr_replace($content, $jsCode, $pos, 0); // Insert BEFORE </script>
    file_put_contents($file, $content);
    echo "View JS appended.";
} else {
    echo "Script tag not found.";
}
?>
