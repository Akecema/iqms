<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Defect - Slide Over Panel Demo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .defect-avatar { width:48px; height:48px; object-fit:cover; border-radius:50%; border:2px solid #eee; cursor:zoom-in; }
    .highlight-row { animation: flash 1s; }
    @keyframes flash {
      0% { background: #fff3cd; }
      100% { background: inherit; }
    }
    /* Slide-over drawer styles */
    .drawer-backdrop {
      position: fixed; inset: 0; background: rgba(0,0,0,0.2); z-index: 1055; display: none;
    }
    .drawer {
      position: fixed; top: 0; right: 0; height: 100vh; width: 100%; max-width: 420px;
      background: #fff; z-index: 1060; box-shadow: -3px 0 24px rgba(0,0,0,0.15);
      transform: translateX(100%); transition: transform .35s cubic-bezier(.36,1.4,.42,.95);
      display: flex; flex-direction: column;
    }
    .drawer.open { transform: translateX(0); }
    .drawer-backdrop.open { display: block; }
    .drawer-header { padding: 1.2rem 1.5rem 1rem 1.5rem; border-bottom: 1px solid #f1f1f1; }
    .drawer-body { flex: 1; overflow-y: auto; padding: 1.5rem; }
    .drawer-footer { border-top: 1px solid #f1f1f1; padding: 1rem 1.5rem; }
    .drawer-close { background: none; border: none; font-size: 1.7rem; color: #333; }
    /* Toast position */
    .toast-container { position: fixed; top: 1rem; right: 1rem; z-index: 2000; }
    @media (max-width: 600px) {
      .drawer { max-width: 100vw; }
    }
  </style>
</head>
<body class="bg-light">

<div class="container py-5">
  <h4 class="mb-4">Defect Table</h4>
  <div class="table-responsive">
    <table class="table table-borderless rounded-3 overflow-hidden bg-white shadow-sm align-middle" id="defectTable">
      <thead class="bg-light">
        <tr>
          <th>#</th>
          <th>Defect Type</th>
          <th>Area</th>
          <th>Defect Photo</th>
          <th>Comparing Photo</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody>
        <tr data-id="1">
          <td>1</td>
          <td class="defect-type">Crack</td>
          <td class="defect-area">1.5</td>
          <td class="defect-photo">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="defect-avatar" alt="Defect" />
          </td>
          <td class="compare-photo">
            <img src="https://randomuser.me/api/portraits/men/47.jpg" class="defect-avatar" alt="Compare" />
          </td>
          <td>
            <button class="btn btn-outline-success btn-sm edit-btn">
              <i class="bi bi-pencil-square"></i> Edit
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Slide-Over Drawer Edit Panel -->
<div class="drawer-backdrop" id="drawerBackdrop"></div>
<div class="drawer" id="editDrawer" tabindex="-1">
  <div class="drawer-header d-flex justify-content-between align-items-center">
    <h5 class="m-0"><i class="bi bi-pencil-square me-2"></i>Edit Defect Details</h5>
    <button class="drawer-close" id="drawerCloseBtn" aria-label="Close">&times;</button>
  </div>
  <form id="editDefectForm" autocomplete="off" class="drawer-body">
    <div class="mb-3">
      <label class="form-label">Defect Type</label>
      <select class="form-select" name="defect_type" required>
        <option value="">Select Type</option>
        <option value="Crack">Crack</option>
        <option value="Dent">Dent</option>
        <option value="Discoloration">Discoloration</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Area</label>
      <input type="text" class="form-control" name="defect_area" placeholder="e.g. 1.5" required pattern="^\d+(\.\d+)?$" title="Enter a number (e.g. 1.5)">
    </div>
    <div class="row g-3 align-items-center">
      <div class="col-6">
        <label class="form-label">Defect Photo</label>
        <div class="d-flex align-items-center">
          <img id="editDefectPhoto" src="" class="defect-avatar border" alt="Defect Photo" data-bs-toggle="modal" data-bs-target="#photoZoomModal" />
          <input type="file" class="form-control ms-2" name="defect_photo" accept="image/*" style="max-width:130px;">
          <button type="button" class="btn btn-link btn-sm text-danger ms-1 p-0" title="Remove photo" id="removeDefectPhoto"><i class="bi bi-trash"></i></button>
        </div>
      </div>
      <div class="col-6">
        <label class="form-label">Comparing Photo</label>
        <div class="d-flex align-items-center">
          <img id="editComparePhoto" src="" class="defect-avatar border" alt="Compare Photo" data-bs-toggle="modal" data-bs-target="#photoZoomModal" />
          <input type="file" class="form-control ms-2" name="compare_photo" accept="image/*" style="max-width:130px;">
          <button type="button" class="btn btn-link btn-sm text-danger ms-1 p-0" title="Remove photo" id="removeComparePhoto"><i class="bi bi-trash"></i></button>
        </div>
      </div>
    </div>
    <div class="drawer-footer d-flex justify-content-end border-0 mt-4">
      <button type="button" class="btn btn-light me-2" id="drawerCancelBtn">Cancel</button>
      <button type="submit" class="btn btn-success px-4" id="saveBtn">
        <span id="saveBtnText">Save Changes</span>
        <span id="saveSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
      </button>
    </div>
  </form>
</div>

<!-- Photo Zoom Modal -->
<div class="modal fade" id="photoZoomModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0 shadow-none">
      <div class="modal-body d-flex justify-content-center align-items-center p-0">
        <img id="zoomedPhoto" src="" style="max-width:100%; max-height:75vh; border-radius:12px; box-shadow:0 0 18px rgba(0,0,0,0.3)">
      </div>
    </div>
  </div>
</div>

<!-- Toast for Success -->
<div class="toast-container">
  <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">Defect updated successfully!</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Drawer logic
  const drawer = document.getElementById('editDrawer');
  const backdrop = document.getElementById('drawerBackdrop');
  const openDrawer = () => {
    drawer.classList.add('open');
    backdrop.classList.add('open');
    setTimeout(()=>{ drawer.focus(); }, 200);
    document.body.style.overflow = 'hidden';
  };
  const closeDrawer = () => {
    drawer.classList.remove('open');
    backdrop.classList.remove('open');
    document.body.style.overflow = '';
  };
  document.getElementById('drawerCloseBtn').onclick = closeDrawer;
  document.getElementById('drawerCancelBtn').onclick = closeDrawer;
  backdrop.onclick = closeDrawer;
  // Allow ESC to close
  drawer.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });

  // Store current editing row globally
  let currentRow = null;
  let editPhotoSrc = '';
  let comparePhotoSrc = '';

  // Open drawer on edit button click
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      currentRow = this.closest('tr');
      const type = currentRow.querySelector('.defect-type').innerText.trim();
      const area = currentRow.querySelector('.defect-area').innerText.trim();
      const defectPhoto = currentRow.querySelector('.defect-photo img').src;
      const comparePhoto = currentRow.querySelector('.compare-photo img').src;

      // Fill drawer form
      document.querySelector('[name="defect_type"]').value = type;
      document.querySelector('[name="defect_area"]').value = area;
      document.getElementById('editDefectPhoto').src = defectPhoto;
      document.getElementById('editComparePhoto').src = comparePhoto;
      editPhotoSrc = defectPhoto;
      comparePhotoSrc = comparePhoto;

      // Clear file inputs
      document.querySelector('[name="defect_photo"]').value = "";
      document.querySelector('[name="compare_photo"]').value = "";

      openDrawer();
    });
  });

  // Image zoom logic
  document.getElementById('editDefectPhoto').onclick = function() {
    if (this.src) {
      document.getElementById('zoomedPhoto').src = this.src;
    }
  };
  document.getElementById('editComparePhoto').onclick = function() {
    if (this.src) {
      document.getElementById('zoomedPhoto').src = this.src;
    }
  };

  // Handle photo preview on file input change
  document.querySelector('[name="defect_photo"]').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
      const reader = new FileReader();
      reader.onload = e2 => {
        document.getElementById('editDefectPhoto').src = e2.target.result;
        editPhotoSrc = e2.target.result;
      };
      reader.readAsDataURL(this.files[0]);
    }
  });
  document.querySelector('[name="compare_photo"]').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
      const reader = new FileReader();
      reader.onload = e2 => {
        document.getElementById('editComparePhoto').src = e2.target.result;
        comparePhotoSrc = e2.target.result;
      };
      reader.readAsDataURL(this.files[0]);
    }
  });

  // Remove photo logic
  document.getElementById('removeDefectPhoto').onclick = function() {
    document.getElementById('editDefectPhoto').src = '';
    editPhotoSrc = '';
    document.querySelector('[name="defect_photo"]').value = "";
  };
  document.getElementById('removeComparePhoto').onclick = function() {
    document.getElementById('editComparePhoto').src = '';
    comparePhotoSrc = '';
    document.querySelector('[name="compare_photo"]').value = "";
  };

  // Handle form submit
  document.getElementById('editDefectForm').onsubmit = function(e) {
    e.preventDefault();
    // Validate
    if (!this.checkValidity()) {
      this.classList.add('was-validated');
      return;
    }
    // Simulate save
    document.getElementById('saveBtnText').classList.add('d-none');
    document.getElementById('saveSpinner').classList.remove('d-none');
    setTimeout(function() {
      // Update table row
      if (currentRow) {
        currentRow.querySelector('.defect-type').innerText = document.querySelector('[name="defect_type"]').value;
        currentRow.querySelector('.defect-area').innerText = document.querySelector('[name="defect_area"]').value;
        currentRow.querySelector('.defect-photo img').src = editPhotoSrc || "https://via.placeholder.com/48x48?text=No+Photo";
        currentRow.querySelector('.compare-photo img').src = comparePhotoSrc || "https://via.placeholder.com/48x48?text=No+Photo";
        // Highlight row
        currentRow.classList.add('highlight-row');
        setTimeout(() => currentRow.classList.remove('highlight-row'), 1500);
      }
      // Reset Save button
      document.getElementById('saveBtnText').classList.remove('d-none');
      document.getElementById('saveSpinner').classList.add('d-none');
      // Hide drawer
      closeDrawer();
      // Show toast
      const toast = new bootstrap.Toast(document.getElementById('successToast'));
      toast.show();
    }, 900);
  };

  // Optional: allow swipe to close on mobile
  let startX = 0;
  drawer.addEventListener('touchstart', (e) => { startX = e.touches[0].clientX; });
  drawer.addEventListener('touchmove', (e) => {
    const deltaX = e.touches[0].clientX - startX;
    if (deltaX < -50) closeDrawer();
  });
</script>
</body>
</html>
