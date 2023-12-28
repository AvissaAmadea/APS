<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
$id = $_POST['id_user'];
$select = "SELECT
        peminjaman_aset.id_pinjam,
        aset.nama_aset,
        user.nama,
        pengembalian_aset.status AS status,
        pengembalian_aset.denda AS denda,
        pengembalian_aset.keadaanAset,
        peminjaman_aset.kodePeminjaman
    FROM
        peminjaman_aset
    JOIN
        aset  ON peminjaman_aset.id_aset = aset.id_aset
    JOIN
        user ON peminjaman_aset.id_user = user.id_user
    LEFT JOIN
        pengembalian_aset ON peminjaman_aset.id_pinjam = pengembalian_aset.id_pinjam
        where peminjaman_aset.id_user ='".$id."'";

$result = $conn->query($select);
if ($result->num_rows>0) {

    $return_array['report'] = array();
    while ($row=$result->fetch_array()){
        array_push($return_array['report'], array(
            'nama_aset' => $row['nama_aset'],
            'nama'=>$row['nama'],
            'status'=>$row['status'],
            'keadaan'=>$row['keadaanAset'],
            'kode'=>$row['kodePeminjaman'],
            'id_pinjam'=>$row['id_pinjam'],
            'denda'=>$row['denda']
        ));
    }
    echo json_encode($return_array);

}