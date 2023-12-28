<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');

if (isset ($_POST['id_aset'])&&isset($_POST['nama_aset'])&& isset($_POST['detail'])&& isset($_POST['status_aset'])&& isset($_POST['nama_kategori'])&&isset($_POST['nama_dinas'])){
    $nama_aset = $_POST['nama_aset'];
    $namaKategori = $_POST['nama_kategori'];
    $detail = $_POST['detail'];
    $status = $_POST['status_aset'];
    $id = $_POST['id_aset'];
    $dinas = $_POST['nama_dinas'];
    $cekData = "select * from aset where nama_aset = '".$nama_aset."'";
    $cek = $conn->query($cekData);
    if ($cek->num_rows>0){
        $getKatListQuery = "select id_kategori from kategori where nama_kategori='".$namaKategori."'";
        $result = mysqli_query($conn, $getKatListQuery);
        $getDinas = "select id_dinas from dinas where nama_dinas = '".$dinas."'";
        $result2 = mysqli_query($conn,$getDinas);
        if ($result->num_rows>0 && $result2->num_rows>0){
            $row = $result->fetch_assoc();
            $row2 = $result2->fetch_assoc();
            $KatId = $row['id_kategori'];
            $dinasId = $row2['id_dinas'];
            $updateData = "update aset set nama_aset = '".$nama_aset."',id_dinas = '".$dinasId."', detail = '".$detail."', 
        status_aset = '".$status."', id_kategori = '".$KatId."' where id_aset = '".$id."'";
            $quer = $conn->query($updateData);
            if ($quer){
                echo "Berhasil disimpan";
            }else {
                echo "Gagal Menyimpan";
            }
        }

    }
}else{
    echo "masukkan data";
}