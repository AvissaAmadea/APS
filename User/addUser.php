<?php
$conn = mysqli_connect('localhost', 'root','','aset_ruang_test');


function getDinasList($conn) {
    $getDinasListQuery = "SELECT id_dinas, nama_dinas FROM dinas";
    $resultDinasList = mysqli_query($conn, $getDinasListQuery);

    // Check for errors in fetching dinas list
    if (!$resultDinasList) {
        return array("status" => "error", "message" => "Error fetching dinas list: " . mysqli_error($conn));
    }

    // Fetch dinas names and store them in an array
    $dinasNames = array();
    while ($rowDinas = mysqli_fetch_assoc($resultDinasList)) {
        $dinasNames[] = $rowDinas['nama_dinas'];
    }

    return array("status" => "success", "dinasList" => $dinasNames);
}

if (isset($_POST['nama_aset'])&& isset($_POST['detail'])&& isset($_POST['status_aset'])&& isset($_POST['nama_kategori'])&&isset($_POST['nama_dinas'])){

    $namaAset = $_POST['nama_aset'];
    $namaKategori = $_POST['nama_kategori'];
    $detail = $_POST['detail'];
    $status = $_POST['status_aset'];
    $dinas = $_POST['nama_dinas'];

    $getKatListQuery = "select id_kategori from kategori where nama_kategori='".$namaKategori."'";
    $result = mysqli_query($conn, $getKatListQuery);
    $getDinas = "select id_dinas from dinas where nama_dinas = '".$dinas."'";
    $result2 = mysqli_query($conn,$getDinas);

    if ($result->num_rows>0 && $result2->num_rows>0){
        $row = $result->fetch_assoc();
        $row2 = $result2->fetch_assoc();
        $KatId = $row['id_kategori'];
        $dinasId = $row2['id_dinas'];
        $insertAsetQuery = "insert into aset (nama_aset, detail, status_aset, id_kategori, id_dinas) values ('".$namaAset."','".$detail."','".$status."','".$KatId."','".$dinasId."')";

        if (!$conn){
            die("connection failed :". mysqli_connect_error());
        }

        if (mysqli_query($conn, $insertAsetQuery)){
            echo json_encode(array("status"=>"success"));
        }else{
            echo json_encode(array("status" => "error", "message" => "Error during user insertion: " . mysqli_error($conn)));
        }
        mysqli_close($conn);
    }else {
        // kategori not found
        echo json_encode(array("status" => "error", "message" => "Invalid kategori name and dinas name"));
    }
}else{
    echo json_encode(array('status'=>'error', 'massage'=>"Insufficient parameters"));
}
?>