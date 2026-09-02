<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>LightGallery AJAX PHP Demo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- LightGallery CSS -->
  <link href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css" rel="stylesheet"/>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    #imagePreview { display: none; margin-top: 20px; }
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 10px;
    }
    .gallery-grid .grid-item img {
        width: 100%;
        border-radius: 5px;
    }
    .btn {
        padding: 10px 20px;
        background: #4b49ac;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
  </style>
</head>
<body>

<h2>LightGallery AJAX PHP Demo</h2>
<button id="btnSubmit" class="btn">Load Gallery via AJAX</button>

<!-- Preview Container -->
<div id="imagePreview">
  <div class="gallery-grid" id="lightgallery"></div>
</div>

<!-- LightGallery JS -->
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/thumbnail/lg-thumbnail.umd.min.js"></script>

<script>
let lgInstance = null;

$('#btnSubmit').on('click', function () {
    $.ajax({
        url: 'ajax-gallery.php',
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            $('#lightgallery').html(response.gallery_html);
            $('#imagePreview').slideDown();

            if (lgInstance) {
                lgInstance.destroy();
            }

            lgInstance = lightGallery(document.getElementById('lightgallery'), {
                selector: 'a.grid-item',
                thumbnail: true
            });
        },
        error: function () {
            $('#lightgallery').html('<p style="color:red;">Failed to load images.</p>');
        }
    });
});
</script>

</body>
</html>
