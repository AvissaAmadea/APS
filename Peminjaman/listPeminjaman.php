<?php
// Include your database connection file
$conn = mysqli_connect('localhost','root','','aset_ruang');
// Check if user_id is provided
if ($conn) {

    $sql = "select peminjaman_aset.kodePeminjaman, peminjaman_aset.tujuan, peminjaman_aset.tgl_pinjam, peminjaman_aset.tgl_kembali,
       peminjaman_aset.id_pinjam, 
    peminjaman_aset.status_peminjaman,user.nama, aset.nama_aset from peminjaman_aset
    INNER JOIN user ON peminjaman_aset.id_user = user.id_user
        INNER JOIN aset ON peminjaman_aset.id_aset = aset.id_aset";
    $query = $conn->query($sql);
    if ($query->num_rows>0){
        $return_arr['peminjaman_aset'] = array();
        while ($row = $query->fetch_array()){
            array_push($return_arr['peminjaman_aset'], array(
                'nama_aset' => $row['nama_aset'],
                'nama'=>$row['nama'],
                'tujuan' =>$row['tujuan'],
                'tgl_pinjam'=>$row['tgl_pinjam'],
                'tgl_kembali' => $row['tgl_kembali'],
                'status'=>$row['status_peminjaman'],
                'kode'=>$row['kodePeminjaman'],
                'id_pinjam'=>$row['id_pinjam']
            ));
        }
        echo json_encode($return_arr);
    }

}else{
    echo "Silahkan login";
}
?>