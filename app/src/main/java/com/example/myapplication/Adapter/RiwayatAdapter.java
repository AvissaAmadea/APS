package com.example.myapplication.Adapter;

import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.myapplication.Model.RiwayatModel;
import com.example.myapplication.Model.verifModel;
import com.example.myapplication.R;
import com.example.myapplication.detailPeminjaman;

import java.util.List;

public class RiwayatAdapter extends RecyclerView.Adapter<RiwayatAdapter.allRiwayat> {
    Context context;
    private List<RiwayatModel> riwayatModelList;

    public RiwayatAdapter(Context context, List<RiwayatModel> riwayatModelList) {
        this.context = context;
        this.riwayatModelList = riwayatModelList;
    }

    @NonNull
    @Override
    public RiwayatAdapter.allRiwayat onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.ui_list_peminjaman, parent, false);
        allRiwayat allRiwayat = new allRiwayat(view);
        return allRiwayat;
    }

    @Override
    public void onBindViewHolder(@NonNull RiwayatAdapter.allRiwayat holder, int position) {
        RiwayatModel model = riwayatModelList.get(position);
        holder.nama.setText(model.getNama());
        holder.aset.setText(model.getAset());
        holder.status.setText(model.getStatus());
        holder.tglKembali.setText(model.getTglKembali());
        holder.tglpinjam.setText(model.getTglPinjam());
        holder.kode.setText(model.getKode());
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(context, detailPeminjaman.class);
                intent.putExtra("nama", riwayatModelList.get(position).getNama());
                intent.putExtra("nama_aset", model.getAset());
                intent.putExtra("tglP", model.getTglPinjam());
                intent.putExtra("tglK", model.getTglKembali());
                intent.putExtra("kode", model.getKode());
                intent.putExtra("tujuan", model.getTujuan());
                intent.putExtra("status", model.getStatus());
                context.startActivity(intent);
            }
        });
    }

    @Override
    public int getItemCount() {
        return riwayatModelList.size();
    }

    public class allRiwayat extends RecyclerView.ViewHolder {
        TextView nama,aset, kode, tglpinjam, tglKembali, status;
        public allRiwayat(@NonNull View itemView) {
            super(itemView);
            nama = itemView.findViewById(R.id.namaPeminjamVerif);
            aset = itemView.findViewById(R.id.namaAsetVerif);
            tglpinjam = itemView.findViewById(R.id.tglPinjamVerif);
            tglKembali = itemView.findViewById(R.id.tglKembaliVerif);
            status = itemView.findViewById(R.id.statusVerif);
            kode = itemView.findViewById(R.id.kdPeminjaman);
        }
    }
}
