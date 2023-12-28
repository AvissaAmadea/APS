package com.example.myapplication.Admin;

import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.cardview.widget.CardView;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Adapter.RiwayatAdapter;
import com.example.myapplication.Db;
import com.example.myapplication.ListDenda;
import com.example.myapplication.LaporanPeminjaman;
import com.example.myapplication.Model.RiwayatModel;
import com.example.myapplication.Opd.ListPelaporan;
import com.example.myapplication.R;
import com.example.myapplication.Riwayat;
import com.example.myapplication.SettingFragment;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class HomeFragmentAdmin extends Fragment {
    TextView nama, nip;

    CardView daftar, transaksi, lapor, riwayat, kelola, laporan, setting;

    private List<RiwayatModel> riwayatModelList;
    RiwayatAdapter adapter;


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
                Intent intent = new Intent(requireContext(), ListDenda.class);
                intent.putExtra("id", id);
                startActivity(intent);
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

            });
            laporan.setOnClickListener(view1 -> {
                startActivity(new Intent(requireContext(), LaporanPeminjaman.class));
            });


            fetchData(id);
            riwayatModelList = new ArrayList<>();
            recyclerView.setLayoutManager(new LinearLayoutManager(getContext()));
            adapter = new RiwayatAdapter(getContext(), riwayatModelList);
            recyclerView.setHasFixedSize(true);
            recyclerView.setAdapter(adapter);
            recyclerView.setLayoutManager(new LinearLayoutManager(getContext()));
            recyclerView.addItemDecoration(new DividerItemDecoration(getContext(),DividerItemDecoration.VERTICAL));



        }



        return view;



    }

    private void fetchData(int id) {
        RequestQueue queue = Volley.newRequestQueue(getContext());
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.getPinjam,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            JSONArray array = jsonObject.getJSONArray("peminjaman_aset");
                            for (int i = 0; i<array.length();i++){
                                JSONObject object = array.getJSONObject(i);
                                riwayatModelList.add(new RiwayatModel(
                                        object.getString("nama"),
                                        object.getString("nama_aset"),
                                        object.getString("tgl_pinjam"),
                                        object.getString("tgl_kembali"),
                                        object.getString("kode"),
                                        object.getString("status"),
                                        object.getString("tujuan"),
                                        object.getInt("id_pinjam")
                                ));
                            }
                            Log.d("response", "response"+response);
                            adapter.notifyDataSetChanged();
                        }catch (Exception e){
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getContext(), "error", Toast.LENGTH_SHORT).show();
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                HashMap<String, String> map = new HashMap<>();
                map.put("id_user", String.valueOf(id));
                return map;
            }
        };
        queue.add(stringRequest);
    }


}


