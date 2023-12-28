package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Adapter.asetAdapter;
import com.example.myapplication.Adapter.asetAdminAdapter;
import com.example.myapplication.Admin.ListAsetAdmin;
import com.example.myapplication.Model.asetAdminModel;
import com.example.myapplication.Model.asetModel;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class ListAset extends AppCompatActivity {
    ProgressBar progressBar;
    RecyclerView recyclerView;
    private List<asetModel> asetModelList;
    asetAdapter AsetAdapter;
    FloatingActionButton floatingActionButton;
    ImageView back;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_aset);
        progressBar = findViewById(R.id.loadAset);
        recyclerView = findViewById(R.id.list_aset_user);
        floatingActionButton = findViewById(R.id.btnAddPinjam);

        fetchData();
        asetModelList = new ArrayList<>();
        RecyclerView recyclerView1 = findViewById(R.id.list_aset_user);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        AsetAdapter = new asetAdapter(ListAset.this, asetModelList);
        recyclerView1.setHasFixedSize(true);
        recyclerView1.setAdapter(AsetAdapter);
        RecyclerView.ItemDecoration decoration = new DividerItemDecoration(getApplicationContext(), DividerItemDecoration.VERTICAL);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this,LinearLayoutManager.VERTICAL, false));
    }

    private void fetchData() {
        progressBar.setVisibility(View.VISIBLE);
        RequestQueue queue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Db.getAset, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    progressBar.setVisibility(View.GONE);
                    JSONObject jsonResponse = new JSONObject(response);
                    JSONArray array = jsonResponse.getJSONArray("aset");
                    for (int i = 0; i < array.length(); i++) {
                        JSONObject object = array.getJSONObject(i);
                        asetModelList.add(new asetModel(
                                object.getString("nama_aset"),
                                object.getString("detail"),
                                object.getString("status_aset"),
                                object.getString("nama_dinas"),
                                object.getString("nama_kategori"),
                                object.getInt("id_aset")
                        ));
                    }
                    AsetAdapter.notifyDataSetChanged();
                } catch (Exception e) {
                    e.printStackTrace();
                    Toast.makeText(ListAset.this, "Error", Toast.LENGTH_SHORT).show();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressBar.setVisibility(View.GONE);
                Toast.makeText(ListAset.this, "Error", Toast.LENGTH_SHORT).show();
            }
        });
        queue.add(stringRequest);
    }
}