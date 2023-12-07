package com.example.myapplication.Admin;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RadioGroup;
import android.widget.Spinner;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Db;
import com.example.myapplication.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;

public class FormAset extends AppCompatActivity {

    EditText namaAset, detailAset;
    Spinner kategoriAset, dinasPemilik, status;
    RadioGroup radio;
    ArrayList<String> kategoriList = new ArrayList<>();
    ArrayList<String> dinasList = new ArrayList<>();
    ArrayAdapter<String> kategoriAdapter;
    ArrayAdapter<String> dinasAdapter;
    Button simpan;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_form_aset);
        namaAset = findViewById(R.id.namaAset);
        detailAset = findViewById(R.id.detail);
        kategoriAset = findViewById(R.id.spinnerKategori);
        dinasPemilik = findViewById(R.id.dinasPemilik);
        simpan = findViewById(R.id.simpan);
        status = findViewById(R.id.spinnerStatus);
        fetchDinasList(dinasPemilik);
        fetchKategoriList(kategoriAset);

        // Define your data array with the hint as the first item
        String[] data = {"Pilih Status", "Tersedia", "Tidak Tersedia", "Sedang Diperbaiki"};

        // Create an ArrayAdapter using the string array and a default spinner layout
        ArrayAdapter<String> adapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_item, data);

        // Specify the layout to use when the list of choices appears
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

        // Apply the adapter to the spinner
        status.setAdapter(adapter);

        simpan.setOnClickListener(view -> {
            String nama = namaAset.getText().toString();
            String detail = detailAset.getText().toString();
            String kategori = kategoriAset.getSelectedItem().toString();
            String dinas = dinasPemilik.getSelectedItem().toString();
            String status1 = status.getSelectedItem().toString();
            simpanDataAset(nama, detail, kategori, dinas, status1);
        });


    }

    private void fetchKategoriList(Spinner kategoriAset) {
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.POST, Db.getKat, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            JSONArray jsonArray = response.getJSONArray("kategori");
                            kategoriList.add("Pilih Kategori");
                            for (int i = 0; i < jsonArray.length(); i++) {
                                JSONObject jsonObject = jsonArray.getJSONObject(i);
                                String namaKategori = jsonObject.optString("nama_kategori");
                                kategoriList.add(namaKategori);
                                kategoriAdapter = new ArrayAdapter<>(FormAset.this,
                                        android.R.layout.simple_spinner_item, kategoriList);
                                kategoriAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                                kategoriAset.setAdapter(kategoriAdapter);
                            }

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        });
        requestQueue.add(jsonObjectRequest);
    }

    private void fetchDinasList(Spinner dinasPemilik) {
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.POST, Db.getDinas, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            JSONArray jsonArray = response.getJSONArray("dinas");
                            dinasList.add("Pilih Dinas");
                            for (int i = 0; i < jsonArray.length(); i++) {
                                JSONObject jsonObject = jsonArray.getJSONObject(i);
                                String namaDinas = jsonObject.optString("nama_dinas");
                                dinasList.add(namaDinas);
                                dinasAdapter = new ArrayAdapter<>(FormAset.this,
                                        android.R.layout.simple_spinner_item, dinasList);
                                dinasAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                                dinasPemilik.setAdapter(dinasAdapter);

                            }

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        });
        requestQueue.add(jsonObjectRequest);
    }


    private void simpanDataAset(String nama, String detail, String kategori, String dinas, String status1) {
        if (nama.equals(null)){
            namaAset.setError("Masukkan nama Aset");
            namaAset.requestFocus();
        } else if (detail.equals(null)) {
            detailAset.setError("Masukkan detail Aset");
            detailAset.requestFocus();
        } else if (kategori.equals("Pilih Kategori")) {
            Toast.makeText(FormAset.this,"Isi dengan benar", Toast.LENGTH_LONG).show();
        } else if (dinas.equals("Pilih Dinas")) {
            Toast.makeText(FormAset.this,"Isi dengan benar", Toast.LENGTH_LONG).show();
        } else if (status1.equals("Pilih Status")) {
            Toast.makeText(FormAset.this,"Isi dengan benar", Toast.LENGTH_LONG).show();
        } else {
            RequestQueue requestQueue = Volley.newRequestQueue(this);
            StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.addAset,
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            Toast.makeText(FormAset.this, "Berhasil Menyimpan", Toast.LENGTH_LONG).show();
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(FormAset.this, "Error during insert data", Toast.LENGTH_SHORT).show();
                    Log.e("FormAsetActivity", "Error during insert data: " + error.toString());

                }
            }){
                protected HashMap<String, String> getParams(){
                    HashMap<String, String> map = new HashMap<>();
                    map.put("nama_aset", nama);
                    map.put("detail", detail);
                    map.put("nama_kategori", kategori);
                    map.put("nama_dinas", dinas);
                    map.put("status_aset", status1);
                    return map;
                }
            };
            requestQueue.add(stringRequest);
        }

    }
}