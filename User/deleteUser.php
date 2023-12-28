<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');

if ($conn){
    $id = $_POST['id_user'];
    $getAset = "Select * from user where id_user = '".$id."'";

    if ($id!=""){
        $result = mysqli_query($conn, $getAset);
        $rows = mysqli_num_rows($result);
        $response = array();

        if ($rows>0){
            $delete = "delete from user where id_user = '".$id."'";
            $query = mysqli_query($conn, $delete);
            if ($query){
                array_push($response, array(
                    'status'=>'success'
                ));
            }else{
                array_push($response, array(
                    'status'=>'failed'
                ));
            }
        }else{
            array_push($response, array(
                'status'=>'failed'));
        }
    }else{
        echo "wrong id";
    }

}else{
    echo "connection failed";
}
echo json_encode(array("server_response" => $response));
mysqli_close($conn);


?>