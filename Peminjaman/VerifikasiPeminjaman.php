<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
if ($conn) {
    $tglPinjam = $_POST['tgl_peminjaman'];
    $tglKem = $_POST['tgl_kembali'];
    $kodePinjam = $_POST['kodePeminjaman'];
    $status = $_POST['status_peminjaman'];
    $alasan = $_POST['alasan_penolakan'];

    if ($status=="Terima"){
        $update = "update peminjaman_aset set status_peminjaman = 'Peminjaman Diterima', tgl_pinjam='".$tglPinjam."', tgl_kembali='".$tglKem."' where kodePeminjaman = '".$kodePinjam."'";
        $sql = mysqli_query($conn, $update);
        if ($sql===TRUE){
            $select = "select id_aset from peminjaman_aset where kodePeminjaman = '".$kodePinjam."'";
            $q = $conn->query($select);
            if ($q->num_rows>0){
                $row = $q->fetch_assoc();
                $id = $row['id_aset'];
                $updateAset = "update aset set status_aset = 'Tidak Tersedia' where id_aset = '".$id."'";
            }
            echo "Berhasil Update status";
        }else {
            echo "gagal menyimpan";
        }
    }elseif($status=="Tolak"){
        $updateAlasan = "update peminjaman_aset set status_peminjaman = 'Peminjaman Ditolak', alasan_penolakan = '".$alasan."' where kodePeminjaman = '".$kodePinjam."'";
        $query = $conn->query($updateAlasan);
        if ($query){
            $select = "select id_aset from peminjama_aset where kodePeminjaman = '".$kodePinjam."'";
            $q = $conn->query($select);
            if ($q->num_rows>0){
                $row = $q->fetch_assoc();
                $id = $row['id_aset'];
                $updateAset = "update aset set status_aset = 'Tersedia' where id_aset = 'id_aset'";
            }
            echo "status dan alasan berhasil ditambahkan";
        }else{
            echo "Harap masukkan alasan dengan benar";
        }
    }else{
        echo "Masukkan status dengan benar";
    }
    $conn->close();
}
?>