<?php
    $conn = mysqli_connect('localhost','root','','aset_ruang');
    if ($conn){
        $namaUser = $_POST['nama'];
        $tglPinjam = $_POST['tgl_pinjam'];
        $tglKembali = $_POST['tgl_kembali'];
        $nama_aset = $_POST['nama_aset'];
        $tujuan = $_POST['tujuan'];
        $sqlCheckAvailability = "SELECT status_aset FROM aset WHERE nama_aset = '".$nama_aset."'";


        $hasil = $conn->query($sqlCheckAvailability);
        if ($hasil->num_rows>0){
            $row1 = $hasil->fetch_assoc();
            $statusAset = $row1['status_aset'];
            if ($statusAset == "Tersedia"){
                $sql = "SELECT id_user FROM user WHERE nama = '".$namaUser."'";
                $result = $conn->query($sql);
                $getAset = "select id_aset from aset where nama_aset = '".$nama_aset."'";
                $result2 = $conn->query($getAset);

                function generateRandomBorrowCode() {
                    $randomSuffix = rand(1000000, 9999999); // Adjust the range as needed
                    return 'P' . $randomSuffix . 'M';
                }

                if ($result->num_rows>0 && $result2->num_rows>0){
                    $row = $result->fetch_assoc();
                    $row2 = $result2->fetch_assoc();
                    $idUser = $row['id_user'];
                    $idAset = $row2['id_aset'];

                    $borrowCode = generateRandomBorrowCode();


                    $insert = "insert into peminjaman_aset (id_user, id_aset, tgl_pinjam, tgl_kembali, tujuan, kodePeminjaman) values ('".$idUser."','".$idAset."', '".$tglPinjam."','".$tglKembali."','".$tujuan."','".$borrowCode."')";
                    $sqlInsert = $conn->query($insert);
                    if ($sqlInsert === TRUE) {
                        echo " success";
                    } else {
                        echo "Error: " . $conn->error;
                    }
                } else {
                    echo "user or aset can not found";
                }
            }else {
                echo "Maaf untuk saat ini tidak tersedia";
            }
        }
        $conn->close();

    }else{
        die("Connection failed: " . $conn->connect_error);
    }
    ?>