package com.example.myapplication;

public class Db {
    public static String ip = "192.168.1.7";

    public static final String batal = "http://"+ip+"/aps1/Peminjaman/pembatalan.php";
    public static final String pelaporan = "http://"+ip+"/aps1/Pengembalian/pelaporan.php";

    public static final String updateUser = "http://"+ip+"/aps1/User/updateUser.php";
    public static final String delKat = "http://"+ip+"/aps1/kategori/deleteKat.php";
    public static final String getPinjam = "http://"+ip+"/aps1/Peminjaman/getPeminjaman.php";
    public  static final String updateAset = "http://"+ip+"/aps1/aset/UpdateAset.php";
    public  static final String getAset = "http://"+ip+"/aps1/aset/getAset.php";
    public static final String getUser = "http://"+ip+"/aps1/User/getUser.php";
    public static final String updateKat = "http://"+ip+"/aps1/kategori/updateKategori.php";
    public static final String addKat = "http://"+ip+"/aps1/kategori/addKategori.php";
    public static final String getLapor = "http://"+ip+"/aps1/Pengembalian/getPelaporan.php";
    public static final String urlLogin = "http://"+ip+"/aps1/login.php";

    public static final String urlRegist = "http://"+ip+"/aps1/register.php";

    public static final String getDinas = "http://"+ip+"/aps1/getDinas.php";

    public static final String getKat = "http://"+ip+"/aps1/kategori/getKategori.php";
    public static final String delAset = "http://"+ip+"/aps1/aset/DeleteAset.php";
    public static final String addAset = "http://"+ip+"/aps1/aset/AddAset.php";
    public static final String addPinjam = "http://"+ip+"/aps1/Peminjaman/addPinjamUser.php";
    public static final String addKembali = "http://"+ip+"/aps1/Pengembalian/addPengembalian.php";
    public static final String getVerif = "http://"+ip+"/aps1/peminjaman/getVerifikasi.php";
    public static final String addUser ="http://"+ip+"/aps1/User/addUser.php";
    public static final String deleteUser ="http://"+ip+"/aps1/User/deleteUser.php";
    public static final String verifPinjam = "http://"+ip+"/aps1/Peminjaman/VerifikasiPeminjaman.php";
    public static final String verifKem = "http://"+ip+"/aps1/Pengembalian/addVerif.php";
    public static final String getPengembalian = "http://"+ip+"/aps1/Pengembalian/verifPengembalian.php";
    public static final String editProfil = "http://"+ip+"/aps1/editProfile.php";
    public static final String LaporanPem = "http://"+ip+"/aps1/Peminjaman/listPeminjaman.php";
    public static final String LaporanPeng = "http://"+ip+"/aps1/Pengembalian/listPengembalian.php";
}
