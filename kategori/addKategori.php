<?php
$conn = mysqli_connect('localhost','root','','aset_ruang_test');

$namaKategori =$_POST['nama_kategori'];

$insert = "insert into kategori (nama_kategori) values ('".$namaKategori."')";
$sql = mysqli_query($conn, $insert);
if (isset($namaKategori)){
    if ($sql){
        echo json_encode(array("status"=>"success"));
    }else{
        json_encode(array("status"=>"error"));
    }
}else{
    echo "All fields required";
}