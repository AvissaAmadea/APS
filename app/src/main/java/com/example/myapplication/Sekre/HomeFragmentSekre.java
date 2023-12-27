package com.example.myapplication.Sekre;

import android.content.Intent;
import android.os.Bundle;

import androidx.cardview.widget.CardView;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.example.myapplication.ListAset;
import com.example.myapplication.R;
import com.example.myapplication.Riwayat;
import com.example.myapplication.SettingFragment;

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

        if (getArguments() != null) {
            String receivedValue = getArguments().getString("nama");
            String nip = getArguments().getString("nip");
            int id = getArguments().getInt("id");
            TextView textView = view.findViewById(R.id.NamaUserSekre);
            TextView textView1 = view.findViewById(R.id.nipUserSekre);
            textView.setText(receivedValue);
            textView1.setText(nip);
            verifikasi.setOnClickListener(view1 -> {
                startActivity(new Intent(getContext(), ListVerifikasi.class));
            });
            aset.setOnClickListener(view1 -> {
                startActivity(new Intent(getContext(), ListAset.class));
            });
            riwayat.setOnClickListener(view1 -> {
                Intent intent = new Intent(requireContext(), Riwayat.class);
                intent.putExtra("id", id);
                startActivity(intent);
                getActivity().finish();
            });
            laporan.setOnClickListener(view1 -> {

            });
            setting.setOnClickListener(view1 -> {
                startActivity(new Intent(getContext(), SettingFragment.class));
            });
        }

        return view;

    }
}