<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
if ($conn){
    $kd = $_POST['kodePeminjaman'];
    $select = "select status_peminjaman, id_aset from peminjaman_aset where kodePeminjaman = '".$kd."'";
    $swl = $conn->query($select);
    if ($swl->num_rows>0){
        $row1 = $swl->fetch_assoc();
        $status = $row1['status_peminjaman'];
        $aset = $row1['id_aset'];
        if ($status=="Menunggu Verifikasi"){
            $sql = 'update peminjaman_aset set status_peminjaman = "Batal" where kodePeminjaman = "'.$kd.'"';
            $query = $conn->query($sql);
            if ($query==TRUE){
                $update = "update aset set status_aset = 'Tersedia' where id_aset = '".$aset."'";
                $sa = $conn->query($update);
                if ($sa==TRUE){
                    echo "Berhasil";
                }
                echo "Berhasil Dibatalkan";
            }
        }else{
            echo "Sudah Tidak Dapat dibatalkan";
        }
    }


}