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
import com.example.myapplication.Adapter.kategoriAdapter;
import com.example.myapplication.Admin.ListAsetAdmin;
import com.example.myapplication.Admin.ListPengguna;
import com.example.myapplication.Model.kategoriModel;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class kategori extends AppCompatActivity {

    TextView user, aset;

    ProgressBar progressBar;

    private List<kategoriModel> kategoriModelList;
    kategoriAdapter adapter;
    FloatingActionButton floatingActionButton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_kategori);
        progressBar  = findViewById(R.id.pgKat);
        user = findViewById(R.id.dft_user);
        aset = findViewById(R.id.dft_ast);
        floatingActionButton = findViewById(R.id.btnAddKat);
        floatingActionButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(kategori.this, FormKategori.class);
                startActivity(intent);
            }
        });
        user.setOnClickListener(view -> {
            startActivity(new Intent(this, ListPengguna.class));
        });
        aset.setOnClickListener(view -> {
            startActivity(new Intent(this, ListAsetAdmin.class));
        });
        fetchData();
        kategoriModelList = new ArrayList<>();
        RecyclerView recyclerView1 = findViewById(R.id.recl);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        adapter = new kategoriAdapter(kategori.this, kategoriModelList);
        recyclerView1.setHasFixedSize(true);
        recyclerView1.setAdapter(adapter);
        RecyclerView.ItemDecoration decoration = new DividerItemDecoration(getApplicationContext(), DividerItemDecoration.VERTICAL);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this,LinearLayoutManager.VERTICAL, false));

    }

    private void fetchData() {
        progressBar.setVisibility(View.VISIBLE);
        RequestQueue queue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Db.getKat, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    progressBar.setVisibility(View.GONE);
                    JSONObject jsonResponse = new JSONObject(response);
                    JSONArray array = jsonResponse.getJSONArray("kategori");
                    for (int i = 0; i < array.length(); i++) {
                        JSONObject object = array.getJSONObject(i);
                        kategoriModelList.add(new kategoriModel(
                                object.getString("nama_kategori"),
                                object.getInt("id_kategori"),
                                object.getString("create_at")
                        ));
                    }
                    adapter.notifyDataSetChanged();
                } catch (Exception e) {
                    e.printStackTrace();
                    Toast.makeText(kategori.this, "Error", Toast.LENGTH_SHORT).show();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressBar.setVisibility(View.GONE);
                Toast.makeText(kategori.this, "Error", Toast.LENGTH_SHORT).show();
            }
        });
        queue.add(stringRequest);
    }

}