package com.example.myapplication;

import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.PickVisualMediaRequest;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;

import android.Manifest;
import android.app.AlertDialog;
import android.app.DatePickerDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.ColorDrawable;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Base64;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.Spinner;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.karumi.dexter.Dexter;
import com.karumi.dexter.PermissionToken;
import com.karumi.dexter.listener.PermissionDeniedResponse;
import com.karumi.dexter.listener.PermissionGrantedResponse;
import com.karumi.dexter.listener.PermissionRequest;
import com.karumi.dexter.listener.single.PermissionListener;

import java.io.ByteArrayOutputStream;
import java.io.InputStream;
import java.util.Calendar;
import java.util.HashMap;

public class FormPengembalian extends AppCompatActivity {
    EditText tgl, kode;
    Button simpan;
    ImageView img;
    Spinner spinner;
    private int tahun,bulan,tanggal;
    LinearLayout linearLayout;
    EditText detailKej, detailKer;
    Button bukti;

    Bitmap bitmap;
    String encodeImageString;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_form_pengembalian);
        tgl = findViewById(R.id.tglPinjam);
        kode = findViewById(R.id.kdPeminjaman);
        simpan = findViewById(R.id.simpanKembali);
        spinner = findViewById(R.id.keadaanAset);
        linearLayout = findViewById(R.id.lapor);
        detailKer = findViewById(R.id.detailKer);
        bukti = findViewById(R.id.upRusak);
        img = findViewById(R.id.imageView);

        String[] data = {"Pilih Keadaan Aset", "Baik", "Rusak", "Hilang"};

        // Create an ArrayAdapter using the string array and a default spinner layout
        ArrayAdapter<String> adapter = new ArrayAdapter<>(this, android.R.layout.simple_spinner_item, data);

        // Specify the layout to use when the list of choices appears
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);

        // Apply the adapter to the spinner
        spinner.setAdapter(adapter);

        Intent intent = getIntent();
        String kodeP = intent.getStringExtra("kodePeminjaman");
        kode.setText(kodeP);

//        bukti.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View view) {
//                Dexter.withActivity(FormPengembalian.this)
//                        .withPermission(Manifest.permission.READ_EXTERNAL_STORAGE)
//                        .withListener(new PermissionListener() {
//                            @Override
//                            public void onPermissionGranted(PermissionGrantedResponse response) {
//                                Intent intent1 = new Intent(Intent.ACTION_PICK);
//                                intent1.setType("image/*");
//                                startActivityForResult(Intent.createChooser(intent1,"Ambil dari Galeri"), 1);
//                            }
//
//                            @Override
//                            public void onPermissionDenied(PermissionDeniedResponse permissionDeniedResponse) {
//                                Toast.makeText(FormPengembalian.this, "Permission denied", Toast.LENGTH_SHORT).show();
//                            }
//
//                            @Override
//                            public void onPermissionRationaleShouldBeShown(PermissionRequest permissionRequest, PermissionToken permissionToken) {
//                                permissionToken.continuePermissionRequest();
//                            }
//                        }).check();
//            }
//        });


        tgl.setOnClickListener(view -> {
            Calendar calendar = Calendar.getInstance();
            tahun = calendar.get(Calendar.YEAR);
            bulan = calendar.get(Calendar.MONTH);
            tanggal = calendar.get(Calendar.DAY_OF_MONTH);
            DatePickerDialog dialog;
            dialog = new DatePickerDialog(FormPengembalian.this, new DatePickerDialog.OnDateSetListener() {
                @Override
                public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                    tahun = year;
                    bulan = month;
                    tanggal = dayOfMonth;

                    tgl.setText(tahun + " / " + (bulan+1) + " / " + tanggal);
                }
            },tahun,bulan,tanggal);
            dialog.getDatePicker().setMinDate(calendar.getTimeInMillis()-1000);
            dialog.show();
        });

        simpan.setOnClickListener(view -> {
            String kodePinjam = kode.getText().toString();
            String tglKembali = tgl.getText().toString();
            String keadaan = spinner.getSelectedItem().toString();
            String detail = detailKer.getText().toString();
           if(kodePinjam.isEmpty()){
               Toast.makeText(FormPengembalian.this, "Harap diisi", Toast.LENGTH_LONG).show();
           } else if (tglKembali.isEmpty()) {
               Toast.makeText(FormPengembalian.this, "Harap diisi", Toast.LENGTH_LONG).show();
           }else {
               insertData(kodePinjam, tglKembali, keadaan, detail);

               }
        });

    }

