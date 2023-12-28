package com.example.myapplication.Sekre;

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
import com.example.myapplication.Db;
import com.example.myapplication.Model.LaporanModel;
import com.example.myapplication.Model.verifModel;
import com.example.myapplication.Opd.ListPelaporan;
import com.example.myapplication.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class ListPengembalian extends AppCompatActivity {
    List<LaporanModel> laporanModelList;
    LaporanAdapter adapter;
    ProgressBar progressBar;
    TextView textView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_pengembalian);
        progressBar = findViewById(R.id.pgL);
        textView = findViewById(R.id.verifPinjam);

        textView.setOnClickListener(view -> {
            startActivity(new Intent(ListPengembalian.this, ListVerifikasi.class));
            finish();
        });

        fetchData();
        laporanModelList = new ArrayList<>();
        RecyclerView recyclerView1 = findViewById(R.id.rcl);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        adapter = new LaporanAdapter(ListPengembalian.this, laporanModelList);
        recyclerView1.setHasFixedSize(true);
        recyclerView1.setAdapter(adapter);
        RecyclerView.ItemDecoration decoration = new DividerItemDecoration(getApplicationContext(), DividerItemDecoration.VERTICAL);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this,LinearLayoutManager.VERTICAL, false));
    }

    private void fetchData() {
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Db.getPengembalian,
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
                            Toast.makeText(ListPengembalian.this, "Belum Ada Pengajuan" +response, Toast.LENGTH_SHORT).show();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressBar.setVisibility(View.GONE);
                progressBar.setVisibility(View.VISIBLE);
                Toast.makeText(ListPengembalian.this, "error", Toast.LENGTH_SHORT).show();
            }
        });
        requestQueue.add(stringRequest);
    }
}