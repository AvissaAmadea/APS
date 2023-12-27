package com.example.myapplication.Sekre;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;

import android.app.AlertDialog;
import android.content.Intent;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Db;
import com.example.myapplication.FormPengembalian;
import com.example.myapplication.R;

import java.util.HashMap;
import java.util.Map;

public class VerifPengembalian extends AppCompatActivity {
    int id;
    TextView nama, aset, keadaan, kode;
    EditText  denda,alasan;
    RadioGroup verif;
    RadioButton radioButton;
    Button simpan;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_verif_pengembalian);
        nama = findViewById(R.id.namaPeminjam);
        aset = findViewById(R.id.nama_aset_pinjam);
        keadaan = findViewById(R.id.Keadaan);
        kode = findViewById(R.id.kod);
        denda =findViewById(R.id.denda);
        alasan = findViewById(R.id.alasan);
        verif = findViewById(R.id.rdg);
        simpan = findViewById(R.id.simpanVerif);

        Intent intent = getIntent();
        String ikode = intent.getStringExtra("kode");
        String inama = intent.getStringExtra("nama");
        String ikeadaan = intent.getStringExtra("keadaan");
        String iaset = intent.getStringExtra("aset");
        int id = intent.getIntExtra("id",0);
        nama.setText(inama);
        kode.setText(ikode);
        keadaan.setText(ikeadaan);
        aset.setText(iaset);

        simpan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                int radioid = verif.getCheckedRadioButtonId();
                radioButton = findViewById(radioid);
                String status = radioButton.getText().toString();
                String alasanT = alasan.getText().toString();
                String keadaanA = keadaan.getText().toString();
                String dendaA = denda.getText().toString();
                if (alasanT.isEmpty()){
                    alasan.setError("Harap diisi");
                }else {
                    addData(status, alasanT, keadaanA, dendaA, id);
                }
            }
        });
    }

    private void addData(String status, String alasanT, String keadaanA, String dendaA, int id) {
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.verifKem,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        showSuccessDialog();
                        Toast.makeText(VerifPengembalian.this, response, Toast.LENGTH_SHORT).show();
                        startActivity(new Intent(VerifPengembalian.this, ListPengembalian.class));
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                showFailedDialog();
                Toast.makeText(VerifPengembalian.this, "error", Toast.LENGTH_SHORT).show();
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                HashMap<String, String> map = new HashMap<>();
                map.put("status", status);
                map.put("alasan", alasanT);
                map.put("denda", dendaA);
                map.put("keadaan", keadaanA);
                map.put("id_kembali", String.valueOf(id));
                return map;
            }
        };
        requestQueue.add(stringRequest);
    }
    private void showFailedDialog() {
        ConstraintLayout constraintLayout = findViewById(R.id.failedSave);
        View view = LayoutInflater.from(VerifPengembalian.this).inflate(R.layout.failed_dialog, constraintLayout);
        Button btn = view.findViewById(R.id.btnG);

        AlertDialog.Builder builder = new AlertDialog.Builder(VerifPengembalian.this);
        builder.setView(view);
        final AlertDialog dialog = builder.create();
        btn.findViewById(R.id.btnG).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dialog.dismiss();
                Toast.makeText(VerifPengembalian.this, "DONE", Toast.LENGTH_SHORT).show();
            }
        });
        if (dialog.getWindow() !=null){
            dialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        dialog.show();
    }

    private void showSuccessDialog() {
        ConstraintLayout constraintLayout = findViewById(R.id.successSave);
        View view = LayoutInflater.from(VerifPengembalian.this).inflate(R.layout.success_dialog, constraintLayout);
        Button button = view.findViewById(R.id.btn);

        AlertDialog.Builder builder = new AlertDialog.Builder(VerifPengembalian.this);
        builder.setView(view);

        final AlertDialog alertDialog = builder.create();
        button.findViewById(R.id.btn).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                alertDialog.dismiss();
                Toast.makeText(VerifPengembalian.this, "DONE", Toast.LENGTH_SHORT).show();
            }
        });

        if (alertDialog.getWindow() !=null){
            alertDialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        alertDialog.show();
    }
}