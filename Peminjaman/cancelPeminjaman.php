<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
if ($conn){
    $kdPinjam = $_POST['kodePeminjaman'];
    $query = "select * from peminjaman_aset where kodePeminjaman = '".$kdPinjam."'";
    $check = $conn->query($query);
    $result = array();
    if($check->num_rows>0){
       $status = "select status_peminjaman from peminjaman_aset where kodePeminjaman = '".$kdPinjam."'";
       $checkStatus = $conn->query($status);
       if ($checkStatus=="Menunggu Verifikasi"){
            $update = "update peminjaman_aset set status_peminjaman = 'Dibatalkan' where kodePeminjaman = '".$kdPinjam."'";
            $cancel = $conn->query($update);
            if ($cancel){
                echo "Berhasil dibatalkan";
            }else{
                echo "gagal";
            }
       }elseif ($checkStatus="Dibatalkan"){
           echo "Sudah dibatalkan";
       }elseif($checkStatus="Sudah Diverifikasi"){
           echo "Tidak dapat dibatalkan";
       }elseif ($checkStatus="Selesai"){
           echo "Peminjaman Sudah Selesai";
       }else{
           echo "tidak bisa dibatalkan";
       }
    }else{
        echo "KodePeminjaman salah";
    }
}