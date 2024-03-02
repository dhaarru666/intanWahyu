<?php include("header.php") ?>
<?php
$nama       = "";


$ktp        = "";
$telepon    = "";
$alamat     = "";
$foto       = "";
$foto_name  = "";
$catatan    = "";
$kunci_data = "";

$error      = "";
$sukses     = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = "";
}

if ($id != "") {
    $sql1   = "select * from user where id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    $r1     = mysqli_fetch_array($q1);
    $nama       = $r1['nama'];
    $ktp        = $r1['ktp'];
    $telepon    = $r1['telepon'];
    $alamat     = $r1['alamat'];
    $catatan    = $r1['catatan'];
    $foto       = $r1['foto'];
    $kunci_data = $r1['kunci_data'];

    if ($ktp == '') {
        $error  = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) {
    $nama           = $_POST['nama'];
    $ktp            = $_POST['ktp'];
    $telepon        = $_POST['telepon'];
    $alamat         = $_POST['alamat'];
    $catatan        = $_POST['catatan'];
    $kunci_data     = $_POST['kunci_data'];


    if ($nama == '' or $ktp == '' or $telepon == '' or $alamat == '') {
        $error     = "Silakan masukkan data dengan benar!! Form bertanda (*) Wajib diiisi!";
    }

    if ($_FILES['foto']['name']) {
        $foto_name = $_FILES['foto']['name'];
        $foto_file = $_FILES['foto']['tmp_name'];

        $detail_file = pathinfo($foto_name);
        $foto_ekstensi = $detail_file['extension'];

        $ekstensi_yang_diperbolehkan = array("jpg", "jpeg", "png", "gif");
        if (!in_array($foto_ekstensi, $ekstensi_yang_diperbolehkan)) {
            $error = "Ekstensi yang diperbolehkan adalah jpg, jpeg, png dan gif";
        }
    }

    if (empty($error)) {
        if ($foto_name) {
            $direktori = "../gambar";

            @unlink($direktori . "/$foto"); //delete data

            $foto_name = "user_" . time() . "_" . $foto_name;
            move_uploaded_file($foto_file, $direktori . "/" . $foto_name);

            $foto = $foto_name;
        } else {
            $foto_name = $foto; //memasukkan data dari data yang sebelumnya ada
        }

        if ($id != "") {
            $sql1   = "update user set nama = '$nama',ktp='$ktp',telepon='$telepon',alamat='$alamat',catatan='$catatan',foto='$foto_name',kunci_data='$kunci_data',waktuDibuat=now() where id = '$id'";
        } else {
            $sql1       = "insert into user(nama,ktp,telepon,alamat,catatan,foto,kunci_data) values ('$nama','$ktp','$telepon','$alamat','$catatan','$foto_name','$kunci_data')";
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
<div style="text-align: right; margin-top: 20px; margin-right: 10px;">
    <a style="margin-top: 10px; font-size: 20px; color: #006495;">.Halaman</a>
    <a style="margin-top: 10px; font-size: 30px; margin-left: 5px; color: #006495;"><b>Input Data User</b></a>
</div>
<hr size="5px">
<div class="col-auto" style="margin-bottom: 10px;">
    <a href="halaman.php">
        <input type="button" class="btn btn-primary" value="Kembali" />
    </a>
</div>
<?php
if ($error) {
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
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3 row">
        <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap*</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nama" value="<?php echo $nama ?>" name="nama" placeholder="<?php echo $_SESSION['login_nama_lengkap'] ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="ktp" class="col-sm-2 col-form-label">Nomor KTP*</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="ktp" value="<?php echo $ktp ?>" name="ktp" placeholder="Masukan nomor KTP...">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="telepon" class="col-sm-2 col-form-label">Nomor Telepon*</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="telepon" value="<?php echo $telepon ?>" name="telepon" placeholder="Masukan nomor telepon...">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="alamat" class="col-sm-2 col-form-label">Alamat*</label>
        <div class="col-sm-10">
            <input name="alamat" class="form-control" id="alamat" placeholder="Masukan alamat..." value="<?php echo $alamat ?>"/>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="foto" class="col-sm-2 col-form-label">Foto KTP*</label>
        <div class="col-sm-10">
            <?php
            if ($foto) {
                echo "<img src='../gambar/$foto' style='max-height:100px;max-width:100px'/>";
            }
            ?>
            <input type="file" class="form-control" id="foto" name="foto">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="kunci_data" class="hide">Kunci_data</label>
        <select class="hide" aria-label="Small select example" id="kunci_data" name="kunci_data">
            <option value="<?php echo $_SESSION['login_nama_user'] ?>"><?php echo $_SESSION['login_nama_user'] ?></option>
        </select>
    </div>

    <div class="mb-3 row">
        <label for="catatan" class="col-sm-2 col-form-label" style="color: #B1B1B1;">Catatan</label>
        <label for="catatan" class="col-sm-2 col-form-label" style="color: #B1B1B1; width: 500;">Permintaan Cetak Kartu Keluarga Baru</label>
        <select class="hide" aria-label="Default select example" id="catatan" name="catatan">
            <option value="Permintaan Cetak Kartu Keluarga Baru" style="width: 300;">Permintaan Cetak Kartu Keluarga Baru</option>
        </select>
    </div>
    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
        </div>
    </div>
</form>
<?php include("footer.php") ?>