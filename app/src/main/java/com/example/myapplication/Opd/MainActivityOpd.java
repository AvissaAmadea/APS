package com.example.myapplication.Opd;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import com.example.myapplication.Admin.FormAset;
import com.example.myapplication.FormPeminjaman;
import com.example.myapplication.R;

public class MainActivityOpd extends AppCompatActivity {
    TextView textView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_opd);
        textView = findViewById(R.id.textView);
        textView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(MainActivityOpd.this, FormPeminjaman.class);
                startActivity(intent);
                finish();
            }
        });
    }
}