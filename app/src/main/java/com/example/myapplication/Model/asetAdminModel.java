package com.example.myapplication.Model;

public class asetAdminModel {
    String namaAset, create_atAset,statusAset, dinasAsetAdmin, kategoriAsetAdmin, detailAdmin;
    int idAset;

    public asetAdminModel(String namaAset, String statusAset, String dinasAsetAdmin, String kategoriAsetAdmin, int idAset, String detailAdmin) {
        this.namaAset = namaAset;
        this.statusAset = statusAset;
        this.dinasAsetAdmin = dinasAsetAdmin;
        this.kategoriAsetAdmin = kategoriAsetAdmin;
        this.idAset = idAset;
        this.detailAdmin = detailAdmin;
    }

    public String getDetailAdmin() {
        return detailAdmin;
    }

    public asetAdminModel setDetailAdmin(String detailAdmin) {
        this.detailAdmin = detailAdmin;
        return this;
    }

    public int getIdAset() {
        return idAset;
    }

    public asetAdminModel setIdAset(int idAset) {
        this.idAset = idAset;
        return this;
    }

    public String getNamaAset() {
        return namaAset;
    }

    public asetAdminModel setNamaAset(String namaAset) {
        this.namaAset = namaAset;
        return this;
    }

    public String getCreate_atAset() {
        return create_atAset;
    }

    public asetAdminModel setCreate_atAset(String create_atAset) {
        this.create_atAset = create_atAset;
        return this;
    }

    public String getStatusAset() {
        return statusAset;
    }

    public asetAdminModel setStatusAset(String statusAset) {
        this.statusAset = statusAset;
        return this;
    }

    public String getDinasAsetAdmin() {
        return dinasAsetAdmin;
    }

    public asetAdminModel setDinasAsetAdmin(String dinasAsetAdmin) {
        this.dinasAsetAdmin = dinasAsetAdmin;
        return this;
    }

    public String getKategoriAsetAdmin() {
        return kategoriAsetAdmin;
    }

    public asetAdminModel setKategoriAsetAdmin(String kategoriAsetAdmin) {
        this.kategoriAsetAdmin = kategoriAsetAdmin;
        return this;
    }
}
