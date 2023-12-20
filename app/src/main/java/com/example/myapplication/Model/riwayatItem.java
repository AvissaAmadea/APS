package com.example.myapplication.Model;

public class riwayatItem {
    String namaAset, tujuan, stsPinjam;
    String tglPinjam, tglKembali;

    public riwayatItem(String namaAset, String tujuan, String stsPinjam, String tglPinjam, String tglKembali) {
        this.namaAset = namaAset;
        this.tujuan = tujuan;
        this.stsPinjam = stsPinjam;
        this.tglPinjam = tglPinjam;
        this.tglKembali = tglKembali;
    }

    public String getNamaAset() {
        return namaAset;
    }

    public riwayatItem setNamaAset(String namaAset) {
        this.namaAset = namaAset;
        return this;
    }

    public String getTujuan() {
        return tujuan;
    }

    public riwayatItem setTujuan(String tujuan) {
        this.tujuan = tujuan;
        return this;
    }

    public String getStsPinjam() {
        return stsPinjam;
    }

    public riwayatItem setStsPinjam(String stsPinjam) {
        this.stsPinjam = stsPinjam;
        return this;
    }

    public String getTglPinjam() {
        return tglPinjam;
    }

    public riwayatItem setTglPinjam(String tglPinjam) {
        this.tglPinjam = tglPinjam;
        return this;
    }

    public String getTglKembali() {
        return tglKembali;
    }

    public riwayatItem setTglKembali(String tglKembali) {
        this.tglKembali = tglKembali;
        return this;
    }
}

