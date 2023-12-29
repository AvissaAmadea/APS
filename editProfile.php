<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
if (isset ($_POST['id'])&&isset($_POST['nama'])&& isset($_POST['email'])&& isset($_POST['username']) &&isset($_POST['nip'])&&isset($_POST['nama_dinas'])){
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $email = $_POST['email'];
    $id = $_POST['id'];
    $username = $_POST['username'];
    $dinas = $_POST['nama_dinas'];

    $checkQuery = "SELECT * FROM user WHERE username = '$username'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0){
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'Username or email already exists.'));
    }else{
        $dinasQuery = "SELECT id_dinas FROM dinas WHERE nama_dinas = '".$dinas."'";
        $dinasResult = mysqli_query($conn, $dinasQuery);
        if ($dinasResult && $dinasRow = mysqli_fetch_assoc($dinasResult)){
            $dinasId = $dinasRow['id_dinas'];

            $insert = "update user set nama='".$nama."', username = '".$username."', email='".$email."', id_dinas = '".$dinasId."', nip = '".$nip."'
          
          where id_user = '".$id."'";
            $insertQuery = $conn->query($insert);
            if ($insertQuery){
                http_response_code(201); // Created
                echo json_encode(array('message' => 'User edited successfully.'));
            }else{
                http_response_code(500); // Internal Server Error
                echo json_encode(array('error' => 'Failed to register user.'));
            }
        }else{
            http_response_code(404); // Not Found
            echo json_encode(array('error' => 'Dinas not found.'));
        }
    }

}else{
    echo "masukkan data";
}