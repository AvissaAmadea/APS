package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;

import android.app.AlertDialog;
import android.content.Intent;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.text.method.HideReturnsTransformationMethod;
import android.text.method.PasswordTransformationMethod;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;

public class Register extends AppCompatActivity {
    EditText etUsername, etNama, etEmail, etPass, etKonf, etNip;
    Spinner etDinas;

    TextView toLogin;
    Button bnt;

    ArrayList<String> dinasList = new ArrayList<>();
    ArrayAdapter<String> dinasAdapter;

    private ProgressBar progressBar;
    boolean passwordVisible;
    LoadDialog loadDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        etUsername =findViewById(R.id.username_regist);
        etNama = findViewById(R.id.nama_regist);
        etEmail = findViewById(R.id.email);
        etPass = findViewById(R.id.password_regist);
        etKonf = findViewById(R.id.konf_pass);
        etNip = findViewById(R.id.nip_regist);
        etDinas = findViewById(R.id.asal_dinas_aset_user);
        bnt = findViewById(R.id.btn_regist);
        toLogin = findViewById(R.id.to_login);
        progressBar = findViewById(R.id.pg1);

        fetchDinasList(etDinas);

        toLogin.setOnClickListener(view -> {
            startActivity(new Intent(Register.this, Login.class));
        });
        etPass.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent motionEvent) {
                final int Right =2;
                if (motionEvent.getAction()==MotionEvent.ACTION_UP){
                    if (motionEvent.getRawX()>=etPass.getRight()-etPass.getCompoundDrawables()[Right].getBounds().width()){
                        int selection = etPass.getSelectionEnd();
                        if (passwordVisible){
                            etPass.setCompoundDrawablesRelativeWithIntrinsicBounds(0, 0, R.drawable.outline_visibility_off_24, 0);
                            etPass.setTransformationMethod(PasswordTransformationMethod.getInstance());
                            passwordVisible=false;
                        }else{
                            etPass.setCompoundDrawablesRelativeWithIntrinsicBounds(0, 0, R.drawable.outline_visibility_24, 0);
                            etPass.setTransformationMethod(HideReturnsTransformationMethod.getInstance());
                            passwordVisible=true;
                        }
                        etPass.setSelection(selection);
                        return true;
                    }
                }
                return false;
            }
        });
        etKonf.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent motionEvent) {
                final int Right =2;
                if (motionEvent.getAction()==MotionEvent.ACTION_UP){
                    if (motionEvent.getRawX()>=etKonf.getRight()-etKonf.getCompoundDrawables()[Right].getBounds().width()){
                        int selection = etKonf.getSelectionEnd();
                        if (passwordVisible){
                            etKonf.setCompoundDrawablesRelativeWithIntrinsicBounds(R.drawable.baseline_password_24, 0, R.drawable.outline_visibility_off_24, 0);
                            etKonf.setTransformationMethod(PasswordTransformationMethod.getInstance());
                            passwordVisible=false;
                        }else{
                            etKonf.setCompoundDrawablesRelativeWithIntrinsicBounds(R.drawable.baseline_password_24, 0, R.drawable.outline_visibility_24, 0);
                            etKonf.setTransformationMethod(HideReturnsTransformationMethod.getInstance());
                            passwordVisible=true;
                        }
                        etKonf.setSelection(selection);
                        return true;
                    }
                }
                return false;
            }
        });
        bnt.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                String username = etUsername.getText().toString();
                String nama = etNama.getText().toString();
                String email = etEmail.getText().toString();
                String pass = etPass.getText().toString();
                String nip = etNip.getText().toString();
                String konf = etKonf.getText().toString();
                String dinas = etDinas.getSelectedItem().toString();
                if (!konf.equals(pass)){

                    etKonf.setError("Password Tidak Sama");
                }else {
                    if (!(username.isEmpty()||nama.isEmpty()||email.isEmpty()||nip.isEmpty())||dinas.equals("Pilih Dinas")){
                        registerUser(username, nama, email, nip, dinas, pass);
                    }else {
                        Toast.makeText(Register.this, "Masukkan data dengan benar", Toast.LENGTH_SHORT).show();
                    }
                }
            }
        });
    }

    private void fetchDinasList(Spinner etDinas) {
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
                                dinasAdapter = new ArrayAdapter<>(Register.this,
                                        android.R.layout.simple_spinner_item, dinasList);
                                dinasAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                                etDinas.setAdapter(dinasAdapter);

                            }

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(Register.this, "Error fetch dinas", Toast.LENGTH_SHORT).show();
            }
        });
        requestQueue.add(jsonObjectRequest);
    }

    private void registerUser(String username, String nama, String email, String nip, String dinas, String pass) {

        RequestQueue queue = Volley.newRequestQueue(this);
        StringRequest sq = new StringRequest(Request.Method.POST, Db.urlRegist,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        showSuccessDialog();
                        Toast.makeText(Register.this, "Berhasil", Toast.LENGTH_SHORT).show();

                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                loadDialog.HideDialog();
                showFailedDialog();
            }
        }){
            protected HashMap<String, String> getParams(){
                HashMap<String, String> map = new HashMap<>();
                map.put("nama", nama);
                map.put("username", username);
                map.put("password", pass);
                map.put("email", email);
                map.put("nip", nip);
                map.put("nama_dinas", dinas);
                return map;
            }
        };
        queue.add(sq);
    }

    private void showFailedDialog() {
        ConstraintLayout constraintLayout = findViewById(R.id.failedSave);
        View view = LayoutInflater.from(Register.this).inflate(R.layout.failed_dialog, constraintLayout);
        Button btn = view.findViewById(R.id.btnG);

        AlertDialog.Builder builder = new AlertDialog.Builder(Register.this);
        builder.setView(view);
        final AlertDialog dialog = builder.create();
        btn.findViewById(R.id.btnG).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dialog.dismiss();
            }
        });
        if (dialog.getWindow() !=null){
            dialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        dialog.show();
    }

    private void showSuccessDialog() {
        ConstraintLayout constraintLayout = findViewById(R.id.successSave);
        View view = LayoutInflater.from(Register.this).inflate(R.layout.success_dialog, constraintLayout);
        Button button = view.findViewById(R.id.btn);

        AlertDialog.Builder builder = new AlertDialog.Builder(Register.this);
        builder.setView(view);

        final AlertDialog alertDialog = builder.create();
        button.findViewById(R.id.btn).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                alertDialog.dismiss();
                startActivity(new Intent(getApplicationContext(), Login.class));
            }
        });

        if (alertDialog.getWindow() !=null){
            alertDialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        alertDialog.show();
    }
}