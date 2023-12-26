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
import com.example.myapplication.Admin.ListPengguna;
import com.example.myapplication.Db;
import com.example.myapplication.Admin.ListAsetAdmin;
import com.example.myapplication.FormPeminjaman;
import com.example.myapplication.ListAset;
import com.example.myapplication.PelaporanKerusakanKehilangan;
import com.example.myapplication.R;
import com.example.myapplication.Riwayat;
import com.example.myapplication.SettingFragment;
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
        daftar = view.findViewById(R.id.imgAsetMain);
        transaksi = view.findViewById(R.id.imgTransMain);
        lapor = view.findViewById(R.id.imgLaporMain);
        riwayat = view.findViewById(R.id.imgRiwayatMain);
        recyclerView = view.findViewById(R.id.list_peminjamanOPD);
        setting = view.findViewById(R.id.settingMain);

        if (getArguments() != null) {
            String receivedValue = getArguments().getString("nama");
            String nip = getArguments().getString("nip");
            int id = getArguments().getInt("id",0);
            TextView textView = view.findViewById(R.id.NamaUserOPD);
            TextView textView1 = view.findViewById(R.id.nipUserOPD);
            textView.setText(receivedValue);
            textView1.setText(nip);
            daftar.setOnClickListener(view1 -> {
                Intent intent = new Intent(requireContext(), ListAsetAdmin.class);
                startActivity(intent);
            });
            transaksi.setOnClickListener(view1 -> {
                startActivity(new Intent(requireContext(), FormPeminjaman.class));
            });
            lapor.setOnClickListener(view1 -> {
                startActivity(new Intent(requireContext(), PelaporanKerusakanKehilangan.class));
            });
            riwayat.setOnClickListener(view1 -> {
                Intent intent = new Intent(requireContext(), Riwayat.class);
                intent.putExtra("id", id);
                startActivity(intent);
                getActivity().finish();
            });

            setting.setOnClickListener(view1 -> {
                startActivity(new Intent(requireContext(), SettingFragment.class));
            });

        }





        return view;
    }


}