//    @Override
//    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data)
//    {
//        if(requestCode==1 && resultCode==RESULT_OK)
//        {
//            Uri filepath=data.getData();
//            try
//            {
//                InputStream inputStream=getContentResolver().openInputStream(filepath);
//                bitmap= BitmapFactory.decodeStream(inputStream);
//                img.setImageBitmap(bitmap);
//                encodeBitmapImage(bitmap);
//            }catch (Exception ex)
//            {
//
//            }
//        }
//        super.onActivityResult(requestCode, resultCode, data);
//    }
//    private void encodeBitmapImage(Bitmap bitmap)
//    {
//        ByteArrayOutputStream byteArrayOutputStream=new ByteArrayOutputStream();
//        bitmap.compress(Bitmap.CompressFormat.JPEG,100,byteArrayOutputStream);
//        byte[] bytesofimage=byteArrayOutputStream.toByteArray();
//        encodeImageString=android.util.Base64.encodeToString(bytesofimage, Base64.DEFAULT);
//    }


    private void insertData(String kodePinjam, String tglKembali, String keadaan, String detail) {
        RequestQueue queue = Volley.newRequestQueue(this);
        StringRequest rq = new StringRequest(Request.Method.POST, Db.addKembali,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        showSuccessDialog();
                        Toast.makeText(FormPengembalian.this,response, Toast.LENGTH_SHORT).show();
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                showFailedDialog();
           }
        }){
            protected HashMap<String, String> getParams(){
                HashMap<String, String> map = new HashMap<>();
                map.put("kodePeminjaman", kodePinjam);
                map.put("tgl_kembali", tglKembali);
                map.put("keadaanAset", keadaan);
                map.put("detail", detail);
//                map.put("upload",encodeImageString);
                return map;
            }
        };
        queue.add(rq);
    }

    private void showFailedDialog() {
        ConstraintLayout constraintLayout = findViewById(R.id.failedSave);
        View view = LayoutInflater.from(FormPengembalian.this).inflate(R.layout.failed_dialog, constraintLayout);
        Button btn = view.findViewById(R.id.btnG);

        AlertDialog.Builder builder = new AlertDialog.Builder(FormPengembalian.this);
        builder.setView(view);
        final AlertDialog dialog = builder.create();
        btn.findViewById(R.id.btnG).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dialog.dismiss();
                Toast.makeText(FormPengembalian.this, "DONE", Toast.LENGTH_SHORT).show();
            }
        });
        if (dialog.getWindow() !=null){
            dialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        dialog.show();
    }

    private void showSuccessDialog() {
        ConstraintLayout constraintLayout = findViewById(R.id.successSave);
        View view = LayoutInflater.from(FormPengembalian.this).inflate(R.layout.success_dialog, constraintLayout);
        Button button = view.findViewById(R.id.btn);

        AlertDialog.Builder builder = new AlertDialog.Builder(FormPengembalian.this);
        builder.setView(view);

        final AlertDialog alertDialog = builder.create();
        button.findViewById(R.id.btn).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                alertDialog.dismiss();
                Toast.makeText(FormPengembalian.this, "DONE", Toast.LENGTH_SHORT).show();
            }
        });

        if (alertDialog.getWindow() !=null){
            alertDialog.getWindow().setBackgroundDrawable(new ColorDrawable(0));
        }
        alertDialog.show();
    }

}