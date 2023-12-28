<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
if ($conn){
    $kodePeminjaman = $_POST['kodePeminjaman'];
    $tglKembali = $_POST['tgl_kembali'];
    $keadaanAset = $_POST['keadaanAset'];
    $detail = $_POST['detail'];


    $getCode = "select id_pinjam from peminjaman_aset where kodePeminjaman = '".$kodePeminjaman."'";
    $query2 = mysqli_query($conn, $getCode);

    if ($query2==TRUE){
        $row = $query2->fetch_assoc();
        $idPinjam = $row['id_pinjam'];
        $insert = "insert into pengembalian_aset (id_pinjam, tgl_kembali, keadaanAset, detail) values ('".$idPinjam."','".$tglKembali."','".$keadaanAset."', '".$detail."')";
        $sql = mysqli_query($conn, $insert);
        if ($sql==TRUE){
            $updateStatus = "update peminjaman_aset set status_peminjaman='Menunggu Verifikasi Pengembalian' where kodePeminjaman = '".$kodePeminjaman."'";
            $updateQuery = mysqli_query($conn, $updateStatus);

            if ($updateQuery==TRUE){
                echo "Pengembalian berhasil";
            }else{
                echo "gagal saat menyimpan perubahan";
            }
        }else{
            echo "gagal menyimpan data";
        }
    }
    $conn->close();
}else{
    echo "gagal koneksi";
}

?>