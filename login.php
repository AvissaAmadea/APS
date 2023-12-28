<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
// Check if required parameters are provided
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch user information based on username and password
    $query = "SELECT user.id_user,user.status, user.nama, user.username, user.password,user.nip, user.salt, user.email, dinas.nama_dinas, user.id_role
        FROM user
        INNER JOIN dinas ON user.id_dinas = dinas.id_dinas
        WHERE user.username = '".$username."'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch the user information as an associative array
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            // Combine the provided password with the retrieved salt and hash it
            $hashedPassword = hash('sha256', $password . $user['salt']);

            // Check if the hashed password matches the stored hashed password
            if ($hashedPassword == $user['password']) {
                // Password is correct, user authenticated successfully

                $response = array(
                    'id_user' => $user['id_user'],
                    'nama' => $user['nama'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'nama_dinas' => $user['nama_dinas'],
                   'id_role' => $user['id_role'],
                    'status' =>$user['status'],
                    'nip'=>$user['nip']
                );

                http_response_code(200); // OK
                echo json_encode($response);
            } else {
                // Password is incorrect
                http_response_code(401); // Unauthorized
                echo json_encode(array('error' => 'Invalid username or password.'));
            }
        } else {
            // User not found
            http_response_code(401); // Unauthorized
            echo json_encode(array('error' => 'Invalid username or password.'));
        }
    } else {
        // Query execution failed
        http_response_code(500); // Internal Server Error
        echo json_encode(array('error' => 'Failed to authenticate user.'));
    }
} else {
    // Username or password not provided
    http_response_code(400); // Bad Request
    echo json_encode(array('error' => 'Username or password not provided.'));
}

// Close the database connection
mysqli_close($conn);


?>
