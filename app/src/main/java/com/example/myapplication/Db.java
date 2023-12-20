package com.example.myapplication;

public class Db {
    public static String ip = "172.18.2.207";

    public static final String getPinjam = "http://"+ip+"/aps1/Peminjaman/getPeminjaman.php";
    public  static final String updateAset = "http://"+ip+"/aps1/aset/UpdateAset.php";
    public  static final String getAset = "http://"+ip+"/aps1/aset/getAset.php";
    public static final String getUser = "http://"+ip+"/aps1/User/getUser.php";

    public static final String urlLogin = "http://"+ip+"/aps1/login.php";

    public static final String urlRegist = "http://"+ip+"/aps1/register.php";

    public static final String getDinas = "http://"+ip+"/aps1/getDinas.php";

    public static final String getKat = "http://"+ip+"/aps1/kategori/getKategori.php";

    public static final String addAset = "http://"+ip+"/aps1/aset/AddAset.php";
    public static final String addPinjam = "http://"+ip+"/aps1/Peminjaman/addPinjam.php";
    public static final String addKembali = "http://"+ip+"/aps1/Pengembalian/addPengembalian.php";
    public static final String getVerif = "http://"+ip+"/aps1/peminjaman/getVerifikasi.php";
    public static final String getBidang = "http://"+ip+"/aps1/getBidang.php";
    public static final String addUser ="http://"+ip+"/aps1/User/addUser.php";
    public static final String deleteUser ="http://"+ip+"/aps1/User/deleteUser.php";
}
