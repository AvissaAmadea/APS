<?php

$hostName = 'localhost';
$UID = 'root';
$password = '';
$dbName = 'aset_ruang_test';

$conn = mysqli_connect($hostName, $UID, $password, $dbName);
if ($conn){
    echo json_encode(array("status" => "success"));
}else{
    echo "Koneksi Gagal";
}
?>