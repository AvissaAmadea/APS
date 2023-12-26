package com.example.myapplication;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
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

public class detailPeminjaman extends AppCompatActivity {
    TextView nama, aset, tglP, tglK, tujuan, status, kode;
    Button batal, kembali;

    ImageView back;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_peminjaman);
        nama = findViewById(R.id.namaPeminjam);
        aset = findViewById(R.id.namaAsetDetail);
        tglP = findViewById(R.id.tglP);
        tglK = findViewById(R.id.tglKem);
        tujuan = findViewById(R.id.tujuanPeminjaman);
        status = findViewById(R.id.status);
        kode = findViewById(R.id.kodePeminjaman);
        batal = findViewById(R.id.batal);
        kembali = findViewById(R.id.pengembalian);

        Intent intent = getIntent();
        String inama = intent.getStringExtra("nama");
        String iaset = intent.getStringExtra("nama_aset");
        String itglP = intent.getStringExtra("tglP");
        String itglK = intent.getStringExtra("tglK");
        String itujuan = intent.getStringExtra("tujuan");
        String iKode = intent.getStringExtra("kode");
        String iStatus = intent.getStringExtra("status");

        nama.setText(inama);
        aset.setText(iaset);
        tglP.setText(itglP);
        tglK.setText(itglK);
        tujuan.setText(itujuan);
        kode.setText(iKode);
        status.setText(iStatus);

        if (status.getText().equals("Menunggu Verifikasi")){
            batal.setVisibility(View.VISIBLE);

        }else if (status.getText().equals("Diterima")){
            kembali.setVisibility(View.VISIBLE);
        }

        kembali.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent1 = new Intent(detailPeminjaman.this, FormPengembalian.class);
                intent1.putExtra("kodePeminjaman", iKode);
                startActivity(intent1);
            }
        });

        batal.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                AlertDialog.Builder builder = new AlertDialog.Builder(detailPeminjaman.this);
                builder.setTitle("Pembatalan");
                builder.setMessage("Yakin Membatalkan Pengajuan?");
                builder.setNegativeButton("Batal", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        dialogInterface.dismiss();
                    }
                }); builder.setPositiveButton("Yakin", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        String kodeP = kode.getText().toString();
                        Batal(kodeP);
                    }
                });
                builder.create().show();
            }
        });
    }

    private void Batal(String kodeP) {
        RequestQueue q = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.batal,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Toast.makeText(detailPeminjaman.this, response, Toast.LENGTH_SHORT).show();
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(detailPeminjaman.this, "error", Toast.LENGTH_SHORT).show();
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                HashMap<String, String> map = new HashMap<>();
                map.put("kodePeminjaman", kodeP);
                return map;
            }
        };
        q.add(stringRequest);
    }
}