<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
$query = "select aset.nama_aset, aset.detail, aset.status_aset, 
        kategori.nama_kategori, dinas.nama_dinas from aset 
        inner JOIN kategori on aset.id_kategori = kategori.id_kategori
        inner join dinas on aset.id_dinas = dinas.id_dinas";
$result = mysqli_query($conn, $query);
$response['aset']=array();
while ($row=mysqli_fetch_array($result)){
    array_push($response['aset'],array(
//        "id_aset" => $row[0],
        "nama_aset"=>$row[0],
        "detail" => $row[1],
        "status" => $row[2],
        "nama_kategori"=> $row[3],
        "nama_dinas"=>$row[4]
    ));
}
echo json_encode(array($response));
mysqli_close($conn);
?>