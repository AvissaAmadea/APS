package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.widget.EditText;
import android.widget.TextView;

import com.example.myapplication.Adapter.asetAdminAdapter;
import com.example.myapplication.Admin.FormAset;
import com.example.myapplication.Model.asetAdminModel;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

public class DetailAset extends AppCompatActivity {
    TextView nama, dinas, status, detail, kategori;
    int position;
    FloatingActionButton fabEdit, fabAdd;
    private String id = "";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_aset);
        nama = findViewById(R.id.etNmaAset);
        dinas = findViewById(R.id.etdinas);
        status =findViewById(R.id.etStatus);
        detail = findViewById(R.id.etDetailAset);
        kategori = findViewById(R.id.etKat);

        Intent intent = getIntent();
        position = intent.getExtras().getInt("position");
        id = intent.getStringExtra("id");
        nama.setText(intent.getStringExtra("nama_aset"));
        dinas.setText(intent.getStringExtra("nama_dinas"));
        status.setText(intent.getStringExtra("status"));
        detail.setText(intent.getStringExtra("detail"));
        kategori.setText(intent.getStringExtra("nama_kategori"));


    }
}