<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
if ($conn){
    $id = $_POST['id_user'];
    $softDel = "update user set status ='Inactive' where id_user = '".$id."'";
    $sq = $conn->query($softDel);
    if ($sq){
        $insert = "update user set delete_at = NOW() where id_user = '".$id."'";
        $sql = $conn->query($insert);
        if ($sql){
            echo "Berhasil disimpan";
        }else{
            echo "Gagal insert";
        }
        echo "Berhasil dihapus";
    }else{
        echo "Gagal delete";
    }
}
?>