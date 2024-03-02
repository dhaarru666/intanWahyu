<?php
include_once("inc/inc_koneksi.php");
?>
<?php
$nama_user      = "";
$password       = "";
$error          = "";

if (isset($_POST['masuk'])) {
    $nama_user      = $_POST['nama_user'];
    $password       = $_POST['password'];

    if($nama_user == '' or $password == ''){
        $error .= "<li>Silahkan masukan nama user dan password dengan benar!!</li>";
    } else {
        $sql1   = "select * from login where nama_user = '$nama_user'";
        $q1     = mysqli_query($koneksi,$sql1);
        $r1     = mysqli_fetch_array($q1);
        $n1     = mysqli_num_rows($q1);

        if($r1['akses'] != 'pengguna' && $r1['akses'] != 'admin' && $n1 > 0){
            $error .= "<li>Akun yang anda miliki tidak terdaftar!!</li>";
        }

        if($r1['password'] != md5($password) && $n1 >0 && $r1['akses'] == 'pengguna'){
            $error .= "<li>Password yang anda masukan tidak sesuai!!</li>";
        }

        if ($n1 < 1){
            $error .="<li>Akun tidak di temukan!!</li>";
        }

        if(empty($error)){
            session_start();
            $_SESSION['login_nama_user'] = $nama_user;
            $_SESSION['login_nama_lengkap'] = $r1['nama_lengkap'];
            if($r1['akses'] == 'admin'){
                header("location:admin/halaman.php");
            } else {
                header("location:halamanUser.php");
            }
            
            exit();
        }
    }
}
?>
<?php 
if($error){
    echo "<div class='error'><ul class='pesan'>$error</ul></div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<style>
    body {
        background-image: url("gambarLogin/latar.jpg");
        background-size: cover;
    }

    .kartu {
        background-color: white;
        padding: 5px;
        position: absolute;
        top: 30;
        right: 80;
        width: 300px;
        height: 400;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }

    .tittle {
        position: fixed;
        color: white;
        left: 50;
        top: 120;
        text-shadow: 3px 2px 1px rgba(0, 0, 0, 0.25);
    }

    .error {
        padding: 20px;
        background-color: #f44336;
        color: #FFFFFF;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }

    .sukses {
        padding: 20px;
        background-color: #2196F3;
        color: #FFFFFF;
        margin-bottom: 15px;
        margin-top: 15px;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login WEB Intan Wahyu</title>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <link href="../css/summernote-image-list.min.css">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>
    <div class="kartu">
        <div style="text-align: center; margin-top: 30;">
            <P><b>Masuk Akun</b></P>
        </div>
        <form action="" method="post">
            <div class="col-auto" style="margin-top: 10px; margin-left: 20px;">
                <input style="width: 250px;" type="text" class="form-control" placeholder="Nama User" name="nama_user" value="<?php $nama_user ?>" />
            </div>
            <div class="col-auto" style="margin-top: 10px; margin-left: 20px;">
                <input style="width: 250px;" type="password" class="form-control" placeholder="kata sandi" name="password" />
            </div>
            <div class="col-auto" style="margin-left: 95px; margin-top: 10px;">
                <a href="admin/halamanUser.php">
                    <input style="font-size: 13px; width: 100px;" type="submit" value="Masuk" class="btn btn-primary" name="masuk" />
                </a>
            </div>
        </form>
        <div style="text-align: center;">
            <p>Belum Punya Akun? Silahkan Login</br>
                <a href="pendaftaran.php">Di sini.</a>
            </p>
        </div>
        <div style="text-align: center; margin-top: 50px;">
            <p style="font-size: 13px; color: #B2B3B4;">Copyright &copy; Intan Wahyu</p>
        </div>
    </div>
    <div class="tittle">
        <h1>Intan Wahyu</h1>
        <p>Aplikasi Permohonan Cetak Kartu Keluarga Berbasis Web, </p>
        <p>Dengan Algoritma Sorting, Search Dan Hashing.</p>
    </div>
</body>

</html>