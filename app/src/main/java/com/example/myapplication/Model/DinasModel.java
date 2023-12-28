package com.example.myapplication.Model;

public class DinasModel {
    String nama, alamat;
    int id;

    public DinasModel(String nama, String alamat, int id) {
        this.nama = nama;
        this.alamat = alamat;
        this.id = id;
    }

    public int getId() {
        return id;
    }

    public DinasModel setId(int id) {
        this.id = id;
        return this;
    }

    public String getNama() {
        return nama;
    }

    public DinasModel setNama(String nama) {
        this.nama = nama;
        return this;
    }

    public String getAlamat() {
        return alamat;
    }

    public DinasModel setAlamat(String alamat) {
        this.alamat = alamat;
        return this;
    }
}
