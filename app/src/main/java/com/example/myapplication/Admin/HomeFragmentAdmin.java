package com.example.myapplication.Admin;

import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.cardview.widget.CardView;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Db;
import com.example.myapplication.ListAset;
import com.example.myapplication.PelaporanKerusakanKehilangan;
import com.example.myapplication.R;
import com.example.myapplication.Riwayat;
import com.example.myapplication.transaksi;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class HomeFragmentAdmin extends Fragment {

    CardView daftar, transaksi, lapor, riwayat, kelola, laporan;

    TextView nama;

    ArrayList<String> peminjamanList = new ArrayList<>();
    ArrayAdapter<String> peminjamanAdapter;

    RecyclerView recyclerView;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home_admin, container, false);
        nama = view.findViewById(R.id.nm_user);
        daftar = view.findViewById(R.id.imgAset);
        transaksi = view.findViewById(R.id.imgTrans);
        lapor = view.findViewById(R.id.imgLapor);
        riwayat = view.findViewById(R.id.imgRiwayat);
        kelola = view.findViewById(R.id.Kelola);
        laporan = view.findViewById(R.id.lapor);




        fetchNama(nama);

        daftar.setOnClickListener(view1 -> {
            Intent intent = new Intent(requireContext(), ListAset.class);
            startActivity(intent);
        });
        transaksi.setOnClickListener(view1 -> {
            startActivity(new Intent(requireContext(), transaksi.class));
        });
        lapor.setOnClickListener(view1 -> {
            startActivity(new Intent(requireContext(), PelaporanKerusakanKehilangan.class));
        });
        riwayat.setOnClickListener(view1 -> {
            startActivity(new Intent(requireContext(), Riwayat.class));
        });
        kelola.setOnClickListener(view1 -> {
            startActivity(new Intent(requireContext(), ListPengguna.class));
        });



        return view;
    }

    private void fetchNama(TextView nama) {
        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.POST, Db.urlLogin,
                null, new Response.Listener<JSONObject>() {
            @Override
            public void onResponse(JSONObject response) {
                try {
                    JSONObject userObject = response.getJSONArray("user").getJSONObject(0);
                    String nama1 = userObject.optString("nama");
                       nama.setText(nama1);

                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getActivity(), "error", Toast.LENGTH_SHORT).show();
            }
        });
        RequestQueue requestQueue = Volley.newRequestQueue(getContext());
        requestQueue.add(jsonObjectRequest);
    }



}