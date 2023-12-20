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

import com.example.myapplication.PelaporanKerusakanKehilangan;
import com.example.myapplication.R;
import com.example.myapplication.Riwayat;
import com.example.myapplication.SettingFragment;
import com.example.myapplication.TransaksiUser;
import com.example.myapplication.riwayatRequest;

import java.util.ArrayList;

public class HomeFragmentAdmin extends Fragment {

    CardView daftar, transaksi, lapor, riwayat, kelola, laporan, setting;

    TextView nama1;

    ArrayList<String> peminjamanList = new ArrayList<>();
    ArrayAdapter<String> peminjamanAdapter;

    RecyclerView recyclerView;
   riwayatRequest request;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home_admin, container, false);
        nama1 = view.findViewById(R.id.nm_user2);
        daftar = view.findViewById(R.id.imgAsetAdmin);
        transaksi = view.findViewById(R.id.imgTransAdmin);
        lapor = view.findViewById(R.id.imgLaporAdmin);
        riwayat = view.findViewById(R.id.imgRiwayatAdmin);
        kelola = view.findViewById(R.id.kelolaAdmin);
        laporan = view.findViewById(R.id.laporanAdmin);
        setting = view.findViewById(R.id.settingAdmin);



        daftar.setOnClickListener(view1 -> {
            Intent intent = new Intent(requireContext(), ListAsetAdmin.class);
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
        kelola.setOnClickListener(view1 -> {
            startActivity(new Intent(requireContext(), ListPengguna.class));
        });
        setting.setOnClickListener(view1 -> {
            startActivity(new Intent(requireContext(), SettingFragment.class));
        });


        return view;



    }





}


