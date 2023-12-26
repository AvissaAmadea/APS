package com.example.myapplication;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.text.Editable;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import java.util.HashMap;
import java.util.Map;

public class PelaporanKerusakanKehilangan extends AppCompatActivity {

    EditText kode, detailKej, detailKer, bukti;
    Button simpan;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_pelaporan_kerusakan_kehilangan);
        kode = findViewById(R.id.kode);
        detailKej = findViewById(R.id.detailKej);
        detailKer = findViewById(R.id.detailKer);
        bukti = findViewById(R.id.upRusak);


        Intent intent = getIntent();
        String iKode = intent.getStringExtra("kodePinjam");
        kode.setText(iKode);

        simpan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String kodeP = kode.getText().toString();
                String keja = detailKej.getText().toString();
                String ker = detailKer.getText().toString();
                simpanData(kodeP, keja, ker);

            }
        });
    }

    private void simpanData(String kodeP, String keja, String ker) {
        RequestQueue queue = Volley.newRequestQueue(this);
        StringRequest request = new StringRequest(Request.Method.POST, Db.pelaporan,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Toast.makeText(PelaporanKerusakanKehilangan.this, response, Toast.LENGTH_SHORT).show();
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(PelaporanKerusakanKehilangan.this, "error", Toast.LENGTH_SHORT).show();
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                HashMap<String, String> map = new HashMap<>();
                map.put("kodePeminjaman", kodeP);
                map.put("detail_kerusakan", ker);
                return map;
            }
        };
    }
}