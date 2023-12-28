<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
if ($conn){
    $sql = "select peminjaman_aset.tujuan, peminjaman_aset.tgl_pinjam, peminjaman_aset.tgl_kembali,
            aset.nama_aset, user.nama, user.id_dinas, peminjaman_aset.create_at, peminjaman_aset.kodePeminjaman, 
            peminjaman_aset.status_peminjaman from peminjaman_aset 
            inner join aset on peminjaman_aset.id_aset = aset.id_aset
            inner join user on peminjaman_aset.id_user = user.id_user
            where peminjaman_aset.status_peminjaman = 'Menunggu Verifikasi' ";
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
               'create_at'=>$row['create_at'],
                'status'=>$row['status_peminjaman'],
                'kode'=>$row['kodePeminjaman']
            ));
        }
        echo json_encode($return_arr);
    }else{
        echo "Belum Ada";
    }
    $conn->close();
}else{
    echo "db cannot connect";
}
