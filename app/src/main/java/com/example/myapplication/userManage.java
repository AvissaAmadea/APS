package com.example.myapplication;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;

import java.util.HashMap;

public class userManage {
    Context context;
    SharedPreferences sharedPreferences;
    public SharedPreferences.Editor editor;

    public static final String PREF_NAME = "user_login";
    public static final String LOGIN = "is_user_login";
    public static final String NAME = "nama";
    public static final String NIP = "nip";
    public static final String USERNAME = "username";
    public static final String EMAIL = "email";
    public static final String DINAS = "dinas";

    public userManage(Context context) {
        this.context = context;
        sharedPreferences = context.getSharedPreferences(PREF_NAME,Context.MODE_PRIVATE);
        editor = sharedPreferences.edit();
    }
    public boolean isUserLogin(){
        return sharedPreferences.getBoolean(LOGIN,false);
    }
    public void UserSessionManage(String nama, String nip, String username, String email, String dinas){
        editor.putBoolean(LOGIN, true);
        editor.putString(NAME, nama);
        editor.putString(NIP, nip);
        editor.putString(USERNAME, username);
        editor.putString(EMAIL, email);
        editor.putString(DINAS, dinas);
        editor.apply();
    }
    public HashMap<String, String> userDetails(){
        HashMap<String, String> user = new HashMap<>();
        user.put(NAME, sharedPreferences.getString(NAME, null));
        user.put(NIP, sharedPreferences.getString(NIP, null));
        user.put(EMAIL, sharedPreferences.getString(EMAIL, null));
        user.put(DINAS, sharedPreferences.getString(DINAS, null));
        user.put(USERNAME, sharedPreferences.getString(USERNAME, null));
        return user;
    }
    public void checkLogin(){
        if (!this.isUserLogin()){
            Intent intent = new Intent(context, MainActivity.class);
            context.startActivity(intent);
        }
    }
    public void logOut(){
        editor.clear();
        editor.commit();
        Intent intent = new Intent(context, Login.class);
        context.startActivity(intent);
    }
}
