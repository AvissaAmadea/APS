package com.example.myapplication;

import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.PickVisualMediaRequest;
import androidx.activity.result.contract.ActivityResultContracts;
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
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.Calendar;
import java.util.HashMap;
import java.util.List;

public class FormPeminjaman extends AppCompatActivity {
int position;
    private int tahun,bulan,tanggal;
    private int tahun2,bulan2,tanggal2;
    EditText namaPeminjam, aset, tujuanPinjam, tglPinjam, tglKembali, upload;
    Button simpan;

    LoadDialog loadDialog = new LoadDialog(this);

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_form_peminjaman);

        namaPeminjam = findViewById(R.id.namaPeminjam);
        aset = findViewById(R.id.nama_aset_pinjam);
        tujuanPinjam = findViewById(R.id.Tujuan);
        tglPinjam = findViewById(R.id.tglPinjam);
        tglKembali = findViewById(R.id.tglKembali);
        simpan = findViewById(R.id.simpanPinjam);
        upload = findViewById(R.id.surat);

        Intent intent2 = getIntent();
        if (intent2!=null){
            position = intent2.getExtras().getInt("position");
            aset.setText(intent2.getStringExtra("nama_aset"));
            simpan.setOnClickListener(view -> {
                String nama = namaPeminjam.getText().toString();
                String tujuan = tujuanPinjam.getText().toString();
                String tglPin = tglPinjam.getText().toString();
                String tglKem = tglPinjam.getText().toString();
                String namaAset = aset.getText().toString();
                if (nama.isEmpty()||tujuan.isEmpty()||tglPin.isEmpty()||tglKem.isEmpty()||namaAset.isEmpty()){
                    Toast.makeText(FormPeminjaman.this, "Harap diisi dengan benar", Toast.LENGTH_SHORT).show();
                }else {
                    loadDialog.ShowDialog("Menyimpan....");
                    simpanFormPeminjaman(nama, tujuan, tglPin, tglKem, namaAset);
                }
            });
        }else {
            simpan.setOnClickListener(view -> {
                String nama = namaPeminjam.getText().toString();
                String tujuan = tujuanPinjam.getText().toString();
                String tglPin = tglPinjam.getText().toString();
                String tglKem = tglPinjam.getText().toString();
                String namaAset = aset.getText().toString();
                if (nama.equals(null)||tujuan.equals(null)||tglPin.equals(null)||tglKem.equals(null)||namaAset.equals(null)){
                    Toast.makeText(FormPeminjaman.this, "Harap diisi dengan benar", Toast.LENGTH_SHORT).show();
                }else {
                    loadDialog.ShowDialog("Menyimpan....");
                    simpanFormPeminjaman(nama, tujuan, tglPin, tglKem, namaAset);
                }
            });
        }

        tglPinjam.setOnClickListener(view -> {
            Calendar calendar = Calendar.getInstance();
            tahun = calendar.get(Calendar.YEAR);
            bulan = calendar.get(Calendar.MONTH);
            tanggal = calendar.get(Calendar.DAY_OF_MONTH);
            calendar.add(Calendar.DAY_OF_MONTH,3);
            DatePickerDialog dialog;
            dialog = new DatePickerDialog(FormPeminjaman.this, new DatePickerDialog.OnDateSetListener() {
                @Override
                public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                    tahun = year;
                    bulan = month;
                    tanggal = dayOfMonth;


                    tglPinjam.setText(tahun + "/" + (bulan+1) + "/" + tanggal);
                }
            },tahun,bulan,tanggal);
            dialog.getDatePicker().setMinDate(calendar.getTimeInMillis()-1000);
            dialog.show();
        });
        tglKembali.setOnClickListener(view -> {
            Calendar calendar = Calendar.getInstance();
            tahun2 = calendar.get(Calendar.YEAR);
            bulan2 = calendar.get(Calendar.MONTH);
            tanggal2 = calendar.get(Calendar.DAY_OF_MONTH);
            calendar.add(Calendar.DAY_OF_MONTH,3);
            DatePickerDialog dialog;
            dialog = new DatePickerDialog(FormPeminjaman.this, new DatePickerDialog.OnDateSetListener() {
                @Override
                public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                    tahun2 = year;
                    bulan2 = month;
                    tanggal2 = dayOfMonth;
                    String tgl1 = (tahun2 + "/" + (bulan2+1) + "/" + tanggal2);
                    tglKembali.setText(tgl1);

                }
            },tahun2,bulan2,tanggal2);
            dialog.getDatePicker().setMinDate(calendar.getTimeInMillis()-1000);
            dialog.show();

        });




    }

    private void simpanFormPeminjaman(String nama, String tujuan, String tglPin, String tglKem, String namaAset) {
        RequestQueue queue = Volley.newRequestQueue(this);

        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.addPinjam,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        loadDialog.HideDialog();
                        showSuccessDialog();


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
                map.put("nama_aset", namaAset);
                map.put("nama", nama);
                map.put("tujuan", tujuan);
                map.put("tgl_pinjam", tglPin);
                map.put("tgl_kembali", tglKem);
                return map;
            }

    };
        queue.add(stringRequest);

    }

    private void showFailedDialog() {
        ConstraintLayout constraintLayout = findViewById(R.id.failedSave);
        View view = LayoutInflater.from(FormPeminjaman.this).inflate(R.layout.failed_dialog, constraintLayout);
        Button btn = view.findViewById(R.id.btnG);

        AlertDialog.Builder builder = new AlertDialog.Builder(FormPeminjaman.this);
        builder.setView(view);
        final AlertDialog dialog = builder.create();
        btn.findViewById(R.id.btnG).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dialog.dismiss();
                Toast.makeText(FormPeminjaman.this, "DONE", Toast.LENGTH_SHORT).show();
            }
        });
        if (dialog.getWindow() !=null){
            dialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        dialog.show();
    }

    private void showSuccessDialog() {
        ConstraintLayout constraintLayout = findViewById(R.id.successSave);
        View view = LayoutInflater.from(FormPeminjaman.this).inflate(R.layout.success_dialog, constraintLayout);
        Button button = view.findViewById(R.id.btn);

        AlertDialog.Builder builder = new AlertDialog.Builder(FormPeminjaman.this);
        builder.setView(view);

        final AlertDialog alertDialog = builder.create();
       button.findViewById(R.id.btn).setOnClickListener(new View.OnClickListener() {
           @Override
           public void onClick(View view) {
               alertDialog.dismiss();
               Toast.makeText(FormPeminjaman.this, "DONE", Toast.LENGTH_SHORT).show();
           }
       });

       if (alertDialog.getWindow() !=null){
           alertDialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
       }
       alertDialog.show();
    }
}