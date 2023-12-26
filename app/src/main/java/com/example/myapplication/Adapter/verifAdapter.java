package com.example.myapplication.Adapter;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.myapplication.FormVerif;
import com.example.myapplication.Model.verifModel;
import com.example.myapplication.R;

import org.w3c.dom.Text;

import java.util.List;

public class verifAdapter extends RecyclerView.Adapter<verifAdapter.allList> {

    Context verifCont;
    private List<verifModel> verifModels;
    private AdapterView.OnItemClickListener onItemClickListener;

    public verifAdapter(Context verifCont, List<verifModel> verifModels) {
        this.verifCont = verifCont;
        this.verifModels = verifModels;
    }

    @NonNull
    @Override
    public verifAdapter.allList onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.ui_list_peminjaman, parent,false);
        allList allList = new allList(view);
        return allList;
    }

    @Override
    public void onBindViewHolder(@NonNull verifAdapter.allList holder, int position) {
        verifModel model = verifModels.get(position);
        holder.nama.setText(model.getNama());
        holder.aset.setText(model.getAset());
        holder.status.setText(model.getStatus());
        holder.tglKembali.setText(model.getTglKembali());
        holder.tglpinjam.setText(model.getTglPinjam());
        holder.kode.setText(model.getKode());
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(verifCont, FormVerif.class);
                intent.putExtra("nama", model.getNama());
                intent.putExtra("aset", model.getAset());
                intent.putExtra("tglKembali", model.getTglKembali());
                intent.putExtra("tglPinjam", model.getTglPinjam());
                intent.putExtra("kode", model.getKode());
                intent.putExtra("tujuan", model.getTujuan());
                verifCont.startActivity(intent);
                ((Activity) verifCont).finish();
            }
        });
    }

    @Override
    public int getItemCount() {
        return verifModels.size();
    }

    public class allList extends RecyclerView.ViewHolder {
        TextView nama,aset, kode, tglpinjam, tglKembali, status;

        public allList(@NonNull View itemView) {
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
