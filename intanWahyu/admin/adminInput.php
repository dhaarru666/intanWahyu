<?php include("header.php") ?>
<?php
$nama       = "";


$ktp        = "";
$telepon    = "";
$alamat     = "";
$foto_kk    = "";
$foto_name  = "";
$catatan    = "";

$error      = "";
$sukses     = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = "";
}

if($id != ""){
    $sql1   = "select * from user where id = '$id'";
    $q1     = mysqli_query($koneksi,$sql1);
    $r1     = mysqli_fetch_array($q1);
    $nama   = $r1['nama'];
    $ktp        = $r1['ktp'];
    $telepon    = $r1['telepon'];
    $alamat     = $r1['alamat'];
    $catatan    = $r1['catatan'];
    $foto_kk    = $r1['foto_kk'];

    if($ktp == ''){
        $error  = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) {


    if ($nama == '' or $ktp == '' or $telepon == '' or $alamat == '') {
        $error     = "Silakan masukkan data dengan benar!! Form bertanda (*) Wajib diiisi!";
    }
    
    if($_FILES['foto_kk']['name']){
        $foto_name = $_FILES['foto_kk']['name'];
        $foto_file = $_FILES['foto_kk']['tmp_name'];

        $detail_file = pathinfo($foto_name);
        $foto_ekstensi = $detail_file['extension'];

        $ekstensi_yang_diperbolehkan = array("jpg","jpeg","png","gif","pdf");
        if(!in_array($foto_ekstensi,$ekstensi_yang_diperbolehkan)){
            $error = "Ekstensi yang diperbolehkan adalah (jpg, jpeg, png, gif, pdf)";
        }

    }

    if (empty($error)) {
        if($foto_name){
            $direktori = "../gambar";

            @unlink($direktori."/$foto_kk"); //delete data

            $foto_name = "user_".time()."_".$foto_name;
            move_uploaded_file($foto_file,$direktori."/".$foto_name);

            $foto_kk = $foto_name;
        }else{
            $foto_name = $foto_kk; //memasukkan data dari data yang sebelumnya ada
        }

        if($id != ""){
            $sql1   = "update user set nama = '$nama',ktp='$ktp',telepon='$telepon',alamat='$alamat',catatan='$catatan',foto_kk='$foto_name',waktuUpload=now() where id = '$id'";
        }else{
            $sql1       = "insert into user(nama,ktp,telepon,alamat,catatan,foto_kk) values ('$nama','$ktp','$telepon','$alamat','$catatan','$foto_name')";
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
    <a style="margin-top: 10px; font-size: 30px; margin-left: 5px; color: #006495;"><b>Upload Permintaan</b></a>
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
        <label for="foto_kk" class="col-sm-2 col-form-label">Upload Kartu Keluarga</label>
        <div class="col-sm-10">
            <?php 
            if($foto_kk){
                echo "<img src='../gambar/$foto_kk' style='max-height:100px;max-width:500px'/>";
            }
            ?>
            <input type="file" class="form-control" id="foto_kk" name="foto_kk" style="margin-top: 10px;">
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
        </div>
    </div>
</form>
<?php include("footer.php") ?>