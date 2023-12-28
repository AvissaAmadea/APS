package com.example.myapplication.Adapter;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.myapplication.FormDinas;
import com.example.myapplication.Model.DinasModel;
import com.example.myapplication.R;

import java.util.List;

public class DinasAdapter extends RecyclerView.Adapter<DinasAdapter.allDinas> {

    Context context;
    private List<DinasModel> dinasModelList;

    public DinasAdapter(Context context, List<DinasModel> dinasModelList) {
        this.context = context;
        this.dinasModelList = dinasModelList;
    }

    @NonNull
    @Override
    public DinasAdapter.allDinas onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.ui_list_dinas, parent, false);
        allDinas allDinas = new allDinas(view);
        return allDinas;
    }

    @Override
    public void onBindViewHolder(@NonNull DinasAdapter.allDinas holder, int position) {
        DinasModel model = dinasModelList.get(position);
        holder.nama.setText(model.getNama());
        holder.alamat.setText(model.getAlamat());
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(context, FormDinas.class);
                intent.putExtra("nama", model.getNama());
                intent.putExtra("alamat", model.getAlamat());
                intent.putExtra("id", model.getId());
                context.startActivity(intent);
            }
        });
    }

    @Override
    public int getItemCount() {
        return dinasModelList.size();
    }

    public class allDinas extends RecyclerView.ViewHolder {
        TextView nama, alamat;
        public allDinas(@NonNull View itemView) {
            super(itemView);
            nama = itemView.findViewById(R.id.list_nama_dinas);
            alamat = itemView.findViewById(R.id.list_alamat_dinas);
        }
    }
}
