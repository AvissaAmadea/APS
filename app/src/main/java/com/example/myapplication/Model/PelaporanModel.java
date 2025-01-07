package com.example.myapplication.Model;

public class PelaporanModel {
    String aset, nama, status, keadaan,kode,denda;
    int id_pinjam;

    public PelaporanModel(String aset, String nama, String status, String keadaan, String kode, int id_pinjam, String denda) {
        this.aset = aset;
        this.nama = nama;
        this.status = status;
        this.keadaan = keadaan;
        this.kode = kode;
        this.id_pinjam = id_pinjam;
        this.denda = denda;
    }

    public String getAset() {
        return aset;
    }

    public PelaporanModel setAset(String aset) {
        this.aset = aset;
        return this;
    }

    public String getNama() {
        return nama;
    }

    public PelaporanModel setNama(String nama) {
        this.nama = nama;
        return this;
    }

    public String getStatus() {
        return status;
    }

    public PelaporanModel setStatus(String status) {
        this.status = status;
        return this;
    }

    public String getKeadaan() {
        return keadaan;
    }

    public PelaporanModel setKeadaan(String keadaan) {
        this.keadaan = keadaan;
        return this;
    }

    public String getKode() {
        return kode;
    }

    public PelaporanModel setKode(String kode) {
        this.kode = kode;
        return this;
    }

    public int getId_pinjam() {
        return id_pinjam;
    }

    public PelaporanModel setId_pinjam(int id_pinjam) {
        this.id_pinjam = id_pinjam;
        return this;
    }

    public String getDenda() {
        return denda;
    }

    public PelaporanModel setDenda(String denda) {
        this.denda = denda;
        return this;
    }
}
