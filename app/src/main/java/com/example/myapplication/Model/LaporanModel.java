package com.example.myapplication.Model;

public class LaporanModel {
    String kode, nama, aset, keadaan, status;

    public LaporanModel(String kode, String nama, String aset, String keadaan, String status) {
        this.kode = kode;
        this.nama = nama;
        this.aset = aset;
        this.keadaan = keadaan;
        this.status = status;
    }

    public String getKode() {
        return kode;
    }

    public LaporanModel setKode(String kode) {
        this.kode = kode;
        return this;
    }

    public String getNama() {
        return nama;
    }

    public LaporanModel setNama(String nama) {
        this.nama = nama;
        return this;
    }

    public String getAset() {
        return aset;
    }

    public LaporanModel setAset(String aset) {
        this.aset = aset;
        return this;
    }

    public String getKeadaan() {
        return keadaan;
    }

    public LaporanModel setKeadaan(String keadaan) {
        this.keadaan = keadaan;
        return this;
    }

    public String getStatus() {
        return status;
    }

    public LaporanModel setStatus(String status) {
        this.status = status;
        return this;
    }
}
