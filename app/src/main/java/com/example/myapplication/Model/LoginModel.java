package com.example.myapplication.Model;

public class LoginModel {

    String nama, username, email, nip, asal_dinas;

    public LoginModel(String nama, String username, String email, String nip, String asal_dinas) {
        this.nama = nama;
        this.username = username;
        this.email = email;
        this.nip = nip;
        this.asal_dinas = asal_dinas;
    }

    public String getNama() {
        return nama;
    }

    public String getUsername() {
        return username;
    }

    public String getEmail() {
        return email;
    }

    public String getNip() {
        return nip;
    }

    public String getAsal_dinas() {
        return asal_dinas;
    }
}
