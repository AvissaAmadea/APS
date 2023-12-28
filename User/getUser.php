<?php
$conn = mysqli_connect('localhost', 'root','','aset_ruang');

if ($conn){
    $sql = "select user.id_user, user.nama, user.username, user.nip, user.email, user.create_at, user.status, roles.nama_roles, dinas.nama_dinas from user
            inner join roles on user.id_role = roles.id_role
            inner join dinas on user.id_dinas = dinas.id_dinas ";
    $query = $conn->query($sql);

    if ($query->num_rows>0){
        $return_arr['user'] = array();

        while ($row = $query->fetch_array()){
            $formattedDate = date('d-m-Y, h:i:s', strtotime($row['create_at']));
            array_push($return_arr['user'], array(
                'nama'=> $row['nama'],
                'username'=>$row['username'],
                'email' => $row['email'],
                'nip' => $row['nip'],
                'create_at'=>$formattedDate,
                'role' =>$row['nama_roles'],
                'status' => $row['status'],
                'dinas' =>$row['nama_dinas'],
                'id_user'=>$row['id_user']
            ));
        }
        echo json_encode($return_arr);
    }
}else {
    echo "db x";
}
$conn->close();

?>