package com.example.myapplication.Adapter;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.myapplication.DetailDenda;
import com.example.myapplication.DetailPelaporan;
import com.example.myapplication.Model.LaporanModel;
import com.example.myapplication.Model.PelaporanModel;
import com.example.myapplication.R;

import java.util.List;

public class PelaporanAdapter extends RecyclerView.Adapter<PelaporanAdapter.allPel> {
    Context context;
    private List<PelaporanModel> pelaporanModelList;

    public PelaporanAdapter(Context context, List<PelaporanModel> pelaporanModelList) {
        this.context = context;
        this.pelaporanModelList = pelaporanModelList;
    }

    @NonNull
    @Override
    public PelaporanAdapter.allPel onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.ui_lapor, parent, false);
        allPel allPel = new allPel(view);
        return allPel;
    }

    @Override
    public void onBindViewHolder(@NonNull PelaporanAdapter.allPel holder, int position) {
        PelaporanModel model = pelaporanModelList.get(position);
        holder.status.setText(model.getStatus());
        holder.keadaan.setText(model.getKeadaan());
        holder.kode.setText(model.getKode());
        holder.nama.setText(model.getNama());
        holder.aset.setText(model.getAset());
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(context, DetailPelaporan.class);
                intent.putExtra("kode",model.getKode());
                intent.putExtra("keadaan", model.getKeadaan());
                intent.putExtra("status", model.getStatus());
                intent.putExtra("nama", model.getNama());
                intent.putExtra("aset", model.getAset());
                intent.putExtra("denda", model.getDenda());
                context.startActivity(intent);
            }
        });
    }

    @Override
    public int getItemCount() {
        return pelaporanModelList.size();
    }

    public class allPel extends RecyclerView.ViewHolder {
        TextView kode, nama, aset,keadaan, status;
        public allPel(@NonNull View itemView) {
            super(itemView);
            kode = itemView.findViewById(R.id.kodePinjam);
            nama = itemView.findViewById(R.id.nama);
            aset = itemView.findViewById(R.id.aset);
            keadaan = itemView.findViewById(R.id.keadaanA);
            status = itemView.findViewById(R.id.statusPeng);
        }
    }
}