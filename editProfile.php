<?php
$conn = mysqli_connect('localhost','root','','aset_ruang');
if (isset ($_POST['id_user'])&&isset($_POST['nama'])&& isset($_POST['email'])&& isset($_POST['username']) &&isset($_POST['nip'])&&isset($_POST['nama_dinas'])){
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $email = $_POST['email'];
    $id = $_POST['id_user'];
    $username = $_POST['username'];
    $dinas = $_POST['nama_dinas'];

    $cekData = "select * from user where username = '".$username."'";
    $cek = $conn->query($cekData);
    if ($cek->num_rows>0){
        $getdinasListQuery = "select id_dinas from dinas where nama_dinas='".$dinas."'";
        $result = mysqli_query($conn, $getdinasListQuery);


        if ($result->num_rows>0){
            $row = $result->fetch_assoc();
            $dinasId = $row['id_dinas'];

            $updateData = "update user set nama = '".$nama."',id_dinas = '".$dinasId."', email = '".$email."', username ='".$username."',
                nip = '".$nip."' where id_user = '".$id."'";
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