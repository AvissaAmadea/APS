<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
if (isset ($_POST['id_user'])&&isset($_POST['nama'])&& isset($_POST['email'])&& isset($_POST['status'])&& isset($_POST['nama_roles']) && isset($_POST['username']) &&isset($_POST['nip'])&&isset($_POST['nama_dinas'])){
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $id = $_POST['id_user'];
    $username = $_POST['username'];
    $dinas = $_POST['nama_dinas'];
    $role = $_POST['nama_roles'];
    $cekData = "select * from user where username = '".$username."'";
    $cek = $conn->query($cekData);
    if ($cek->num_rows>0){
        $getdinasListQuery = "select id_dinas from dinas where nama_dinas='".$dinas."'";
        $result = mysqli_query($conn, $getdinasListQuery);
        $getRoles = "select id_role from roles where nama_roles = '".$role."'";
        $result2 = mysqli_query($conn,$getRoles);
        if ($result->num_rows>0 && $result2->num_rows>0){
            $row = $result->fetch_assoc();
            $row2 = $result2->fetch_assoc();
            $dinasId = $row['id_dinas'];
            $roleId = $row2['id_role'];
            $updateData = "update user set nama = '".$nama."',id_dinas = '".$dinasId."', email = '".$email."', username ='".$username."',
                nip = '".$nip."',status = '".$status."', id_role = '".$roleId."' where id_user = '".$id."'";
            $quer = $conn->query($updateData);
            if ($quer){
                echo "Berhasil disimpan";
            }else {
                echo "Gagal Menyimpan";
            }
        }

    }
}else{
    echo "masukkan data";
}