package com.example.myapplication.Admin;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Adapter.userAdapter;
import com.example.myapplication.Db;
import com.example.myapplication.Model.userModel;
import com.example.myapplication.R;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class ListPengguna extends AppCompatActivity {

    ProgressBar progressBar;
    RecyclerView recyclerView;

    private List<userModel> userModelList = new ArrayList<>();
    private com.example.myapplication.Adapter.userAdapter userAdapter;
    FloatingActionButton fab;

    ImageView back;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_pengguna);

        back = findViewById(R.id.backToMenu1);
        progressBar = findViewById(R.id.load_pengguna);
        fab = findViewById(R.id.btn_tambah);
        recyclerView = findViewById(R.id.list_pengguna);

        fetchUserData();



        fab.setOnClickListener(view -> startActivity(new Intent(ListPengguna.this, FormPengguna.class)));

        RecyclerView recyclerView = findViewById(R.id.list_pengguna);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        userAdapter = new userAdapter(userModelList);
        recyclerView.setHasFixedSize(true);
        recyclerView.setAdapter(userAdapter);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        recyclerView.addItemDecoration(new DividerItemDecoration(this, DividerItemDecoration.VERTICAL));
    }

            private void fetchUserData() {
                progressBar.setVisibility(View.VISIBLE);
                RequestQueue requestQueue = Volley.newRequestQueue(this);
                StringRequest stringRequest = new StringRequest(Db.getUser, new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            progressBar.setVisibility(View.GONE);
                            JSONObject jsonResponse = new JSONObject(response);
                            JSONArray array = jsonResponse.getJSONArray("user");
                            for (int i = 0; i < array.length(); i++) {
                                JSONObject object = array.getJSONObject(i);
                                userModelList.add(new userModel(
                                        object.getString("nama"),
                                        object.getString("dinas"),
                                        object.getString("nip"),
                                        object.getString("role"),
                                        object.getString("create_at")

                                ));
                            }
                            userAdapter.notifyDataSetChanged();
                        } catch (Exception e) {
                            e.printStackTrace();
                            Toast.makeText(ListPengguna.this, "Error parsing JSON data", Toast.LENGTH_SHORT).show();
                        }
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        progressBar.setVisibility(View.GONE);
                        Toast.makeText(ListPengguna.this, "Error while fetch data", Toast.LENGTH_SHORT).show();
                    }
                });
                requestQueue.add(stringRequest);
            }
        }



