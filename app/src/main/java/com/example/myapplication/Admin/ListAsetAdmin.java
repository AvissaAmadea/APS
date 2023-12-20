package com.example.myapplication.Admin;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Adapter;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Adapter.asetAdminAdapter;
import com.example.myapplication.Adapter.userAdapter;
import com.example.myapplication.Db;
import com.example.myapplication.Model.asetAdminModel;
import com.example.myapplication.R;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class ListAsetAdmin extends AppCompatActivity {

    ProgressBar progressBar;
    RecyclerView recyclerView1;
    private List<asetAdminModel> asetAdminModelList = new ArrayList<>();
    asetAdminAdapter asetAdapter;
    FloatingActionButton floatingActionButton;
    ImageView back;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_aset_admin);
        progressBar = findViewById(R.id.load_aset_admin);
        recyclerView1 = findViewById(R.id.list_aset_Admin);
        floatingActionButton = findViewById(R.id.btn_tambah_aset);
        back = findViewById(R.id.backToMenu2);

        fetchDataAset();

        asetAdminModelList = new ArrayList<>();
        RecyclerView recyclerView1 = findViewById(R.id.list_aset_Admin);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        asetAdapter = new asetAdminAdapter(ListAsetAdmin.this, asetAdminModelList);
        recyclerView1.setHasFixedSize(true);
        recyclerView1.setAdapter(asetAdapter);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        recyclerView1.addItemDecoration(new DividerItemDecoration(this, DividerItemDecoration.VERTICAL));

        floatingActionButton.setOnClickListener(view -> {
            startActivity(new Intent(ListAsetAdmin.this, FormAset.class));
        });



    }

    private void fetchDataAset() {
        progressBar.setVisibility(View.VISIBLE);
        RequestQueue queue =Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Db.getAset, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    progressBar.setVisibility(View.GONE);
                    JSONObject jsonResponse = new JSONObject(response);
                    JSONArray array = jsonResponse.getJSONArray("aset");
                    for (int i = 0; i < array.length(); i++) {
                        JSONObject object = array.getJSONObject(i);
                        asetAdminModelList.add(new asetAdminModel(
                                object.getString("nama_aset"),
                                object.getString("status_aset"),
                                object.getString("nama_dinas"),
                                object.getString("nama_kategori"),
                                object.getInt("id_aset"),
                                object.getString("detail")
                        ));
                        Log.d("JSON_DATA", "Nama Aset: " + object.getString("nama_aset") + ", sts: " + object.getString("id_aset"));
                    }
                    asetAdapter.notifyDataSetChanged();
                } catch (Exception e) {
                    e.printStackTrace();
                    Toast.makeText(ListAsetAdmin.this, "Error", Toast.LENGTH_SHORT).show();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressBar.setVisibility(View.GONE);
                Toast.makeText(ListAsetAdmin.this, "Error", Toast.LENGTH_SHORT).show();
            }
        });
        queue.add(stringRequest);
    }


}