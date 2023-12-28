<?php
$conn = mysqli_connect('localhost', 'root', '','aset_ruang');
$sql = "select * from kategori";
$query = $conn->query($sql);
if ($query->num_rows>0){
    $return_arr['kategori'] = array();
    while ($row = $query->fetch_array()){
        $formattedDate = date('d-m-Y, h:i:s', strtotime($row['create_at']));
        array_push($return_arr['kategori'], array(
            'id_kategori' => $row['id_kategori'],
            'nama_kategori' => $row['nama_kategori'],
            'create_at'=>$formattedDate
        ));
    }
    echo json_encode($return_arr);
}else{
    echo "gak ada wak";
}
$conn->close();
?>