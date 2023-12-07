package com.example.myapplication.Model;

public class DinasModel {
    private int dinasId;
    private String dinasNama, alamat;

    public DinasModel(int id_dinas, String nama_dinas) {
        this.dinasId = id_dinas;
        this.dinasNama = nama_dinas;
        this.alamat = alamat;
    }

    public int getDinasId() {
        return dinasId;
    }

    public String getDinasNama() {
        return dinasNama;
    }
    @Override
    public String toString() {
        return getDinasNama();
    }

    public static DinasModel createDinasHint() {
        return new DinasModel(-1, "Pilih Dinas");
    }

    public void setDinasId(int dinasId) {
        this.dinasId = dinasId;
    }

    public void setDinasNama(String dinasNama) {
        this.dinasNama = dinasNama;
    }

    public String getAlamat() {
        return alamat;
    }

    public void setAlamat(String alamat) {
        this.alamat = alamat;
    }
}


