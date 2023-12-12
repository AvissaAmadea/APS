package com.example.myapplication.Admin;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Db;
import com.example.myapplication.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class ListPengguna extends AppCompatActivity {

    private List<userModel> userModelList = new ArrayList<>();
    private userAdapter userAdapter;

    ImageView back;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_pengguna);

        back = findViewById(R.id.backToMenu1);

        RecyclerView recyclerView = findViewById(R.id.list_pengguna);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        userAdapter = new userAdapter(userModelList);
        recyclerView.setHasFixedSize(true);
        recyclerView.setAdapter(userAdapter);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        recyclerView.addItemDecoration(new DividerItemDecoration(this, DividerItemDecoration.VERTICAL));

        fetchUserData();

        back.setOnClickListener(view -> {
            startActivity(new Intent(ListPengguna.this, HomeFragmentAdmin.class));
        });


    }

    private void fetchUserData() {
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Db.getUser, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONArray array = new JSONArray(response);
                    for (int i = 0; i < array.length(); i++) {
                        JSONObject object = array.getJSONObject(i);
                        userModelList.add(new userModel(object.getString("nama"),
                                object.getString("asal_dinas"),
                                object.getString("nip"),
                                object.getString("role"),
                                object.getString("status"),
                                object.getString("create_at")));
                    }
                    userAdapter.notifyDataSetChanged();
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(ListPengguna.this, "Error while fetch data", Toast.LENGTH_SHORT).show();
            }
        });
        requestQueue.add(stringRequest);
    }


}