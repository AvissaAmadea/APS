package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;

import android.app.AlertDialog;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
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
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import java.util.ArrayList;
import java.util.HashMap;

public class Register extends AppCompatActivity {
    EditText etUsername, etNama, etEmail, etPass, etKonf, etNip;
    Spinner etDinas;
    Button bnt;

    ArrayList<String> dinasList = new ArrayList<>();
    ArrayAdapter<String> dinasAdapter;

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
        etDinas = findViewById(R.id.asal_dinas);
        bnt = findViewById(R.id.btn_regist);

        fetchDinas(etDinas);

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
                    Toast.makeText(Register.this, "Password Tidak Sama", Toast.LENGTH_SHORT).show();
                }else {
                    if (!(username.isEmpty()||nama.isEmpty()||email.isEmpty()||nip.isEmpty())||dinas.equals("Pilih Dinas")){
                        registerUser(username, nama, email, nip, dinas,pass);
                    }
                }
            }
        });
    }

    private void fetchDinas(Spinner etDinas) {
    }

    private void registerUser(String username, String nama, String email, String nip, String dinas, String pass) {
        RequestQueue queue = Volley.newRequestQueue(this);
        StringRequest sq = new StringRequest(Request.Method.POST, Db.urlRegist,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        showSuccessDialog();
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
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
                return map;
            }
        };
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
                Toast.makeText(Register.this, "DONE", Toast.LENGTH_SHORT).show();
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
                Toast.makeText(Register.this, "DONE", Toast.LENGTH_SHORT).show();
            }
        });

        if (alertDialog.getWindow() !=null){
            alertDialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        alertDialog.show();
    }
}