package com.example.myapplication;

import androidx.annotation.Nullable;
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

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Adapter.dendaAdapter;
import com.example.myapplication.Adapter.userAdapter;
import com.example.myapplication.Admin.ListPengguna;
import com.example.myapplication.Model.dendaModel;
import com.example.myapplication.Model.userModel;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class ListDenda extends AppCompatActivity {

    ProgressBar progressBar;

    private List<dendaModel> dendaModelList;
    dendaAdapter adapter;
    TextView textView;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_denda);
        progressBar = findViewById(R.id.loaddenda);
        textView = findViewById(R.id.textv);

        Intent intent = getIntent();
        int id = intent.getIntExtra("id",0);

        fetchData(id);
        dendaModelList = new ArrayList<>();
        RecyclerView recyclerView2 = findViewById(R.id.bayar);
        recyclerView2.setLayoutManager(new LinearLayoutManager(this));
        adapter = new dendaAdapter(ListDenda.this, dendaModelList);
        recyclerView2.setHasFixedSize(true);
        recyclerView2.setAdapter(adapter);
        recyclerView2.setLayoutManager(new LinearLayoutManager(this));
        recyclerView2.addItemDecoration(new DividerItemDecoration(this, DividerItemDecoration.VERTICAL));
    }

    private void fetchData(int id) {
        progressBar.setVisibility(View.VISIBLE);
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Request.Method.POST,Db.getDenda, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    progressBar.setVisibility(View.GONE);
                    JSONObject jsonResponse = new JSONObject(response);
                    JSONArray array = jsonResponse.getJSONArray("denda");
                    for (int i = 0; i < array.length(); i++) {
                        JSONObject object = array.getJSONObject(i);
                        dendaModelList.add(new dendaModel(
                                object.getString("nama_aset"),
                                object.getString("denda"),
                                object.getString("kodePinjam"),
                                object.getString("keadaan")
                        ));
                    }
                    adapter.notifyDataSetChanged();
                } catch (Exception e) {
                    e.printStackTrace();
                    textView.setVisibility(View.VISIBLE);
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                progressBar.setVisibility(View.GONE);
                textView.setVisibility(View.VISIBLE);
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