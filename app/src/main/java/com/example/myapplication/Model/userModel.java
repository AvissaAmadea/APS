package com.example.myapplication.Model;

public class userModel<status> {
    private String nama, nip, dinas, role, create_at, email, status, username;
    int id_user;

    public userModel(String nama, String nip, String dinas, String role, String create_at) {
        this.nama = nama;
        this.nip = nip;
        this.dinas = dinas;
        this.role = role;
        this.create_at = create_at;

    }



    public String getNama() {
        return nama;
    }

    public userModel setNama(String nama) {
        this.nama = nama;
        return this;
    }

    public String getNip() {
        return nip;
    }

    public userModel setNip(String nip) {
        this.nip = nip;
        return this;
    }

    public String getDinas() {
        return dinas;
    }

    public userModel setDinas(String dinas) {
        this.dinas = dinas;
        return this;
    }

    public String getRole() {
        return role;
    }

    public userModel setRole(String role) {
        this.role = role;
        return this;
    }

    public String getCreate_at() {
        return create_at;
    }

    public userModel setCreate_at(String create_at) {
        this.create_at = create_at;
        return this;
    }

    public String getEmail() {
        return email;
    }

    public userModel setEmail(String email) {
        this.email = email;
        return this;
    }

    public String getStatus() {
        return status;
    }

    public userModel setStatus(String status) {
        this.status = status;
        return this;
    }

    public int getId_user() {
        return id_user;
    }

    public userModel setId_user(int id_user) {
        this.id_user = id_user;
        return this;
    }

    public String getUsername() {
        return username;
    }

    public userModel setUsername(String username) {
        this.username = username;
        return this;
    }
}
