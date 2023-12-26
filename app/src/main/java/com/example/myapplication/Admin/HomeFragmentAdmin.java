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

import com.example.myapplication.FormPeminjaman;
import com.example.myapplication.ListPelaporan;
import com.example.myapplication.NotifFragment;
import com.example.myapplication.PelaporanKerusakanKehilangan;
import com.example.myapplication.R;
import com.example.myapplication.Riwayat;
import com.example.myapplication.SettingFragment;

import java.util.ArrayList;

public class HomeFragmentAdmin extends Fragment {
    TextView nama, nip;

    CardView daftar, transaksi, lapor, riwayat, kelola, laporan, setting;

    ArrayList<String> peminjamanList = new ArrayList<>();
    ArrayAdapter<String> peminjamanAdapter;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home_admin, container, false);
        daftar = view.findViewById(R.id.imgAsetAdmin);
        transaksi = view.findViewById(R.id.imgTransAdmin);
        lapor = view.findViewById(R.id.imgLaporAdmin);
        riwayat = view.findViewById(R.id.imgRiwayatAdmin);
        kelola = view.findViewById(R.id.kelolaAdmin);
        laporan = view.findViewById(R.id.laporanAdmin);
        setting = view.findViewById(R.id.settingAdmin);
        RecyclerView recyclerView = view.findViewById(R.id.list_peminjamanAdmin);


        if (getArguments() != null) {
            int id = getArguments().getInt("id");
            String receivedValue = getArguments().getString("nama");
            String nip = getArguments().getString("nip");
            TextView textView = view.findViewById(R.id.NamaUser);
            TextView textView1 = view.findViewById(R.id.nipUser);
            textView.setText(receivedValue);
            textView1.setText(nip);
            daftar.setOnClickListener(view1 -> {
                startActivity(new Intent(requireContext(), ListAsetAdmin.class));
            });
            transaksi.setOnClickListener(view1 -> {
                startActivity(new Intent(requireContext(), FormPeminjaman.class));
            });
            lapor.setOnClickListener(view1 -> {
                Intent intent = new Intent(requireContext(), ListPelaporan.class);
                intent.putExtra("id", id);
                startActivity(intent);
            });
            riwayat.setOnClickListener(view1 -> {
                Intent intent = new Intent(requireContext(), Riwayat.class);
                intent.putExtra("id", id);
                startActivity(intent);
            });
            kelola.setOnClickListener(view1 -> {
                startActivity(new Intent(requireContext(), ListPengguna.class));
            });
            setting.setOnClickListener(view1 -> {
                startActivity(new Intent(requireContext(), SettingFragment.class));
            });

        }



        return view;



    }




}


