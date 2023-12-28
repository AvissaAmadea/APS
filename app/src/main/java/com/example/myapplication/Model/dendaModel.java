package com.example.myapplication.Model;

public class dendaModel {
    String aset, denda, kodeP, keadaan;

    public dendaModel(String aset, String denda, String kodeP, String keadaan) {
        this.aset = aset;
        this.denda = denda;
        this.kodeP = kodeP;
        this.keadaan = keadaan;
    }

    public String getKeadaan() {
        return keadaan;
    }

    public dendaModel setKeadaan(String keadaan) {
        this.keadaan = keadaan;
        return this;
    }

    public String getAset() {
        return aset;
    }

    public dendaModel setAset(String aset) {
        this.aset = aset;
        return this;
    }

    public String getDenda() {
        return denda;
    }

    public dendaModel setDenda(String denda) {
        this.denda = denda;
        return this;
    }

    public String getKodeP() {
        return kodeP;
    }

    public dendaModel setKodeP(String kodeP) {
        this.kodeP = kodeP;
        return this;
    }
}
