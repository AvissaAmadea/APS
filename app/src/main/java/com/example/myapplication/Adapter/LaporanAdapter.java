package com.example.myapplication.Adapter;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.myapplication.Model.LaporanModel;
import com.example.myapplication.R;
import com.example.myapplication.Sekre.VerifPengembalian;

import java.util.List;

public class LaporanAdapter extends RecyclerView.Adapter<LaporanAdapter.allLapor> {
    Context context;
    private List<LaporanModel> laporanModelList;

    public LaporanAdapter(Context context, List<LaporanModel> laporanModelList) {
        this.context = context;
        this.laporanModelList = laporanModelList;
    }

    @NonNull
    @Override
    public LaporanAdapter.allLapor onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.ui_lapor, parent, false);
        allLapor allLapor = new allLapor(view);
        return allLapor;
    }

    @Override
    public void onBindViewHolder(@NonNull LaporanAdapter.allLapor holder, int position) {
        LaporanModel model = laporanModelList.get(position);
        holder.status.setText(model.getStatus());
        holder.keadaan.setText(model.getKeadaan());
        holder.kode.setText(model.getKode());
        holder.nama.setText(model.getNama());
        holder.aset.setText(model.getAset());
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(context, VerifPengembalian.class);
                intent.putExtra("kode", model.getKode());
                intent.putExtra("keadaan", model.getKeadaan());
                intent.putExtra("nama", model.getNama());
                intent.putExtra("aset", model.getAset());
                intent.putExtra("id", model.getId());
                context.startActivity(intent);
            }
        });
    }

    @Override
    public int getItemCount() {
        return laporanModelList.size();
    }

    public class allLapor extends RecyclerView.ViewHolder {
        TextView kode, nama, aset,keadaan, status;
        public allLapor(@NonNull View itemView) {
            super(itemView);
           kode = itemView.findViewById(R.id.kodePinjam);
           nama = itemView.findViewById(R.id.nama);
           aset = itemView.findViewById(R.id.aset);
           keadaan = itemView.findViewById(R.id.keadaanA);
           status = itemView.findViewById(R.id.statusPeng);

        }
    }
}
