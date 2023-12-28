package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Adapter.RiwayatAdapter;
import com.example.myapplication.Adapter.verifAdapter;
import com.example.myapplication.Model.RiwayatModel;
import com.example.myapplication.Model.verifModel;
import com.example.myapplication.Sekre.ListPengembalian;
import com.example.myapplication.Sekre.ListVerifikasi;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class LaporanPeminjaman extends AppCompatActivity {
    ProgressBar progressBar;
    RecyclerView recyclerView;

    TextView blm, kem;
    private List<RiwayatModel> riwayatModelList;
    RiwayatAdapter adapter;
    ImageView back;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_laporan_peminjaman);
        back = findViewById(R.id.backToMenu1);
        progressBar = findViewById(R.id.pga);
        recyclerView = findViewById(R.id.listpinjam);
        blm = findViewById(R.id.blm);
        kem = findViewById(R.id.laporKem);


        kem.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(LaporanPeminjaman.this, LaporanPengembalian.class);
                startActivity(intent);
                finish();
            }
        });

        fetchData();
        riwayatModelList = new ArrayList<>();
        RecyclerView recyclerView1 = findViewById(R.id.listpinjam);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        adapter = new RiwayatAdapter(LaporanPeminjaman.this, riwayatModelList);
        recyclerView1.setHasFixedSize(true);
        recyclerView1.setAdapter(adapter);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        recyclerView1.addItemDecoration(new DividerItemDecoration(this,DividerItemDecoration.VERTICAL));

    }

    private void fetchData() {
        progressBar.setVisibility(View.VISIBLE);
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Db.LaporanPem,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            progressBar.setVisibility(View.GONE);
                            JSONObject jsonResponse = new JSONObject(response);
                            JSONArray array = jsonResponse.getJSONArray("peminjaman_aset");
                            for (int i = 0; i<array.length();i++){
                                JSONObject object = array.getJSONObject(i);
                                riwayatModelList.add(new RiwayatModel(
                                        object.getString("nama"),
                                        object.getString("nama_aset"),
                                        object.getString("tgl_pinjam"),
                                        object.getString("tgl_kembali"),
                                        object.getString("kode"),
                                        object.getString("status"),
                                        object.getString("tujuan"),
                                        object.getInt("id_pinjam")
                                ));
                            }
                            adapter.notifyDataSetChanged();
                        } catch (JSONException e) {
                            e.printStackTrace();
                            blm.setVisibility(View.VISIBLE);
                            Toast.makeText(LaporanPeminjaman.this, "Belum Ada Pengajuan", Toast.LENGTH_SHORT).show();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressBar.setVisibility(View.GONE);
                progressBar.setVisibility(View.VISIBLE);
                Toast.makeText(LaporanPeminjaman.this, "Belum Ada", Toast.LENGTH_SHORT).show();
            }
        });
        requestQueue.add(stringRequest);
    }

}