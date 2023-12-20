package com.example.myapplication.Admin;

import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;

import android.app.AlertDialog;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
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
import com.example.myapplication.FormPeminjaman;
import com.example.myapplication.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;

public class FormPengguna extends AppCompatActivity {

    EditText ETnama, ETusername, ETemail, ETnip;
    Spinner SpinDinas, SpinJabat, SpinBid, SpinRole;
    Button simpan;
    ArrayList<String> jabatanList = new ArrayList<>();
    ArrayList<String> dinasList = new ArrayList<>();
    ArrayList<String> bidangList = new ArrayList<>();
    ArrayAdapter<String> jabatanAdapter;
    ArrayAdapter<String> dinasAdapter;
    ArrayAdapter<String> bidangAdapter;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_form_pengguna);

        ETnama = findViewById(R.id.etNama);
        ETusername = findViewById(R.id.etUsername);
        ETemail = findViewById(R.id.etEmail);
        ETnip = findViewById(R.id.etNip);
        SpinDinas = findViewById(R.id.spinnerDinas);
        simpan = findViewById(R.id.btn_form_pengguna);
        SpinRole = findViewById(R.id.spinnerRole);

        String[] data = {"Pilih Role", "Admin", "Sekretariat", "OPD"};

        // Create an ArrayAdapter using the string array and a default spinner layout
        ArrayAdapter<String> adapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_item, data);

        // Specify the layout to use when the list of choices appears
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

        // Apply the adapter to the spinner
        SpinRole.setAdapter(adapter);

        fetchDinas(SpinDinas);

        simpan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String nama = ETnama.getText().toString();
                String username = ETusername.getText().toString();
                String email = ETemail.getText().toString();
                String nip = ETnip.getText().toString();
                String dinas = SpinDinas.getSelectedItem().toString();
                String bidang = SpinBid.getSelectedItem().toString();
                String jabatan = SpinJabat.getSelectedItem().toString();
                String role = SpinRole.getSelectedItem().toString();
                if (!(nama.isEmpty() || username.isEmpty() || email.isEmpty() || nip.isEmpty())) {
                    simpanDataUser(nama, username, email, nip, dinas, bidang, jabatan, role);
                } else {
                    Toast.makeText(FormPengguna.this, "Masukkan Data dengan Benar", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }



    private void simpanDataUser(String nama, String username, String email, String nip, String dinas, String bidang, String jabatan, String role) {
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.addUser,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Toast.makeText(FormPengguna.this, "Berhasil Menyimpan", Toast.LENGTH_LONG).show();
                        showSuccessDialog();
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(FormPengguna.this, "Error during insert data", Toast.LENGTH_SHORT).show();
                Log.e("FormAsetActivity", "Error during insert data: " + error.toString());
                showFailedDialog();
            }
        }){
            protected HashMap<String, String> getParams(){
                HashMap<String, String> map = new HashMap<>();
                map.put("nama", nama);
                map.put("username", username);
                map.put("email", email);
                map.put("nip", nip);
                map.put("dinas", dinas);
                map.put("jabatan", jabatan);
                map.put("bidang", bidang);
                return map;
            }
        };
        requestQueue.add(stringRequest);
    }

    private void fetchDinas(Spinner spinDinas) {
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
                                dinasAdapter = new ArrayAdapter<>(FormPengguna.this,
                                        android.R.layout.simple_spinner_item, dinasList);
                                dinasAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                                SpinDinas.setAdapter(dinasAdapter);

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
    private void showFailedDialog() {
        ConstraintLayout constraintLayout = findViewById(R.id.failedSave);
        View view = LayoutInflater.from(FormPengguna.this).inflate(R.layout.failed_dialog, constraintLayout);
        Button btn = view.findViewById(R.id.btnG);

        AlertDialog.Builder builder = new AlertDialog.Builder(FormPengguna.this);
        builder.setView(view);
        final AlertDialog dialog = builder.create();
        btn.findViewById(R.id.btnG).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dialog.dismiss();
                Toast.makeText(FormPengguna.this, "DONE", Toast.LENGTH_SHORT).show();
            }
        });
        if (dialog.getWindow() !=null){
            dialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        dialog.show();
    }

    private void showSuccessDialog() {
        ConstraintLayout constraintLayout = findViewById(R.id.successSave);
        View view = LayoutInflater.from(FormPengguna.this).inflate(R.layout.success_dialog, constraintLayout);
        Button button = view.findViewById(R.id.btn);

        AlertDialog.Builder builder = new AlertDialog.Builder(FormPengguna.this);
        builder.setView(view);

        final AlertDialog alertDialog = builder.create();
        button.findViewById(R.id.btn).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                alertDialog.dismiss();
                Toast.makeText(FormPengguna.this, "DONE", Toast.LENGTH_SHORT).show();
            }
        });

        if (alertDialog.getWindow() !=null){
            alertDialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        alertDialog.show();
    }
}