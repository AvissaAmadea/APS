package com.example.myapplication.Model;

public class kategoriModel {
    private  String nama, create_at;
    int id;

    public kategoriModel(String nama, int id, String create_at) {
        this.nama = nama;
        this.id = id;
        this.create_at = create_at;
    }

    public String getNama() {
        return nama;
    }

    public kategoriModel setNama(String nama) {
        this.nama = nama;
        return this;
    }

    public int getId() {
        return id;
    }

    public kategoriModel setId(int id) {
        this.id = id;
        return this;
    }

    public String getCreate_at() {
        return create_at;
    }

    public kategoriModel setCreate_at(String create_at) {
        this.create_at = create_at;
        return this;
    }
}
