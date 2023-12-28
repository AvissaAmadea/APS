<?php
$conn = mysqli_connect('localhost', 'root', '', 'aset_ruang');
if ($conn){
    $id = $_POST['id_user'];
    $select = "select user.id_user, user.nama, user.username, user.nip, user.email, user.create_at, user.status, roles.nama_roles, dinas.nama_dinas from user
            inner join roles on user.id_role = roles.id_role
            inner join dinas on user.id_dinas = dinas.id_dinas 
            where id_user='".$id."'";

    $sql= $conn->query($select);
    if ($sql->num_rows>0){
        $return_arr['user'] = array();
        while ($row = $sql->fetch_array()){
            array_push($return_arr['user'], array(
                'nama'=> $row['nama'],
                'username'=>$row['username'],
                'email' => $row['email'],
                'nip' => $row['nip'],
                'create_at'=>$row['create_at'],
                'role' =>$row['nama_roles'],
                'status' => $row['status'],
                'dinas' =>$row['nama_dinas'],
                'id_user'=>$row['id_user']
            ));
        }
        echo json_encode($return_arr);
    }else{
        echo "response->404";
    }
}