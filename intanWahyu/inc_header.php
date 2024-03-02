<?php
session_start();
include("inc/inc_koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Intan Wahyu</title>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <link href="../css/summernote-image-list.min.css">
    <script src="../js/summernote-image-list.min.js"></script>

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    
    <title>Intan Wahyu Data</title>
    <style>
        .image-list-content .col-lg-3 {
            width: 100%;
        }

        .image-list-content img {
            float: left;
            width: 20%
        }

        .image-list-content p {
            float: left;
            padding-left: 20px
        }

        .image-list-item {
            padding: 10px 0px 10px 0px
        }

        .namaKolom {
            width: 100px;
        }
    </style>
</head>

<body class="container">
    <header>
        <nav class="navbar navbar navbar-expand-lg navbar-dark bg-primary" style="background-color: #229954;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="logo.webp" alt="logoWeb" height="50" width="50" />
                    Intan Data
                </a>
                <div>
                    <div class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#"> <img src="profileIcon.png" alt="logoWeb" height="30" width="30" style="margin-right: 5px;"/> User : <?php echo $_SESSION['login_nama_user']?> </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">|</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php" tabindex="-1" aria-disabled="true">Keluar</a>
                        </li>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>