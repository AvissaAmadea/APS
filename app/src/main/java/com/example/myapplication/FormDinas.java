package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;

public class FormDinas extends AppCompatActivity {
    EditText nama, alamat;
    Button simpan;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_form_dinas);
        nama = findViewById(R.id.namaDinas);
        alamat = findViewById(R.id.alamatDinas);
        simpan = findViewById(R.id.simpanDinas);

        Intent intent = getIntent();
        if (intent!=null) {
            String inama = intent.getStringExtra("nama");
            String ialamat = intent.getStringExtra("alamat");
            int id = intent.getIntExtra("id",0);
            nama.setText(inama);
            alamat.setText(ialamat);

            if (id >= 0) {
                simpan.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        String namaDinas = nama.getText().toString();
                        String alamatDinas = alamat.getText().toString();
                        editData(id,namaDinas, alamatDinas);
                    }
                });
            }else {
                simpan.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        String namaDinas = nama.getText().toString();
                        String alamatDinas = alamat.getText().toString();
                        simpanData(namaDinas, alamatDinas);
                    }
                });
            }


        }
        
    }

    private void editData(int id, String namaDinas, String alamatDinas) {
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.updateDinas,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        }){

        };
    }

    private void simpanData(String namaDinas, String alamatDinas) {
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.addDinas,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Toast.makeText(FormDinas.this, "response" +response, Toast.LENGTH_SHORT).show();
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(FormDinas.this, "error", Toast.LENGTH_SHORT).show();
            }
        }){

        };

    }
}