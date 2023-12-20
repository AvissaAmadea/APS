package com.example.myapplication.Opd;

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
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Db;
import com.example.myapplication.Admin.ListAsetAdmin;
import com.example.myapplication.ListAset;
import com.example.myapplication.PelaporanKerusakanKehilangan;
import com.example.myapplication.R;
import com.example.myapplication.Riwayat;
import com.example.myapplication.TransaksiUser;

import org.json.JSONException;
import org.json.JSONObject;


public class HomeFragmentOPD extends Fragment {
    CardView daftar, transaksi, lapor, riwayat, setting;

    TextView nama;

    RecyclerView recyclerView;


    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home_opd, container, false);
        nama = view.findViewById(R.id.nm_userMain);
        daftar = view.findViewById(R.id.imgAsetMain);
        transaksi = view.findViewById(R.id.imgTransMain);
        lapor = view.findViewById(R.id.imgLaporMain);
        riwayat = view.findViewById(R.id.imgRiwayatMain);
        recyclerView = view.findViewById(R.id.list_peminjamanOPD);
        setting = view.findViewById(R.id.settingMain);

        fetchNama(nama);

        fetchListPeminjaman(recyclerView);

        daftar.setOnClickListener(view1 -> {
            Intent intent = new Intent(requireContext(), ListAset.class);
            startActivity(intent);
        });
        transaksi.setOnClickListener(view1 -> {
            startActivity(new Intent(requireContext(), TransaksiUser.class));
        });
        lapor.setOnClickListener(view1 -> {
            startActivity(new Intent(requireContext(), PelaporanKerusakanKehilangan.class));
        });
        riwayat.setOnClickListener(view1 -> {
            startActivity(new Intent(requireContext(), Riwayat.class));
        });



        return view;
    }

    private void fetchListPeminjaman(RecyclerView recyclerView) {

    }

    private void fetchNama(TextView nama) {
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.urlLogin,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonResponse = new JSONObject(response);
                            String userName = jsonResponse.getString("nama");



                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getActivity(), "Cannot Fetch user name", Toast.LENGTH_SHORT).show();
            }
        });
        Volley.newRequestQueue(requireContext()).add(stringRequest);

    }



}

