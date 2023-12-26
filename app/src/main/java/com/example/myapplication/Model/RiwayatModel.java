package com.example.myapplication.Model;

public class RiwayatModel {
    String nama, aset, tglPinjam, tglKembali, kode, status, tujuan;
    int id_pinjam;

    public RiwayatModel(String nama, String aset, String tglPinjam, String tglKembali, String kode, String status,String tujuan,
                        int id_pinjam) {
        this.nama = nama;
        this.aset = aset;
        this.tglPinjam = tglPinjam;
        this.tglKembali = tglKembali;
        this.kode = kode;
        this.status = status;
        this.tujuan=tujuan;
        this.id_pinjam = id_pinjam;
    }

    public String getTujuan() {
        return tujuan;
    }

    public RiwayatModel setTujuan(String tujuan) {
        this.tujuan = tujuan;
        return this;
    }

    public String getNama() {
        return nama;
    }

    public RiwayatModel setNama(String nama) {
        this.nama = nama;
        return this;
    }

    public String getAset() {
        return aset;
    }

    public RiwayatModel setAset(String aset) {
        this.aset = aset;
        return this;
    }

    public String getTglPinjam() {
        return tglPinjam;
    }

    public RiwayatModel setTglPinjam(String tglPinjam) {
        this.tglPinjam = tglPinjam;
        return this;
    }

    public String getTglKembali() {
        return tglKembali;
    }

    public RiwayatModel setTglKembali(String tglKembali) {
        this.tglKembali = tglKembali;
        return this;
    }

    public String getKode() {
        return kode;
    }

    public RiwayatModel setKode(String kode) {
        this.kode = kode;
        return this;
    }

    public String getStatus() {
        return status;
    }

    public RiwayatModel setStatus(String status) {
        this.status = status;
        return this;
    }

    public int getId_pinjam() {
        return id_pinjam;
    }

    public RiwayatModel setId_pinjam(int id_pinjam) {
        this.id_pinjam = id_pinjam;
        return this;
    }
}
