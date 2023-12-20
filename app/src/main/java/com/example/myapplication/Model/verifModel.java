package com.example.myapplication.Model;

public class verifModel {
    String nama, aset, tglPinjam, tglKembali, status, kode;

    public verifModel(String nama, String nama_aset, String tgl_pinjam, String tgl_kembali, String status, String kode) {
        this.nama = nama;
        this.aset = nama_aset;
        this.tglPinjam = tgl_pinjam;
        this.tglKembali = tgl_kembali;
        this.status = status;
        this.kode = kode;
    }

    public String getKode() {
        return kode;
    }

    public verifModel setKode(String kode) {
        this.kode = kode;
        return this;
    }

    public String getNama() {
        return nama;
    }

    public verifModel setNama(String nama) {
        this.nama = nama;
        return this;
    }

    public String getAset() {
        return aset;
    }

    public verifModel setAset(String aset) {
        this.aset = aset;
        return this;
    }

    public String getTglPinjam() {
        return tglPinjam;
    }

    public verifModel setTglPinjam(String tglPinjam) {
        this.tglPinjam = tglPinjam;
        return this;
    }

    public String getTglKembali() {
        return tglKembali;
    }

    public verifModel setTglKembali(String tglKembali) {
        this.tglKembali = tglKembali;
        return this;
    }


    public String getStatus() {
        return status;
    }

    public verifModel setStatus(String status) {
        this.status = status;
        return this;
    }
}
