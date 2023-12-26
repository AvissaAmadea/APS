package com.example.myapplication;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Adapter.RiwayatAdapter;
import com.example.myapplication.Adapter.verifAdapter;
import com.example.myapplication.Model.RiwayatModel;
import com.example.myapplication.Model.verifModel;
import com.example.myapplication.Sekre.ListVerifikasi;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class Riwayat extends AppCompatActivity {
    LoadDialog loadDialog;
    RecyclerView recyclerView;
    ProgressBar progressBar;

    TextView blm;
    private List<RiwayatModel> riwayatModelList;
    RiwayatAdapter adapter;
    ImageView back;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_riwayat);
        recyclerView = findViewById(R.id.list_user_riw);
        progressBar = findViewById(R.id.load_riw);

        Intent intent = getIntent();
        int id = intent.getIntExtra("id",0);

        fetchData(id);
        riwayatModelList = new ArrayList<>();
        RecyclerView recyclerView1 = findViewById(R.id.list_user_riw);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        adapter = new RiwayatAdapter(Riwayat.this, riwayatModelList);
        recyclerView1.setHasFixedSize(true);
        recyclerView1.setAdapter(adapter);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        recyclerView1.addItemDecoration(new DividerItemDecoration(this,DividerItemDecoration.VERTICAL));
    }

    private void fetchData(int id) {
        progressBar.setVisibility(View.VISIBLE);
        RequestQueue queue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.getPinjam,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            progressBar.setVisibility(View.GONE);
                            JSONObject jsonObject = new JSONObject(response);
                            JSONArray array = jsonObject.getJSONArray("peminjaman_aset");
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
                            Log.d("response", "response"+response);
                            adapter.notifyDataSetChanged();
                        }catch (Exception e){
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressBar.setVisibility(View.GONE);
                Toast.makeText(Riwayat.this, "error", Toast.LENGTH_SHORT).show();
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