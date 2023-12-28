<?php
$conn = mysqli_connect('localhost', 'root', '','aset_ruang');

if ($conn){
    $nama = $_POST['nama_dinas'];
    $alamat = $_POST['alamat'];
    $insert = "insert into dinas (nama_dinas, alamat) values ('".$nama."','".$alamat."')";
    $sql = $conn->query($insert);
    if ($sql){
        echo "Berhasil ditambahkan";
    }else{
        echo "gagal";
    }
}