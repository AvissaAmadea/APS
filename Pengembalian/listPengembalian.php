<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
$select = "SELECT
        peminjaman_aset.id_pinjam,
        aset.nama_aset,
        user.nama,
        pengembalian_aset.status AS status,
        pengembalian_aset.denda AS denda,
        pengembalian_aset.keadaanAset,
        pengembalian_aset.id_kembali,
        peminjaman_aset.kodePeminjaman,
        pengembalian_aset.detail
    FROM
        peminjaman_aset
    JOIN
        aset  ON peminjaman_aset.id_aset = aset.id_aset
    JOIN
        user ON peminjaman_aset.id_user = user.id_user
    LEFT JOIN
        pengembalian_aset ON peminjaman_aset.id_pinjam = pengembalian_aset.id_pinjam
        where pengembalian_aset.id_pinjam=peminjaman_aset.id_pinjam";

$result = $conn->query($select);
if ($result->num_rows>0) {
    // Add each row to the array
    $report['kembali'] = array();
    while ($row=$result->fetch_array()){
        array_push($report['kembali'], array(
            'nama_aset' => $row['nama_aset'],
            'nama'=>$row['nama'],
            'status'=>$row['status'],
            'kode'=>$row['kodePeminjaman'],
            'keadaan'=>$row['keadaanAset'],
            'id_pinjam'=>$row['id_pinjam'],
            'id_kembali'=>$row['id_kembali'],
            'denda'=>$row['denda'],
            'detail'=>$row['detail']
        ));
    }
    echo json_encode($report);

}