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
import com.example.myapplication.Model.LaporanModel;
import com.example.myapplication.Model.kembaliModel;
import com.example.myapplication.R;

import java.util.List;

public class kembaliAdapter extends RecyclerView.Adapter<kembaliAdapter.kembali>{
    Context context;
    private List<kembaliModel> kembaliModelList;

    public kembaliAdapter(Context context, List<kembaliModel> kembaliModelList) {
        this.context = context;
        this.kembaliModelList = kembaliModelList;
    }
    @NonNull
    @Override
    public kembaliAdapter.kembali onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.ui_lapor, parent, false);
        kembali kembali = new kembali(view);
        return kembali;
    }

    @Override
    public void onBindViewHolder(@NonNull kembaliAdapter.kembali holder, int position) {
        kembaliModel model = kembaliModelList.get(position);
        holder.status.setText(model.getStatus());
        holder.keadaan.setText(model.getKeadaan());
        holder.kode.setText(model.getKode());
        holder.nama.setText(model.getNama());
        holder.aset.setText(model.getAset());
//        holder.itemView.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View view) {
//                Intent intent = new Intent(context, DetailDenda.class);
//                intent.putExtra("aset",model.getAset());
//                intent.putExtra("keadaan",model.getKeadaan());
//                intent.putExtra("kode",model.getKode());
//                intent.putExtra("nama",model.getNama());
//            }
//        });

    }

    @Override
    public int getItemCount() {
        return kembaliModelList.size();
    }

    public class kembali extends RecyclerView.ViewHolder {
        TextView kode, nama, aset,keadaan, status;
        public kembali(@NonNull View itemView) {
            super(itemView);
            kode = itemView.findViewById(R.id.kodePinjam);
            nama = itemView.findViewById(R.id.nama);
            aset = itemView.findViewById(R.id.aset);
            keadaan = itemView.findViewById(R.id.keadaanA);
            status = itemView.findViewById(R.id.statusPeng);
        }
    }
}
