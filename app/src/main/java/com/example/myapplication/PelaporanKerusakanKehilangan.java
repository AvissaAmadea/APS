package com.example.myapplication;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.text.Editable;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
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
import com.example.myapplication.Adapter.kembaliAdapter;
import com.example.myapplication.Model.LaporanModel;
import com.example.myapplication.Model.kembaliModel;
import com.example.myapplication.Sekre.ListPengembalian;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.function.LongFunction;

public class PelaporanKerusakanKehilangan extends AppCompatActivity {

    List<kembaliModel> kembaliModelList;
    kembaliAdapter adapter;
    ProgressBar progressBar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_pelaporan_kerusakan_kehilangan);
        progressBar = findViewById(R.id.pb);
        Intent intent = getIntent();
        int id = intent.getIntExtra("id",0);
        fetchData(id);
        kembaliModelList = new ArrayList<>();
        RecyclerView recyclerView1 = findViewById(R.id.recycle);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        adapter = new kembaliAdapter( PelaporanKerusakanKehilangan.this,kembaliModelList );
        recyclerView1.setHasFixedSize(true);
        recyclerView1.setAdapter(adapter);
        RecyclerView.ItemDecoration decoration = new DividerItemDecoration(getApplicationContext(), DividerItemDecoration.VERTICAL);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this,LinearLayoutManager.VERTICAL, false));
    }

    private void fetchData(int id) {
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.getLapor,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            progressBar.setVisibility(View.GONE);
                            JSONObject jsonResponse = new JSONObject(response);
                            JSONArray array = jsonResponse.getJSONArray("kembali");
                            for (int i = 0; i < array.length(); i++) {
                                JSONObject object = array.getJSONObject(i);
                                kembaliModelList.add(new kembaliModel(
                                        object.getString("kode"),
                                        object.getString("nama"),
                                        object.getString("nama_aset"),
                                        object.getString("keadaan"),
                                        object.getString("status")
                                ));
                            }
                            adapter.notifyDataSetChanged();
                        } catch (Exception e) {
                            e.printStackTrace();
                            Toast.makeText(PelaporanKerusakanKehilangan.this, response, Toast.LENGTH_SHORT).show();
                            Log.d("response", "response"+response);
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressBar.setVisibility(View.GONE);
                progressBar.setVisibility(View.VISIBLE);
                Toast.makeText(PelaporanKerusakanKehilangan.this, "error", Toast.LENGTH_SHORT).show();
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
        requestQueue.add(stringRequest);
    }

}


