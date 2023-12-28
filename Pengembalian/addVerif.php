<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
$id = $_POST['id_kembali'];
$status = $_POST['status'];
$denda = $_POST['denda'];
$alasan = $_POST['alasan'];
$keadaan = $_POST['keadaan'];


$select = "select * from pengembalian_aset where id_kembali = '".$id."'";
$sql = $conn->query($select);
if ($sql->num_rows>0) {
    if ($keadaan == "Baik") {
        $update = "update pengembalian_aset set status = 'Selesai',denda='" . $denda . "',alasan_penolakan='" . $alasan . "', keadaanAset = '" . $keadaan . "'";
        $query = $conn->query($update);
        $up = "select id_pinjam from pengembalian_aset where id_kembali = '" . $id . "'";
        $sel = $conn->query($up);
        if ($sel->num_rows > 0) {
            $row = $sel->fetch_assoc();
            $idpe = $row['id_pinjam'];
            $sw = "update peminjaman_aset set status_peminjaman = 'Selesai' where id_pinjam = '" . $idpe . "'";
            $as = $conn->query($sw);
            $selectAset = "select id_aset from peminjaman_aset where id_pinjam = '".$idpe."'";
            $queryAset = $conn->query($selectAset);
            if ($queryAset->num_rows>0){
                $row = $sel->fetch_assoc();
                $idAset = $row['id_aset'];
                $updateAset = "update aset set status_aset = 'Tersedia' where id_aset = '".$idAset."'";
                $updateQ = $conn->query($updateAset);
                if ($updateQ===TRUE){
                    echo "Berhasil";
                }
            }
        }
    } else {
        $update = "update pengembalian_aset set status = 'Menunggu Pembayaran',denda='" . $denda . "',alasan_penolakan='" . $alasan . "', keadaanAset = '" . $keadaan . "'";
        $query = $conn->query($update);
        $up = "select id_pinjam from pengembalian_aset where id_kembali = '" . $id . "'";
        $sel = $conn->query($up);
        if ($sel->num_rows > 0) {
            $row = $sel->fetch_assoc();
            $idpe = $row['id_pinjam'];
            $sw = "update peminjaman_aset set status_peminjaman = 'Menunggu Pembayaran' where id_pinjam = '" . $idpe . "'";
            $as = $conn->query($sw);
            $selectAset1 = "select id_aset from peminjaman_aset where id_pinjam = '".$idpe."'";
            $queryAset1 = $conn->query($selectAset1);
            if ($queryAset1->num_rows>0){
                $row = $sel->fetch_assoc();
                $idAset = $row['id_aset'];
                $updateAset = "update aset set status_aset = 'Sedang diperbaiki' where id_aset = '".$idAset."'";
                $updateQ = $conn->query($updateAset);
                if ($updateQ===TRUE){
                    echo "Berhasil";
                }
            }
        }
    }
}


