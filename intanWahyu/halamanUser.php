<?php include("inc_header.php") ?>
<?php
$kunci_data =  $_SESSION['login_nama_user'];
$sukses = "";
$pencarian = (isset($_GET['pencarian'])) ? $_GET['pencarian'] : "";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1   = "delete from user where id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses     = "Berhasil hapus data";
    }
}

?>
<div style="text-align: right; margin-top: 20px; margin-right: 10px;">
    <a style="margin-top: 10px; font-size: 20px; color: #006495;">.Halaman</a>
    <a style="margin-top: 10px; font-size: 30px; margin-left: 5px; color: #006495;"><b>Beranda Pengguna</b></a>
</div>
<hr size="5px">

<p>Selamat Datang <b><?php echo $_SESSION['login_nama_lengkap'] ?>,</b> Di Halaman Permohonan Anda.</p>

<?php
if ($sukses) {
?>
    <div class="alert alert-success" role="alert">
        <?php echo $sukses ?>
    </div>
<?php
}
?>

<form class="row g-3" method="get">
    <div class="col-auto">
        <input style="width: 300px;" type="text" class="form-control" placeholder="Pencaharian..." name="pencarian" value="<?php echo $pencarian ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari" class="btn btn-primary" />
    </div>
    <div class="col-auto">
        <a href="admin/userInput.php">
            <input type="button" class="btn btn-primary" value="+ Tambah Permohonan" />
        </a>
    </div>
</form>
<table class="table table-striped" style="margin-top: 20px;">
    <thead>
        <tr>
            <th width="20px">No</th>
            <th width="200px">Nama</th>
            <th width="200px">NIK</th>
            <th width="200px">Telepon</th>
            <th width="500px">Alamat</th>
            <th width="400px">Keperluan</th>
            <th class="col-2" style="width: 50px"></th>
        </tr>
    </thead>
    <tbody>
        <?php

        $sqltambahan = "";

        $per_halaman = 10;
        if ($pencarian != '') {
            $array_pencarian = explode(" ", $pencarian);
            for ($x = 0; $x < count($array_pencarian); $x++) {
                $sqlcari[] = "(nama like '%" . $array_pencarian[$x] . "%' or ktp like '%" . $array_pencarian[$x] . "%')";
            }
            $sqltambahan    = " where " . implode(" or ", $sqlcari);
        }

        $sql1   = "select * from user where kunci_data='$kunci_data'";
        $sql2   = "select * from user $sqltambahan";
        $page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $mulai  = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1     = mysqli_query($koneksi, $sql1);
        $total  = mysqli_num_rows($q1);
        $pages  = ceil($total / $per_halaman);
        $nomor  = $mulai + 1;
        $sql1   = $sql1 . " order by id desc limit $mulai,$per_halaman";
        $sql2   = $sql2 . " order by id desc limit $mulai,$per_halaman";
        while ($r1 = mysqli_fetch_array($q1)) {
            if ($r1['foto_kk'] == "") {
        ?>
                <tr>
                    <td><?php echo $nomor++ ?></td>
                    <td>
                        <a href="detailUser.php?id=<?php echo $r1['id'] ?>">
                            <span><?php echo $r1['nama'] ?></span>
                        </a>
                    </td>
                    <td><?php echo $r1['ktp'] ?></td>
                    <td><?php echo $r1['telepon'] ?></td>
                    <td><?php echo $r1['alamat'] ?></td>
                    <td><?php echo $r1['catatan'] ?></td>

                    <td>
                        <a href="#">
                            <span class="badge bg-secondary">Unduh Belum Tersedia</span>
                        </a>
                    </td>
                    <td>
                        <a href="halamanUser.php?op=delete&id=<?php echo $r1['id'] ?>" onclick="return confirm('Apakah yakin mau hapus Data?')">
                            <span class="badge bg-danger btn-sm">Hapus</span>
                        </a>
                    </td>
                </tr>
            <?php
            } else {
            ?>
                <tr>
                    <td><?php echo $nomor++ ?></td>
                    <td>
                        <a href="detailUser.php?id=<?php echo $r1['id'] ?>">
                            <span><?php echo $r1['nama'] ?></span>
                        </a>
                    </td>
                    <td><?php echo $r1['ktp'] ?></td>
                    <td><?php echo $r1['telepon'] ?></td>
                    <td><?php echo $r1['alamat'] ?></td>
                    <td><?php echo $r1['catatan'] ?></td>

                    <td>
                        <a href="download.php?filename=<?php echo $r1['foto_kk'] ?>">
                            <span class="badge bg-primary">Download</span>
                        </a>
                    </td>
                    <td>
                        <a href="halamanUser.php?op=delete&id=<?php echo $r1['id'] ?>" onclick="return confirm('Apakah yakin mau hapus Data?')">
                            <span class="badge bg-danger btn-sm">Hapus</span>
                        </a>
                    </td>
                </tr>
        <?php
            }
        }
        ?>

    </tbody>
</table>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php
        $cari = isset($_GET['cari']) ? $_GET['cari'] : "";

        for ($i = 1; $i <= $pages; $i++) {
        ?>
            <li class="page-item">
                <a class="page-link" href="halaman.php?pencarian=<?php echo $pencarian ?>&cari=<?php echo $cari ?>&page=<?php echo $i ?>"><?php echo $i ?></a>
            </li>
        <?php
        }
        ?>
    </ul>
</nav>
<?php include("inc_footer.php") ?>