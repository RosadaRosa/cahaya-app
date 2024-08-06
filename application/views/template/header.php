<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title; ?></title>

  <script src="<?= base_url('assets/pdfmake/build/pdfmake.min.js') ?>"></script>
  <script src="<?= base_url('assets/pdfmake/build/vfs_fonts.js') ?>"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/adminlte.min.css') ?>">

  <style>
    .main-header {
      background-color: #6295A2; /* Set background color */
      display: flex;
      align-items: center;
      height: 60px; /* Adjust height as needed */
      padding: 0 15px; /* Optional: add padding for better spacing */
    }
    .header-title {
      flex: 1;
      text-align: center;
      font-family: 'Source Sans Pro', sans-serif;
      font-size: 24px;
      color: white;
      font-weight: bold;
    }
    .navbar-nav {
      display: flex;
      align-items: center;
    }
    .navbar-nav .nav-item .nav-link {
      color: black; /* Ensure the color for the name is black */
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Center navbar title -->
      <div class="header-title">
        TOKO CAHAYA
      </div>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" style="margin-right: 10px; margin-top: 7px;" id="namaLink">
            <?php echo $this->session->userdata('nama_lengkap') ?>
          </a>
          <button id="logoutButton" style="display: none;">Logout</button>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</body>
</html>
