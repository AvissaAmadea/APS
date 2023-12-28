<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
if ($conn){
    $kodePeminjaman = $_POST['kodePeminjaman'];
    $detailKer = $_POST['detail_kerusakan'];
    $tglKembali = $_POST['tgl_kembali'];
    $keadaan = $_POST['keadaan'];
    $formattedDate = date('Y-m-d', strtotime('tgl_kembali'));
    $select = "select id_pinjam, id_aset from peminjaman_aset where kodePeminjaman = '".$kodePeminjaman."'";
    $sql = $conn->query($select);
    if ($sql->num_rows>0){
        $row1 = $sql->fetch_assoc();
        $idPinjam = $row1['id_pinjam'];
        $idAset = $row1['id_aset'];
        $insert = "insert into pengembalian_aset (id_pinjam, detail, tgl_kembali, keadaanAset) values ('".$idPinjam."','".$formattedDate."','".$keadaan."')";
        $query = $conn->query($insert);
        if ($query){
            $update = "update aset set status_aset='Sedang Diperbaiki' where id_aset = '".$idAset."'";
            $lala = $conn->query($update);
            echo "Behasil";
        }else{
            echo "gagal memasukkan data";
        }

    }else{
        echo "kodePeminjaman salah";
    }
}