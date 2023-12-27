package com.example.myapplication.Model;

public class kembaliModel {
    String kode, nama, aset,keadaan,status;

    public kembaliModel(String kode, String nama, String aset, String keadaan, String status) {
        this.kode = kode;
        this.nama = nama;
        this.aset = aset;
        this.keadaan = keadaan;
        this.status = status;
    }

    public String getKode() {
        return kode;
    }

    public kembaliModel setKode(String kode) {
        this.kode = kode;
        return this;
    }

    public String getNama() {
        return nama;
    }

    public kembaliModel setNama(String nama) {
        this.nama = nama;
        return this;
    }

    public String getAset() {
        return aset;
    }

    public kembaliModel setAset(String aset) {
        this.aset = aset;
        return this;
    }

    public String getKeadaan() {
        return keadaan;
    }

    public kembaliModel setKeadaan(String keadaan) {
        this.keadaan = keadaan;
        return this;
    }

    public String getStatus() {
        return status;
    }

    public kembaliModel setStatus(String status) {
        this.status = status;
        return this;
    }
}
