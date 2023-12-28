<?php

$conn = mysqli_connect('localhost', 'root', '', 'aset_ruang');
$sql = "select id_bidang, nama_bidang from bidang";
if (!$conn->query($sql)) {
    echo "error in connecting to database";
} else {
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $return_arr['bidang'] = array();
        while ($row = $result->fetch_array()) {
            array_push($return_arr['bidang'], array(
                'id_bidang' => $row['id_bidang'],
                'nama_bidang' => $row['nama_bidang']
            ));
        }
        echo json_encode($return_arr);
    }
}$conn->close();
?>