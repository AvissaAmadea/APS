<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
    $id = $_POST['id_user'];
    $select = "SELECT aset.nama_aset, pengembalian_aset.denda, peminjaman_aset.kodePeminjaman, pengembalian_aset.keadaanAset
                FROM aset
                JOIN peminjaman_aset ON aset.id_aset = peminjaman_aset.id_aset
                JOIN pengembalian_aset ON peminjaman_aset.id_pinjam = pengembalian_aset.id_pinjam
                where peminjaman_aset.id_user = '".$id."'";
    $query = $conn->query($select);
    if ($query->num_rows>0){
        $return_array['denda'] = array();
        while ($row=$query->fetch_array()) {
            array_push($return_array['denda'], array(
                'nama_aset' => $row['nama_aset'],
                'denda' => $row['denda'],
                'kodePinjam' => $row['kodePeminjaman'],
                'keadaan'=>$row['keadaanAset']
            ));
        }
        echo json_encode($return_array);
    }

