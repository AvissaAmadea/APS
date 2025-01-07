package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

public class DetailDenda extends AppCompatActivity {

    TextView aset, denda, kode, detail;
    Button selesai;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_denda);
        aset = findViewById(R.id.aset);
        denda = findViewById(R.id.denda);
        kode = findViewById(R.id.kdPinjam);
        detail = findViewById(R.id.detail);
        selesai = findViewById(R.id.bayar);
        Intent intent = getIntent();
        aset.setText(intent.getStringExtra("aset"));
        denda.setText(intent.getStringExtra("denda"));
        kode.setText(intent.getStringExtra("kode"));
        detail.setText(intent.getStringExtra("keadaan"));

        selesai.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText(DetailDenda.this, "selesai", Toast.LENGTH_SHORT).show();
            }
        });
    }
}