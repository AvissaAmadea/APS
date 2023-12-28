<?php
$conn = mysqli_connect('localhost', 'root', '','aset_ruang');
if ($conn){
    $nama = $_POST['nama_dinas'];
    $id = $_POST['id_dinas'];
    $alamat =$_POST['alamat'];
    $select = "select * from dinas where id_dinas = '".$id."'";
    $query = $conn->query($select);
    if ($query->num_rows>0){
        $update = "update dinas set nama_dinas = '".$nama."', alamat ='".$alamat."'";
        $q = $conn->query($update);
        if ($q===TRUE){
            echo "Berhasil";
        }else{
            echo "Gagal";
        }
    }else{
        echo "Dinas tidak ditemukan";
    }
}