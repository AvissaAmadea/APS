package com.example.myapplication.Admin;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
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
import org.w3c.dom.Text;

import java.text.Normalizer;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class FormPengguna extends AppCompatActivity {

    TextView tvPass;

    EditText ETnama, ETusername, ETemail, ETnip, etPass;
    Spinner SpinDinas,status, SpinRole;
    Button simpan, simpan1;
    ArrayList<String> jabatanList = new ArrayList<>();
    ArrayList<String> dinasList = new ArrayList<>();
    ArrayList<String> bidangList = new ArrayList<>();
    ArrayAdapter<String> jabatanAdapter;
    ArrayAdapter<String> dinasAdapter;
    ArrayAdapter<String> bidangAdapter;
    int id, position;


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
        status = findViewById(R.id.etStatus);
        simpan1 =findViewById(R.id.btn_edit_pengguna);
        tvPass = findViewById(R.id.tvPass);
        etPass = findViewById(R.id.etPasswordUser);


        String[] data = {"Pilih Role", "Admin", "Sekda", "OPD"};

        // Create an ArrayAdapter using the string array and a default spinner layout
        ArrayAdapter<String> adapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_item, data);

        // Specify the layout to use when the list of choices appears
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

        // Apply the adapter to the spinner
        SpinRole.setAdapter(adapter);
        String[] data1 = {"Pilih Status", "Aktif", "Tidak Aktif"};

        // Create an ArrayAdapter using the string array and a default spinner layout
        ArrayAdapter<String> adapterStatus = new ArrayAdapter<>(this, android.R.layout.simple_spinner_item, data1);

        // Specify the layout to use when the list of choices appears
        adapterStatus.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

        // Apply the adapter to the spinner
        status.setAdapter(adapterStatus);

        fetchDinas(SpinDinas);

        Intent intent = getIntent();
        if (intent != null) {
            id = Integer.parseInt(String.valueOf(intent.getIntExtra("id", -1)));
            ETnama.setText(intent.getStringExtra("nama"));
            ETnip.setText(intent.getStringExtra("nip"));
            ETemail.setText(intent.getStringExtra("email"));
            ETusername.setText(intent.getStringExtra("username"));

            if (id >= 0) {
                simpan1.setVisibility(View.VISIBLE);
                simpan1.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        String nama = ETnama.getText().toString();
                        String username = ETusername.getText().toString();
                        String email = ETemail.getText().toString();
                        String nip = ETnip.getText().toString();
                        String dinas = SpinDinas.getSelectedItem().toString();
                        String role = SpinRole.getSelectedItem().toString();
                        String status1 = status.getSelectedItem().toString();

                        if (!(nama.isEmpty() || username.isEmpty() || email.isEmpty() || nip.isEmpty()) || dinas.equals("Pilih Dinas") || role.equals("Pilih Role")) {
                            AlertDialog.Builder builder = new AlertDialog.Builder(FormPengguna.this);
                            builder.setTitle("Simpan Data");
                            builder.setMessage("Yakin Simpan Perubahan Data?");
                            builder.setNegativeButton("Batal", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialogInterface, int i) {
                                    dialogInterface.dismiss();
                                }
                            });
                            builder.setPositiveButton("Yakin", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialogInterface, int i) {
                                    updateDataUser(nama, username, email, nip, dinas, role, status1);
                                }
                            });
                            builder.create().show();

                        } else {
                            Toast.makeText(FormPengguna.this, "Masukkan Data dengan Benar", Toast.LENGTH_SHORT).show();
                        }
                    }
                });
            } else {
                tvPass.setVisibility(View.VISIBLE);
                etPass.setVisibility(View.VISIBLE);
                simpan.setVisibility(View.VISIBLE);
                simpan.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        String nama = ETnama.getText().toString();
                        String username = ETusername.getText().toString();
                        String email = ETemail.getText().toString();
                        String nip = ETnip.getText().toString();
                        String dinas = SpinDinas.getSelectedItem().toString();
                        String role = SpinRole.getSelectedItem().toString();
                        String status1 = status.getSelectedItem().toString();
                        if (!(nama.isEmpty() || username.isEmpty() || email.isEmpty() || nip.isEmpty())) {
                            AlertDialog.Builder builder = new AlertDialog.Builder(FormPengguna.this);
                            builder.setTitle("Simpan Data");
                            builder.setMessage("Yakin Simpan Perubahan Data?");
                            builder.setNegativeButton("Batal", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialogInterface, int i) {
                                    dialogInterface.dismiss();
                                }
                            });
                            builder.setPositiveButton("Yakin", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialogInterface, int i) {
                                    simpanDataUser(nama, username, email, nip, dinas, role, status1);
                                }
                            });
                            builder.create().show();

                        } else {
                            Toast.makeText(FormPengguna.this, "Masukkan Data dengan Benar", Toast.LENGTH_SHORT).show();
                        }
                    }
                });

            }
        }

    }

    private void updateDataUser(String nama, String username, String email, String nip, String dinas, String role, String status1) {
        StringRequest request = new StringRequest(Request.Method.POST, Db.updateUser,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        showSuccessDialog();
                        Toast.makeText(FormPengguna.this, "success", Toast.LENGTH_SHORT).show();
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(FormPengguna.this, "error" +error, Toast.LENGTH_SHORT).show();
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                HashMap<String, String> map = new HashMap<>();
                map.put("id_user", String.valueOf(id));
                map.put("nama", nama);
                map.put("nama_dinas", dinas);
                map.put("email", email);
                map.put("nama_roles", role);
                map.put("nip",nip);
                map.put("username", username);
                map.put("status", status1);
                return map;
            }
        };
        RequestQueue q = Volley.newRequestQueue(this);
        q.add(request);
    }


    private void simpanDataUser(String nama, String username, String email, String nip, String dinas, String role, String status1) {
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
                map.put("nama_dinas", dinas);
                map.put("status", status1);
                map.put("nama_roles", role);
                map.put("id_user", String.valueOf(id));
                return map;
            }
        };
        requestQueue.add(stringRequest);
    }

    private void fetchDinas(Spinner SpinDinas) {
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
                Intent intent = new Intent(FormPengguna.this, ListPengguna.class);
                startActivity(intent);
            }
        });

        if (alertDialog.getWindow() !=null){
            alertDialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        alertDialog.show();
    }
}