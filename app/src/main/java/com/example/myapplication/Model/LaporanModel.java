package com.example.myapplication.Model;

public class LaporanModel {
    String kode, nama, aset, keadaan, status, detail;
    int id;

    public LaporanModel(String kode, String nama, String aset, String keadaan, String status, int id, String detail) {
        this.kode = kode;
        this.nama = nama;
        this.aset = aset;
        this.keadaan = keadaan;
        this.status = status;
        this.id = id;
        this.detail = detail;
    }

    public String getDetail() {
        return detail;
    }

    public LaporanModel setDetail(String detail) {
        this.detail = detail;
        return this;
    }

    public int getId() {
        return id;
    }

    public LaporanModel setId(int id) {
        this.id = id;
        return this;
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
