<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
$query = "select aset.nama_aset, aset.detail, aset.status_aset, aset.create_at, aset.id_aset,
        kategori.nama_kategori, dinas.nama_dinas from aset 
        inner JOIN kategori on aset.id_kategori = kategori.id_kategori
        inner join dinas on aset.id_dinas = dinas.id_dinas";
$result = mysqli_query($conn, $query);
if ($result->num_rows>0){
    $return_arr['aset'] = array();
    while ($row=$result->fetch_array()){
        $formattedDate = date('d-m-Y', strtotime($row['create_at']));
        array_push($return_arr['aset'],array(
            "nama_aset"=>$row["nama_aset"],
            "detail" => $row["detail"],
            "status_aset" => $row['status_aset'],
            "nama_kategori"=> $row["nama_kategori"],
            "nama_dinas"=>$row["nama_dinas"],
            "create_at"=>$formattedDate,
            "id_aset"=>$row['id_aset']
        ));
        }
        echo json_encode($return_arr);
}else{
    echo 'db x';
}
$conn->close();
?>
