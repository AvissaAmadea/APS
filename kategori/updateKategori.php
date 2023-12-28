<?php
    $conn = mysqli_connect('localhost','root','','aset_ruang');
    if ($conn){
        $id = $_POST['id_kategori'];
        $select = "select nama_kategori from kategori where id_kategori = '".$id."'";
        $query = $conn->query($select);
        if ($query->num_rows>0){
            $namaKategori = $_POST['nama_kategori'];
            $update ="update kategori set nama_kategori='".$namaKategori."' where id_kategori='".$id."'";
            $sql = mysqli_query($conn, $update);
            if ($namaKategori!=""){
                if ($sql){
                    echo json_encode(array("status"=>"success"));
                }else{
                    echo json_encode(array("status"=>"error"));
                }
            }else{
                echo json_encode(array("status"=>"error", "massage"=>"not Found"));
            }
        }else{
            echo "Kategori not found";
        }

    }else{
        echo "cannot connect";
    }