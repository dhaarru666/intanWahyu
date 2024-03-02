<?php
$host       = "127.0.0.1";
$user       = "root";
$pwd        = "";
$db         = "intanwahyu";

$koneksi    = mysqli_connect($host,$user,$pwd,$db);
if(!$koneksi){
    die("Gagal terkoneksi");
}else{
    echo "Koneksi Berhasil";
}