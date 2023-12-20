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
}
