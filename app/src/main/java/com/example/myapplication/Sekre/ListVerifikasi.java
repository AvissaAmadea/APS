package com.example.myapplication.Sekre;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

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
import com.example.myapplication.Adapter.verifAdapter;
import com.example.myapplication.Db;
import com.example.myapplication.Model.verifModel;
import com.example.myapplication.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class ListVerifikasi extends AppCompatActivity {
    ProgressBar progressBar;
    RecyclerView recyclerView;

    TextView blm;
    private List<verifModel> verifModelList;
    verifAdapter adapter;
    ImageView back;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_verifikasi);
        back = findViewById(R.id.backToMenu1);
        progressBar = findViewById(R.id.pga);
        recyclerView = findViewById(R.id.verifList);
        blm = findViewById(R.id.blm);

        fetchData();
        verifModelList = new ArrayList<>();
        RecyclerView recyclerView1 = findViewById(R.id.verifList);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        adapter = new verifAdapter(ListVerifikasi.this, verifModelList);
        recyclerView1.setHasFixedSize(true);
        recyclerView1.setAdapter(adapter);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        recyclerView1.addItemDecoration(new DividerItemDecoration(this,DividerItemDecoration.VERTICAL));

    }

    private void fetchData() {
        progressBar.setVisibility(View.VISIBLE);
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Db.getVerif,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            progressBar.setVisibility(View.GONE);
                            JSONObject jsonResponse = new JSONObject(response);
                            JSONArray array = jsonResponse.getJSONArray("peminjaman_aset");
                            for (int i = 0; i<array.length();i++){
                                JSONObject object = array.getJSONObject(i);
                                verifModelList.add(new verifModel(
                                        object.getString("nama"),
                                        object.getString("nama_aset"),
                                        object.getString("tgl_pinjam"),
                                        object.getString("tgl_kembali"),
                                        object.getString("status"),
                                        object.getString("kode"),
                                        object.getString("tujuan")
                                ));
                            }
                            adapter.notifyDataSetChanged();
                        } catch (JSONException e) {
                            e.printStackTrace();
                            blm.setVisibility(View.VISIBLE);
                            Toast.makeText(ListVerifikasi.this, "Belum Ada Pengajuan" +response, Toast.LENGTH_SHORT).show();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressBar.setVisibility(View.GONE);
                progressBar.setVisibility(View.VISIBLE);
                Toast.makeText(ListVerifikasi.this, "Belum Ada", Toast.LENGTH_SHORT).show();
            }
        });
        requestQueue.add(stringRequest);
    }


}