<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
if ($conn){
    $id = $_POST['id_kategori'];
    $select = "select * from kategori where id_kategori = '".$id."'";
    $sql = $conn->query($select);
    if ($sql->num_rows>0){
        $delete = "delete from kategori where id_kategori = '".$id."'";
        $sql2 = $conn->query($delete);
        if ($sql2==TRUE){
            echo "Berhasil Dihapus";
        }else{
            echo "Gagal Dihapus";
        }
    }else{
        echo "kategori tidak ditemukan";
    }
}