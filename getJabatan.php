<?php

$conn = mysqli_connect('localhost', 'root', '', 'aset_ruang');
$sql = "select id_jabatan, nama_jabatan from jabatan";
if (!$conn->query($sql)) {
    echo "error in connecting to database";
} else {
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $return_arr['jabatan'] = array();
        while ($row = $result->fetch_array()) {
            array_push($return_arr['jabatan'], array(
                'id_jabatan' => $row['id_jabatan'],
                'nama_jabatan' => $row['nama_jabatan']
            ));
        }
        echo json_encode($return_arr);
    }
}