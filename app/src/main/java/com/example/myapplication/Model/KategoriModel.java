package com.example.myapplication.Model;

import org.json.JSONException;
import org.json.JSONObject;

public class KategoriModel {
    private int id_kategori;
    private String nama_kategori;

    public KategoriModel(int id_kategori, String nama_kategori) {
        this.id_kategori = id_kategori;
        this.nama_kategori = nama_kategori;
    }

    public int getId_kategori() {
        return id_kategori;
    }

    public String getNama_kategori() {
        return nama_kategori;
    }

    @Override
    public String toString() {
        return getNama_kategori();
    }
    public static KategoriModel createHintModel() {
        return new KategoriModel(-1, "Pilih Kategori");
    }
    public static KategoriModel fromJson(JSONObject json) throws JSONException {
        int id_kategori = json.getInt("id_kategori");
        String nama_kategori1 = json.getString("nama_kategori");
        return new KategoriModel(id_kategori, nama_kategori1);
    }
}
