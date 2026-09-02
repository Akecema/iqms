<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Compact Icon-Top Sidebar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

   
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="vendor/select2/css/select2.min.css">
	<link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link class="main-css" href="css/style.css" rel="stylesheet">
    <link class="main-css" href="css/add-style.css" rel="stylesheet">
	
    <!-- Tagify Css -->
	<link href="vendor/tagify/dist/tagify.css" rel="stylesheet">	
	<link href="vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">
    
	<link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
    
	<!-- Daterange picker -->
    <link href="vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Clockpicker -->
    <link href="vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
    <!-- asColorpicker -->
    <link href="vendor/jquery-ascolorpicker/css/ascolorpicker.min.css" rel="stylesheet">
    <!-- Material color picker -->
    <link href="vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
	
    <!-- Pick date -->
    <link rel="stylesheet" href="vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="vendor/pickadate/themes/default.date.css">
    
	<link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      background: #f5f6f8;
      font-family: 'Segoe UI', sans-serif;
    }

    .deznav {
      width: 80px;
      height: 100vh;
      background-color: #1f2619;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 20px;
    }

    .deznav .metismenu {
      list-style: none;
      padding: 0;
      margin: 0;
      width: 100%;
    }

    .deznav .metismenu > li {
      width: 100%;
    }

    .deznav .metismenu > li > a {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: #fff;
      padding: 12px 0;
      text-decoration: none;
      font-size: 11px;
      transition: background 0.2s ease;
    }

    .deznav .metismenu > li > a:hover {
      background: #3a4631;
      color: #fff;
    }

    .deznav .metismenu > li > a .menu-icon {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin-bottom: 4px;
    }

    .deznav .metismenu > li > a .menu-icon svg {
      display: block;
      width: 24px;
      height: 24px;
      margin: 0 auto;
      fill: #90959F;
    }

    .deznav .metismenu > li > a .nav-text {
      display: block;
      font-size: 11px;
      line-height: 1.2;
      color: #fff;
    }

    /* Optional: highlight active item */
    .deznav .metismenu > li.active > a {
      background-color: #324131;
      font-weight: 600;
    }

    /* Main page content */
    .main-content {
      margin-left: 80px;
      padding: 30px;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="deznav">
  <ul class="metismenu">
    <!-- Dashboard -->
    <li class="active">
      <a href="#" data-bs-toggle="tooltip" title="Dashboard">
        <div class="menu-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M9.13478 20.7733V17.7156C9.13478 16.9351 9.77217 16.3023 10.5584 16.3023H13.4326C13.8102 16.3023 14.1723 16.4512 14.4393 16.7163C14.7063 16.9813 14.8563 17.3408 14.8563 17.7156V20.7733C14.8539 21.0978 14.9821 21.4099 15.2124 21.6402C15.4427 21.8705 15.756 22 16.0829 22H18.0438C18.9596 22.0024 19.8388 21.6428 20.4872 21.0008C21.1356 20.3588 21.5 19.487 21.5 18.5778V9.86686C21.5 9.13246 21.1721 8.43584 20.6046 7.96467L13.934 2.67587C12.7737 1.74856 11.1111 1.7785 9.98539 2.74698L3.46701 7.96467C2.87274 8.42195 2.51755 9.12064 2.5 9.86686V18.5689C2.5 20.4639 4.04738 22 5.95617 22H7.87229C8.55123 22 9.103 21.4562 9.10792 20.7822L9.13478 20.7733Z" fill="#90959F"/>
          </svg>
        </div>
        <span class="nav-text">Dashboard</span>
      </a>
    </li>

    <!-- Pre Delivery Inspection -->
    <li>
      <a href="#" data-bs-toggle="tooltip" title="Pre Delivery Inspection">
        <div class="menu-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g opacity="0.5">
              <path d="M9.34933 14.8577C5.38553 14.8577 2 15.47 2 17.9174C2 20.3666 5.364 21 9.34933 21C13.3131 21 16.6987 20.3877 16.6987 17.9404C16.6987 15.4911 13.3347 14.8577 9.34933 14.8577Z" fill="white"/>
              <path opacity="0.4" d="M9.34935 12.5248C12.049 12.5248 14.2124 10.4062 14.2124 7.76241C14.2124 5.11865 12.049 3 9.34935 3C6.65072 3 4.48633 5.11865 4.48633 7.76241C4.48633 10.4062 6.65072 12.5248 9.34935 12.5248Z" fill="white"/>
              <path opacity="0.4" d="M16.1734 7.84876C16.1734 9.19508 15.7605 10.4513 15.0364 11.4948C14.9611 11.6022 15.0276 11.7468 15.1587 11.7698C15.3407 11.7996 15.5276 11.8178 15.7184 11.8216C17.6167 11.8705 19.3202 10.6736 19.7908 8.87119C20.4885 6.19677 18.4415 3.79544 15.8339 3.79544C15.5511 3.79544 15.2801 3.82419 15.0159 3.87689C14.9797 3.88456 14.9405 3.9018 14.921 3.93247C14.8955 3.97176 14.9141 4.02254 14.9395 4.05608C15.7233 5.13217 16.1734 6.44208 16.1734 7.84876Z" fill="white"/>
              <path d="M21.7791 15.1693C21.4318 14.444 20.5932 13.9466 19.3173 13.7023C18.7155 13.5586 17.0854 13.3545 15.5697 13.3832C15.5472 13.3861 15.5345 13.4014 15.5325 13.411C15.5296 13.4263 15.5365 13.4493 15.5658 13.4656C16.2664 13.8048 18.9738 15.2805 18.6333 18.3928C18.6187 18.5289 18.7292 18.6439 18.8672 18.6247C19.5335 18.5318 21.2478 18.1705 21.7791 17.0475C22.0737 16.4534 22.0737 15.7634 21.7791 15.1693Z" fill="white"/>
            </g>
          </svg>
        </div>
        <span class="nav-text">Pre Delivery</span>
      </a>
    </li>

  </ul>
</div>

<div class="main-content">
  <h2>Welcome</h2>
  <p>This is your content area.</p>
</div>

<!-- Bootstrap JS for tooltips -->
 <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="vendor/bootstrap-datepicker-master/js/bootstrap-datepicker.min.js"></script>
    <script src="vendor/chart-js/chart.bundle.min.js"></script>
	<!-- Apex Chart -->
	<script src="vendor/apexchart/apexchart.js"></script>

    <!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/responsive/responsive.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>

    <!-- Daterangepicker -->
    <!-- momment js is must -->
    <script src="vendor/moment/moment.min.js"></script>
    <script src="vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- clockpicker -->
    <script src="vendor/clockpicker/js/bootstrap-clockpicker.min.js"></script>
    <!-- asColorPicker -->
	<script src="vendor/jquery-ascolor/jquery-ascolor.min.js"></script>
    <script src="vendor/jquery-asgradient/jquery-asgradient.min.js"></script>
    <script src="vendor/jquery-ascolorpicker/js/jquery-ascolorpicker.min.js"></script>
    <!-- Material color picker -->
    <script src="vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- pickdate -->
    <script src="vendor/pickadate/picker.js"></script>
    <script src="vendor/pickadate/picker.time.js"></script>
    <script src="vendor/pickadate/picker.date.js"></script>

    <!-- Daterangepicker -->
    <script src="js/plugins-init/bs-daterange-picker-init.js"></script>
    <!-- Clockpicker init -->
    <script src="js/plugins-init/clock-picker-init.js"></script>
    <!-- asColorPicker init -->
	<script src="js/plugins-init/jquery-ascolorpicker.init.js"></script>
    <!-- Material color picker init -->
    <script src="js/plugins-init/material-date-picker-init.js"></script>
    <!-- Pickdate -->
    <script src="js/plugins-init/pickadate-init.js"></script>

    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>
<script>
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
</script>

</body>
</html>
