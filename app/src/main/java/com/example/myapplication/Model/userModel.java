package com.example.myapplication.Model;

public class userModel<status> {
    private String nama, nip, dinas, role, create_at, email, status, username;
    int id_user;

    public userModel(String nama, String nip, String dinas, String role, String create_at, String email, String status, String username, int id_user) {
        this.nama = nama;
        this.nip = nip;
        this.dinas = dinas;
        this.role = role;
        this.create_at = create_at;
        this.email = email;
        this.status = status;
        this.username = username;
        this.id_user = id_user;
    }

    public userModel<status> setNama(String nama) {
        this.nama = nama;
        return this;
    }

    public userModel<status> setNip(String nip) {
        this.nip = nip;
        return this;
    }

    public userModel<status> setDinas(String dinas) {
        this.dinas = dinas;
        return this;
    }

    public userModel<status> setRole(String role) {
        this.role = role;
        return this;
    }

    public userModel<status> setCreate_at(String create_at) {
        this.create_at = create_at;
        return this;
    }

    public userModel<status> setEmail(String email) {
        this.email = email;
        return this;
    }

    public userModel<status> setStatus(String status) {
        this.status = status;
        return this;
    }

    public userModel<status> setUsername(String username) {
        this.username = username;
        return this;
    }

    public userModel<status> setId_user(int id_user) {
        this.id_user = id_user;
        return this;
    }

    public String getNama() {
        return nama;
    }

    public String getNip() {
        return nip;
    }

    public String getDinas() {
        return dinas;
    }

    public String getRole() {
        return role;
    }

    public String getCreate_at() {
        return create_at;
    }

    public String getEmail() {
        return email;
    }

    public String getStatus() {
        return status;
    }

    public String getUsername() {
        return username;
    }

    public int getId_user() {
        return id_user;
    }
}
