package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Adapter.LaporanAdapter;
import com.example.myapplication.Model.LaporanModel;


import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class LaporanPengembalian extends AppCompatActivity {

    List<LaporanModel> laporanModelList;
    LaporanAdapter adapter;
    ProgressBar progressBar;

    TextView pinjam;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_laporan_pengembalian);
        progressBar = findViewById(R.id.pgL);
        pinjam = findViewById(R.id.laporPinjam);

        pinjam.setOnClickListener(view -> {
            startActivity(new Intent(LaporanPengembalian.this, LaporanPeminjaman.class));
            finish();
        });

        fetchData();
        laporanModelList = new ArrayList<>();
        RecyclerView recyclerView1 = findViewById(R.id.listpengem);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        adapter = new LaporanAdapter(LaporanPengembalian.this, laporanModelList);
        recyclerView1.setHasFixedSize(true);
        recyclerView1.setAdapter(adapter);
        RecyclerView.ItemDecoration decoration = new DividerItemDecoration(getApplicationContext(), DividerItemDecoration.VERTICAL);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this,LinearLayoutManager.VERTICAL, false));
    }

    private void fetchData() {
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Db.LaporanPeng,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            progressBar.setVisibility(View.GONE);
                            JSONObject jsonResponse = new JSONObject(response);
                            JSONArray array = jsonResponse.getJSONArray("kembali");
                            for (int i = 0; i < array.length(); i++) {
                                JSONObject object = array.getJSONObject(i);
                                laporanModelList.add(new LaporanModel(
                                        object.getString("kode"),
                                        object.getString("nama"),
                                        object.getString("nama_aset"),
                                        object.getString("keadaan"),
                                        object.getString("status"),
                                        object.getInt("id_kembali"),
                                        object.getString("detail")
                                ));
                            }
                            adapter.notifyDataSetChanged();
                        } catch (JSONException e) {
                            e.printStackTrace();
                            Toast.makeText(LaporanPengembalian.this, "Belum Ada Pengajuan" +response, Toast.LENGTH_SHORT).show();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressBar.setVisibility(View.GONE);
                progressBar.setVisibility(View.VISIBLE);
                Toast.makeText(LaporanPengembalian.this, "error", Toast.LENGTH_SHORT).show();
            }
        });
        requestQueue.add(stringRequest);
    }

}