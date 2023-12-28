package com.example.myapplication.Sekre;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;

import android.app.AlertDialog;
import android.app.DatePickerDialog;
import android.content.Intent;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.DatePicker;
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
import com.example.myapplication.FormPeminjaman;
import com.example.myapplication.LoadDialog;
import com.example.myapplication.R;

import java.util.Calendar;
import java.util.HashMap;
import java.util.Map;

public class FormVerif extends AppCompatActivity {
    int id;
    private int tahun,bulan,tanggal;
    private int tahun2,bulan2,tanggal2;
    TextView nama, aset, tuju, kode;
    EditText tglP, tglK, alasan;
    RadioGroup verif;
    RadioButton radioButton;
    Button simpan;
    LoadDialog loadDialog;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_form_verif);
        nama = findViewById(R.id.namaPeminjam);
        aset = findViewById(R.id.nama_aset_pinjam);
        tuju = findViewById(R.id.Tujuan);
        tglP = findViewById(R.id.tglPinjam);
        tglK = findViewById(R.id.tglKembali);
        alasan = findViewById(R.id.alasan);
        verif = findViewById(R.id.rdg);
        simpan = findViewById(R.id.simpanVerif);
        kode = findViewById(R.id.kod);

        simpan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                int radioid = verif.getCheckedRadioButtonId();
                radioButton = findViewById(radioid);
                String status = radioButton.getText().toString();
                String kodePem = kode.getText().toString();
                String alasanT = alasan.getText().toString();
                String tangglP = tglP.getText().toString();
                String tanggalK = tglK.getText().toString();
                if (alasanT.isEmpty()){
                    alasan.setError("Harap diisi");
                }else {
                    verifData(status, kodePem, alasanT, tangglP, tanggalK);
                }
            }
        });


        Intent intent2 = getIntent();
        if (intent2 != null) {
            id = Integer.parseInt(String.valueOf(intent2.getIntExtra("id", -1)));
            nama.setText(intent2.getStringExtra("nama"));
            aset.setText(intent2.getStringExtra("aset"));
            tuju.setText(intent2.getStringExtra("tujuan"));
            tglK.setText(intent2.getStringExtra("tglKembali"));
            tglP.setText(intent2.getStringExtra("tglPinjam"));
            kode.setText(intent2.getStringExtra("kode"));

            tglK.setOnClickListener(view -> {
                Calendar calendar = Calendar.getInstance();
                tahun = calendar.get(Calendar.YEAR);
                bulan = calendar.get(Calendar.MONTH);
                tanggal = calendar.get(Calendar.DAY_OF_MONTH);
                calendar.add(Calendar.DAY_OF_MONTH,3);
                DatePickerDialog dialog;
                dialog = new DatePickerDialog(FormVerif.this, new DatePickerDialog.OnDateSetListener() {
                    @Override
                    public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                        tahun = year;
                        bulan = month;
                        tanggal = dayOfMonth;


                        tglP.setText(tahun + "/" + (bulan+1) + "/" + tanggal);
                    }
                },tahun,bulan,tanggal);
                dialog.getDatePicker().setMinDate(calendar.getTimeInMillis()-1000);
                dialog.show();
            });
            tglP.setOnClickListener(view -> {
                Calendar calendar = Calendar.getInstance();
                tahun2 = calendar.get(Calendar.YEAR);
                bulan2 = calendar.get(Calendar.MONTH);
                tanggal2 = calendar.get(Calendar.DAY_OF_MONTH);
                calendar.add(Calendar.DAY_OF_MONTH,3);
                DatePickerDialog dialog;
                dialog = new DatePickerDialog(FormVerif.this, new DatePickerDialog.OnDateSetListener() {
                    @Override
                    public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                        tahun2 = year;
                        bulan2 = month;
                        tanggal2 = dayOfMonth;
                        String tgl1 = (tahun2 + "/" + (bulan2+1) + "/" + tanggal2);
                        tglK.setText(tgl1);

                    }
                },tahun2,bulan2,tanggal2);
                dialog.getDatePicker().setMinDate(calendar.getTimeInMillis()-1000);
                dialog.show();

            });
        }

    }

    private void verifData(String status, String kodePem, String alasanT, String tangglP, String tanggalK) {
        RequestQueue q = Volley.newRequestQueue(this);
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.verifPinjam,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        showSuccessDialog();
                        Toast.makeText(FormVerif.this, "response" +response, Toast.LENGTH_SHORT).show();
                        Log.d("response", "response" +response);
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                showFailedDialog();
                Toast.makeText(FormVerif.this, "error" +error, Toast.LENGTH_SHORT).show();
                Log.d("response", "response" +error);
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                HashMap<String, String> map = new HashMap<>();
                map.put("kodePeminjaman", kodePem);
                map.put("status_peminjaman", status);
                map.put("alasan_penolakan", alasanT);
                map.put("tgl_peminjaman", tangglP);
                map.put("tgl_kembali", tanggalK);
                return map;
            }
        };
        q.add(stringRequest);

    }
    private void showFailedDialog() {
        ConstraintLayout constraintLayout = findViewById(R.id.failedSave);
        View view = LayoutInflater.from(FormVerif.this).inflate(R.layout.failed_dialog, constraintLayout);
        Button btn = view.findViewById(R.id.btnG);

        AlertDialog.Builder builder = new AlertDialog.Builder(FormVerif.this);
        builder.setView(view);
        final AlertDialog dialog = builder.create();
        btn.findViewById(R.id.btnG).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dialog.dismiss();
                Toast.makeText(FormVerif.this, "DONE", Toast.LENGTH_SHORT).show();
            }
        });
        if (dialog.getWindow() !=null){
            dialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        dialog.show();
    }

    private void showSuccessDialog() {
        ConstraintLayout constraintLayout = findViewById(R.id.successSave);
        View view = LayoutInflater.from(FormVerif.this).inflate(R.layout.success_dialog, constraintLayout);
        Button button = view.findViewById(R.id.btn);

        AlertDialog.Builder builder = new AlertDialog.Builder(FormVerif.this);
        builder.setView(view);

        final AlertDialog alertDialog = builder.create();
        button.findViewById(R.id.btn).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                alertDialog.dismiss();
                Toast.makeText(FormVerif.this, "DONE", Toast.LENGTH_SHORT).show();
                Intent intent = new Intent(getApplicationContext(), ListVerifikasi.class);
                startActivity(intent);
                finish();
            }
        });

        if (alertDialog.getWindow() !=null){
            alertDialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        alertDialog.show();
    }
}