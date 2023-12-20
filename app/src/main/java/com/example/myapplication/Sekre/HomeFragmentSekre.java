package com.example.myapplication.Sekre;

import android.content.Intent;
import android.os.Bundle;

import androidx.cardview.widget.CardView;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.example.myapplication.ListAset;
import com.example.myapplication.R;
public class HomeFragmentSekre extends Fragment {
    CardView aset, transaksi, verifikasi, riwayat, laporan, lapor, setting;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_home_sekre, container, false);
        aset = view.findViewById(R.id.imgAsetSekre);
        transaksi = view.findViewById(R.id.imgTransSekre);
        verifikasi = view.findViewById(R.id.verifSekre);
        riwayat = view.findViewById(R.id.imgRiwayatSekre);
        laporan = view.findViewById(R.id.laporanSekre);
        lapor = view.findViewById(R.id.imgLaporSekre);
        setting = view.findViewById(R.id.settingSekre);

        verifikasi.setOnClickListener(view1 -> {
            startActivity(new Intent(getContext(), ListVerifikasi.class));
        });
        aset.setOnClickListener(view1 -> {
            startActivity(new Intent(getContext(), ListAset.class));
        });

        return view;

    }
}