package com.example.myapplication.Sekre;

import android.content.Intent;
import android.os.Bundle;

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
import com.example.myapplication.ListAset;
import com.example.myapplication.Model.RiwayatModel;
import com.example.myapplication.R;
import com.example.myapplication.Riwayat;
import com.example.myapplication.SettingFragment;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class HomeFragmentSekre extends Fragment {
    CardView aset, transaksi, verifikasi, riwayat, laporan, lapor, setting;
    private List<RiwayatModel> riwayatModelList;
    RiwayatAdapter adapter;

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
        RecyclerView recyclerView = view.findViewById(R.id.list_peminjaman);
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
                startActivity(new Intent(requireContext(), LaporanPeminjaman.class));
            });
            setting.setOnClickListener(view1 -> {
                startActivity(new Intent(getContext(), SettingFragment.class));
            });
            transaksi.setOnClickListener(view1 -> {
                startActivity(new Intent(getContext(), ListDenda.class));
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