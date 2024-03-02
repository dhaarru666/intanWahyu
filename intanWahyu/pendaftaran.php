<?php
include_once("inc_headerDaftar.php");
?>

<style>
    .error {
        padding: 20px;
        background-color: #f44336;
        color: #FFFFFF;
        margin-bottom: 15px;
        margin-top: 15px;
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

    .hide {
        display: none;
    }
</style>

<?php
$nama_user      = "";
$nama_lengkap   = "";
$akses          = "";

$error          = "";
$sukses         = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = "";
}

if ($id != "") {
    $sql1   = "select * from login where id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    $r1     = mysqli_fetch_array($q1);
    $nama_user       = $r1['nama_user'];
    $nama_lengkap    = $r1['nama_lengkap'];
    $password        = $r1['konfirmasi_password'];
    $akses           = $r1['akses'];

    if ($nama_user == '') {
        $error  = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) {
    $nama_user              = $_POST['nama_user'];
    $nama_lengkap           = $_POST['nama_lengkap'];
    $password               = $_POST['password'];
    $konfirmasi_password    = $_POST['konfirmasi_password'];
    $akses                  = $_POST['akses'];


    if ($nama_user == '' or $nama_lengkap == '' or $password == '') {
        $error     .= "<li>Silakan masukkan data dengan benar!! Form bertanda (*) Wajib diiisi!</li>";
    }

    if ($nama_user != '') {
        $sql1   = "select nama_user from login where nama_user = '$nama_user'";
        $q1     = mysqli_query($koneksi, $sql1);
        $n1     = mysqli_num_rows($q1);

        if ($n1 > 0) {
            $error .= "<li>Nama User sudah terdaftar!!</li>";
        }
    }

    if ($password != $konfirmasi_password) {
        $error .= "<li>Password dan Konfirmasi Password tidak sesuai!!</li>";
    }

    if (strlen($password) < 6) {
        $error .= "<li>Panjang Karakter yang diizinkan untuk password paling tidak 6 karakter!!</li>";
    }

    if (empty($error)) {
        $sukses = "Proses Berhasil!!";
    }

    if (empty($error)) {

        header("location:login.php");

        if ($id != "") {
            $sql1   = "update login set nama_user = '$nama_user',nama_lengkap='$nama_lengkap',password='$password',akses='$akses',waktuDibuat=now() where id = '$id'";
        } else {
            $sql1       = "insert into login(nama_user,nama_lengkap,password,akses) values ('$nama_user','$nama_lengkap',md5($password),'$akses')";
        }

        $q1         = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses     = "Sukses memasukkan data";
        } else {
            $error      = "Gagal cuy masukkan data";
        }
    }
}
?>
<?php if ($error) {
    echo "<div class='error'><ul>$error</ul></div>";
} ?>
<?php if ($sukses) {
    echo "<div class='sukses'>$sukses</div>";
} ?>

<div style="text-align: right; margin-top: 20px; margin-right: 10px;">
    <a style="margin-top: 10px; font-size: 20px; color: #006495;">.Halaman</a>
    <a style="margin-top: 10px; font-size: 30px; margin-left: 5px; color: #006495;"><b>Pendaftaran</b></a>
</div>
<hr size="5px">
<div class="col-auto" style="margin-bottom: 10px;">
    <a href="login.php">
        <input type="button" class="btn btn-primary" value="Kembali" />
    </a>
</div>
<?php
/*if ($error) {
?>
    <div class="alert alert-danger" role="alert" style="margin-top: 20px;">
        <?php echo $error ?>
    </div>
<?php
}
?>
<?php
if ($sukses) {
?>
    <div class="alert alert-success" role="alert" style="margin-top: 20px;">
        <?php echo $sukses ?>
    </div>
<?php
}*/
?>
<form action="" method="post">
    <div class="mb-3 row">
        <label for="nama_user" class="col-sm-2 col-form-label">Nama User*</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nama_user" placeholder="Masukan Nama User Anda..." value="<?php echo $nama_user ?>" name="nama_user">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap*</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nama_lengkap" placeholder="Masukan Nama Lengkap..." value="<?php echo $nama_lengkap ?>" name="nama_lengkap">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="password" class="col-sm-2 col-form-label">Password*</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="password" placeholder="Masukan kata sandi..." value="<?php echo $password ?>" name="password">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="konfirmasi_password" class="col-sm-2 col-form-label">Konfirmasi Password*</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" placeholder="Masukan ulang kata Sandi...">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="nama_lengkap" class="col-sm-2 col-form-label" style="color: #B1B1B1;">Akses</label>
        <label for="nama_lengkap" class="col-sm-2 col-form-label" style="color: #B1B1B1;">pengguna</label>
    </div>
    <div class="mb-3 row">
        <label for="akses" class="hide">Akses</label>
        <select class="hide" aria-label="Small select example" id="akses" name="akses">
            <option value="pengguna">Pengguna</option>
        </select>
    </div>
    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
        </div>
    </div>
</form>

<?php
include_once("inc_footer.php");
?>