package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.widget.TextView;

public class DetailPelaporan extends AppCompatActivity {
    TextView nama, aset, denda, keadaan, kode;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_pelaporan);
        nama = findViewById(R.id.nmP);
        aset = findViewById(R.id.nmA);
        denda = findViewById(R.id.denda);
        keadaan = findViewById(R.id.kead);
        kode = findViewById(R.id.kd);

        Intent intent = getIntent();
        String inama = intent.getStringExtra("nama");
        String iaset = intent.getStringExtra("aset");
        String idenda = intent.getStringExtra("denda");
        String ikead = intent.getStringExtra("keadaan");
        String ikode = intent.getStringExtra("kode");

        nama.setText(inama);
        aset.setText(iaset);
        denda.setText("Rp. "+idenda+",00");
        keadaan.setText(ikead);
        kode.setText(ikode);
    }
}