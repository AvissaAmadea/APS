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
import com.example.myapplication.Model.dendaModel;
import com.example.myapplication.R;

import java.util.List;

public class dendaAdapter extends RecyclerView.Adapter<dendaAdapter.Alldenda> {
    Context context;
    private List<dendaModel> dendaModelList;

    public dendaAdapter(Context context, List<dendaModel> dendaModelList) {
        this.context = context;
        this.dendaModelList = dendaModelList;
    }



    @NonNull
    @Override
    public dendaAdapter.Alldenda onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.ui_bayar,parent, false);
        Alldenda denda = new Alldenda(view);
        return denda;

    }

    @Override
    public void onBindViewHolder(@NonNull dendaAdapter.Alldenda holder, int position) {
        dendaModel model = dendaModelList.get(position);
        holder.denda.setText(model.getDenda());
        holder.aset.setText(model.getAset());
        holder.keadaan.setText(model.getKeadaan());
        holder.kode.setText(model.getKodeP());
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(context, DetailDenda.class);
                intent.putExtra("denda", model.getDenda());
                intent.putExtra("aset", model.getAset());
                intent.putExtra("keadaan",model.getKeadaan());
                intent.putExtra("kode", model.getKodeP());
                context.startActivity(intent);
            }
        });
    }


    @Override
    public int getItemCount() {
        return dendaModelList.size();
    }


    public class Alldenda extends RecyclerView.ViewHolder {
        TextView kode, keadaan, aset, denda;
        public Alldenda(View itemView) {
            super(itemView);
            kode = itemView.findViewById(R.id.kodePinjam);
            keadaan = itemView.findViewById(R.id.kondisi);
            aset = itemView.findViewById(R.id.aset);
            denda = itemView.findViewById(R.id.denda);
        }
    }
}
