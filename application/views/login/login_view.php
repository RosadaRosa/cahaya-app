<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/adminlte.min.css') ?>">
    
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #4B70F5;
        }

        .card {
            background-color: #F6F5F2;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 500px; /* Reduced max-width from 600px to 500px */
            padding: 30px; /* Reduced padding from 40px to 30px */
            border-radius: 10px;
        }

        .card-header {
            background-color: #F6F5F2;
            color: #000; /* Changed to black */
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            text-align: center;
            width: 100%;
        }

        .card-body {
            padding: 15px; /* Reduced padding from 20px to 15px */
            width: 100%;
            text-align: center;
        }

        .splash-description {
            color: #000000;
            font-size: 16px;
            margin-bottom: 15px; /* Reduced margin-bottom from 20px to 15px */
        }

        .form-group {
            margin-bottom: 10px; /* Reduced margin-bottom from 15px to 10px */
        }

        .form-control {
            border: 1px solid #322C2B;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
        }

        .btn-primary {
            background-color: #5a99d4;
            border-color: #5a99d4;
            padding: 10px;
            width: 100%;
        }

        .img-container img {
            width: 50%; /* Make the logo span the entire width of the card */
            height: auto;
            margin-bottom: 10px; /* Reduced margin-bottom from 20px to 10px */
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <div class="img-container">
                <img src="<?php echo base_url('assets/dist/img/cahayalogo.png') ?>" alt="Logo">
            </div>
            <h1>CAHAYA-APP</h1>
        </div>
        <div class="card-body">
            <span class="splash-description">Silahkan Login Terlebih Dahulu</span>
            <?php $this->load->view('template/notifikasi'); ?>
            <form action="<?= base_url('login/index') ?>" method="post">
                <div class="form-group">
                    <input class="form-control form-control-lg" name="username" type="text" placeholder="Username" autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" name="password" type="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
            </form>
        </div>
    </div>

    <script src="<?php echo base_url('assets/vendor/jquery/jquery-3.3.1.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.js') ?>"></script>
</body>

</html>
