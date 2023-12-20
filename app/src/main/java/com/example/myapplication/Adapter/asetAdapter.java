package com.example.myapplication.Adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.core.content.ContextCompat;
import androidx.recyclerview.widget.RecyclerView;

import com.example.myapplication.Model.asetModel;
import com.example.myapplication.R;

import java.util.List;

public class asetAdapter extends RecyclerView.Adapter<asetAdapter.allAset> {
    Context contextAset;
    private List<asetModel> asetModelList;

    public asetAdapter(Context contextAset, List<asetModel> asetModelList) {
        this.contextAset = contextAset;
        this.asetModelList = asetModelList;
    }

    @NonNull
    @Override
    public asetAdapter.allAset onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.ui_list_aset,parent, false);
        allAset allAset = new allAset(view);
        return allAset;
    }

    @Override
    public void onBindViewHolder(@NonNull asetAdapter.allAset holder, int position) {
        asetModel asetModel = asetModelList.get(position);
        holder.namaAset.setText(asetModelList.get(position).getNamaAset());
        holder.detail.setText(asetModelList.get(position).getDetail());
        holder.status.setText(asetModelList.get(position).getStats());
        holder.kategori.setText(asetModelList.get(position).getKat());
        holder.add.setOnClickListener(view -> {
        });
    }

    @Override
    public int getItemCount() {
        return asetModelList.size();
    }

    public class allAset extends RecyclerView.ViewHolder{
        TextView namaAset, dinas, kategori, status, detail;
        ImageButton add;
        public allAset(View itemView) {
            super(itemView);
            kategori = itemView.findViewById(R.id.kategori_aset_user);
            namaAset = itemView.findViewById(R.id.nmAsetList);
            dinas = itemView.findViewById(R.id.asal_dinas_aset_user);
            status = itemView.findViewById(R.id.status_aset_user);
            add = itemView.findViewById(R.id.addPinjam);
            detail = itemView.findViewById(R.id.detail);

        }
    }
}
