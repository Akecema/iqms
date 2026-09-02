<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Editable Defect Table Demo</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    .avatar-sm { width: 48px; height: 48px; object-fit: cover; border-radius: 50%; }
    .table td, .table th { vertical-align: middle; }
    .defect-photo-preview { width: 48px; height: 48px; object-fit: cover; border-radius: 50%; }
  </style>
</head>
<body class="p-4">

<div class="container">
  <h4 class="mb-3">Defect Details Table (Editable Demo)</h4>
  <table class="table table-bordered" id="defectTable">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Defect Type</th>
        <th>Area</th>
        <th>Defect Photo</th>
        <th>Edit</th>
      </tr>
    </thead>
    <tbody>
      <!-- Demo data; normally populated by backend -->
      <tr>
        <td>1</td>
        <td class="defect-type">Crack</td>
        <td class="defect-area">1,5</td>
        <td class="defect-photo">
          <img src="https://randomuser.me/api/portraits/women/44.jpg" class="avatar-sm" />
        </td>
        <td>
          <button class="btn btn-outline-primary btn-sm edit-btn">Edit</button>
          <button class="btn btn-outline-success btn-sm save-btn d-none">Save</button>
          <button class="btn btn-outline-secondary btn-sm cancel-btn d-none">Cancel</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
const defectTypes = ["Crack", "Dent", "Scratch", "Discoloration"];
const areaOptions = ["1", "2", "3", "4", "5"];

// Save original row data for cancel
let originalRow = {};

$(document).on('click', '.edit-btn', function() {
  const $row = $(this).closest('tr');
  // Store original HTML in memory for cancel
  originalRow[$row.index()] = $row.html();

  // Show Save/Cancel
  $row.find('.edit-btn').addClass('d-none');
  $row.find('.save-btn, .cancel-btn').removeClass('d-none');

  // 1. Defect Type (dropdown)
  const currType = $row.find('.defect-type').text().trim();
  let typeOptions = defectTypes.map(t =>
    `<option value="${t}"${t === currType ? ' selected' : ''}>${t}</option>`
  ).join('');
  $row.find('.defect-type').html(`<select class="form-select form-select-sm defect-type-edit">${typeOptions}</select>`);

  // 2. Area (checkboxes)
  const currAreas = $row.find('.defect-area').text().split(',').map(a => a.trim());
  let areaCheckboxes = areaOptions.map(a =>
    `<label class="me-2"><input type="checkbox" class="form-check-input area-edit" value="${a}"${currAreas.includes(a) ? ' checked' : ''}> ${a}</label>`
  ).join('');
  $row.find('.defect-area').html(areaCheckboxes);

  // 3. Defect Photo (Change button)
  let oldPhotoSrc = $row.find('.defect-photo img').attr('src');
  $row.find('.defect-photo').html(`
    <img src="${oldPhotoSrc}" class="defect-photo-preview me-2" id="photoPreview"/>
    <input type="file" class="form-control form-control-sm d-inline-block w-auto defect-photo-input" style="width:180px;" accept="image/*">
  `);
});

// On photo file change: preview
$(document).on('change', '.defect-photo-input', function(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(ev) {
      $('#photoPreview').attr('src', ev.target.result);
    };
    reader.readAsDataURL(file);
  }
});

// Save
$(document).on('click', '.save-btn', function() {
  const $row = $(this).closest('tr');
  const idx = $row.index();

  // Get new values
  const newType = $row.find('.defect-type-edit').val();
  const newAreas = $row.find('.area-edit:checked').map(function() { return $(this).val(); }).get().join(',');
  let newPhotoSrc = $row.find('#photoPreview').attr('src');

  // Replace with display mode
  $row.find('.defect-type').text(newType);
  $row.find('.defect-area').text(newAreas);
  $row.find('.defect-photo').html(`<img src="${newPhotoSrc}" class="avatar-sm" />`);

  $row.find('.edit-btn').removeClass('d-none');
  $row.find('.save-btn, .cancel-btn').addClass('d-none');

  // In real use: AJAX to save here
  // e.g. formData.append('defect_type', newType), etc.
});

// Cancel (revert row)
$(document).on('click', '.cancel-btn', function() {
  const $row = $(this).closest('tr');
  const idx = $row.index();
  if (originalRow[idx]) {
    $row.html(originalRow[idx]);
  }
});
</script>
</body>
</html>
