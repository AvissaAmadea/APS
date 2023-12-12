package com.example.myapplication.Admin;

public class userModel {
    private String nama, nip, dinas, role, create_at, status;

    public userModel(String nama, String nip, String dinas, String role, String create_at, String status) {
        this.nama = nama;
        this.nip = nip;
        this.dinas = dinas;
        this.role = role;
        this.create_at = create_at;
        this.status = status;
    }

    public String getNama() {
        return nama;
    }

    public void setNama(String nama) {
        this.nama = nama;
    }

    public String getNip() {
        return nip;
    }

    public void setNip(String nip) {
        this.nip = nip;
    }

    public String getDinas() {
        return dinas;
    }

    public void setDinas(String dinas) {
        this.dinas = dinas;
    }

    public String getRole() {
        return role;
    }

    public void setRole(String role) {
        this.role = role;
    }

    public String getCreate_at() {
        return create_at;
    }

    public void setCreate_at(String create_at) {
        this.create_at = create_at;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }
}
