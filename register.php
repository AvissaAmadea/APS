<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
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

if ($conn){
    if (isset($_POST['nama'])&&isset($_POST['email'])&&isset($_POST['password'])&&isset($_POST['username'])&&isset($_POST['nama_dinas'])&&isset($_POST['nip'])){
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $dinas = $_POST['nama_dinas'];
        $nip = $_POST['nip'];

        $salt = bin2hex(random_bytes(16)); // 16 bytes (128 bits)

        // Combine password and salt, then hash them
        $hashedPassword = hash('sha256', $password . $salt);

        // Check if the username or email is already registered
        $checkQuery = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if ($checkResult && mysqli_num_rows($checkResult) > 0){
            http_response_code(400); // Bad Request
            echo json_encode(array('error' => 'Username or email already exists.'));
        }else{
            $dinasQuery = "SELECT id_dinas FROM dinas WHERE nama_dinas = '".$dinas."'";
            $dinasResult = mysqli_query($conn, $dinasQuery);
            if ($dinasResult && $dinasRow = mysqli_fetch_assoc($dinasResult)){
                $dinasId = $dinasRow['id_dinas'];

                $insert = "insert into user (nama, username, nip, email, password, id_dinas,salt) 
                values ('".$nama."','".$username."','".$nip."','".$email."','".$hashedPassword."','".$dinasId."','".$salt."')";
                $insertQuery = $conn->query($insert);
                if ($insertQuery){
                    http_response_code(201); // Created
                    echo json_encode(array('message' => 'User registered successfully.'));
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
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'All fields are required.'));
    }
}

?>
