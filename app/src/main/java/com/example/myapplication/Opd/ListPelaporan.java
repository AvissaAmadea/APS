package com.example.myapplication.Opd;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ProgressBar;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Adapter.LaporanAdapter;
import com.example.myapplication.Db;
import com.example.myapplication.FormPengembalian;
import com.example.myapplication.Model.LaporanModel;
import com.example.myapplication.R;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class ListPelaporan extends AppCompatActivity {

    List<LaporanModel> laporanModelList;
    LaporanAdapter adapter;
    ProgressBar progressBar;
    FloatingActionButton floatingActionButton;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_pelaporan);
        Intent intent = getIntent();
        int id = intent.getIntExtra("id",0);
        floatingActionButton = findViewById(R.id.btn_add_laporan);
        floatingActionButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent1 = new Intent(ListPelaporan.this, FormPengembalian.class);
                startActivity(intent1);
            }
        });

        fetchData(id);
        progressBar = findViewById(R.id.pg);
        laporanModelList = new ArrayList<>();
        RecyclerView recyclerView1 = findViewById(R.id.lapor);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        adapter = new LaporanAdapter(ListPelaporan.this, laporanModelList);
        recyclerView1.setHasFixedSize(true);
        recyclerView1.setAdapter(adapter);
        RecyclerView.ItemDecoration decoration = new DividerItemDecoration(getApplicationContext(), DividerItemDecoration.VERTICAL);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this,LinearLayoutManager.VERTICAL, false));
    }

    private void fetchData(int id) {
//        progressBar.setVisibility(View.VISIBLE);
        RequestQueue queue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.getLapor,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
//                            progressBar.setVisibility(View.GONE);
                            JSONObject jsonResponse = new JSONObject(response);
                            JSONArray array = jsonResponse.getJSONArray("kembali");
                            for (int i = 0; i < array.length(); i++) {
                                JSONObject object = array.getJSONObject(i);
                                laporanModelList.add(new LaporanModel(
                                        object.getString("kodePeminjaman"),
                                        object.getString("nama"),
                                        object.getString("nama_aset"),
                                        object.getString("keadaan"),
                                        object.getString("status"),
                                        object.getInt("id_kembali")
                                ));
                            }
                            adapter.notifyDataSetChanged();
                        } catch (Exception e) {
                            e.printStackTrace();
                            Toast.makeText(ListPelaporan.this, response, Toast.LENGTH_SHORT).show();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(ListPelaporan.this, "error", Toast.LENGTH_SHORT).show();
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                HashMap<String, String> map = new HashMap<>();
                map.put("id_user", String.valueOf(id));
                return map;
            }
        };
        queue.add(stringRequest);

    }

}