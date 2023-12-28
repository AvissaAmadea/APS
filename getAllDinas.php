<?php
$conn = mysqli_connect('localhost', 'root', '','aset_ruang');
$sql = "select id_dinas,nama_dinas, alamat from dinas";
if (!$conn->query($sql)){
    echo "error in connecting to database";
}else{
    $result = $conn->query($sql);
    if ($result->num_rows>0){
        $return_arr['dinas'] = array();
        while ($row = $result->fetch_array()){
            array_push($return_arr['dinas'], array(
                'id_dinas'=> $row['id_dinas'],
                'nama_dinas'=>$row['nama_dinas'],
                'alamat' => $row['alamat']
            ));
        }
        echo json_encode($return_arr);
    }
}