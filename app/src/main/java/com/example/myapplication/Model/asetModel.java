package com.example.myapplication.Model;

public class asetModel {

    String namaAset, detail, stats, dinas, kat;
    int id_aset;

    public asetModel(String namaAset, String detail, String stats, String dinas, String kat, int id_aset) {
        this.namaAset = namaAset;
        this.detail = detail;
        this.stats = stats;
        this.dinas = dinas;
        this.kat = kat;
        this.id_aset =id_aset;
    }

    public String getNamaAset() {
        return namaAset;
    }

    public String getDetail() {
        return detail;
    }

    public String getStats() {
        return stats;
    }

    public String getDinas() {
        return dinas;
    }

    public String getKat() {
        return kat;
    }

    public asetModel setNamaAset(String namaAset) {
        this.namaAset = namaAset;
        return this;
    }

    public asetModel setDetail(String detail) {
        this.detail = detail;
        return this;
    }

    public asetModel setStats(String stats) {
        this.stats = stats;
        return this;
    }

    public asetModel setDinas(String dinas) {
        this.dinas = dinas;
        return this;
    }

    public asetModel setKat(String kat) {
        this.kat = kat;
        return this;
    }

    public int getId_aset() {
        return id_aset;
    }

    public asetModel setId_aset(int id_aset) {
        this.id_aset = id_aset;
        return this;
    }
}
