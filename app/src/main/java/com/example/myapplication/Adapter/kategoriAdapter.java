package com.example.myapplication.Adapter;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Admin.ListAsetAdmin;
import com.example.myapplication.Db;
import com.example.myapplication.FormKategori;
import com.example.myapplication.Model.kategoriModel;
import com.example.myapplication.R;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class kategoriAdapter extends RecyclerView.Adapter<kategoriAdapter.allAdapter> {
    Context context;
    private List<kategoriModel> kategoriModelList;

    public kategoriAdapter(Context context, List<kategoriModel> kategoriModelList) {
        this.context = context;
        this.kategoriModelList = kategoriModelList;
    }

    @NonNull
    @Override
    public kategoriAdapter.allAdapter onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.ui_layout_kat, parent, false);
        allAdapter Alladapter = new allAdapter(view);
        return Alladapter;
    }

    @Override
    public void onBindViewHolder(@NonNull kategoriAdapter.allAdapter holder, int position) {
        kategoriModel model = kategoriModelList.get(position);
        holder.nama.setText(model.getNama());
        holder.create.setText(model.getCreate_at());
        holder.edit.setOnClickListener(view -> {
            Intent intent = new Intent(context, FormKategori.class);
            intent.putExtra("id", model.getId());
            intent.putExtra("nama", model.getNama());
            context.startActivity(intent);
        });
        holder.hapus.setOnClickListener(view -> {
            AlertDialog.Builder builder = new AlertDialog.Builder(context);
            builder.setTitle("Hapus Data");
            builder.setMessage("Yakin Hapus Data?");
            builder.setNegativeButton("Batal", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialogInterface, int i) {
                    dialogInterface.dismiss();
                }
            });
            builder.setPositiveButton("Yakin", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialogInterface, int i) {
                    DeleteDataKat(kategoriModelList.get(position).getNama(), kategoriModelList.get(position).getId());
                }
            });
            builder.create().show();
        });

    }

    private void DeleteDataKat(String nama, int id) {
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.delKat,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Toast.makeText(context, response, Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(context, ListAsetAdmin.class);
                        context.startActivity(intent);
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Gagal Dihapus", Toast.LENGTH_SHORT).show();
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                HashMap<String, String> map = new HashMap<>();
               map.put("id_kategori", String.valueOf(id));
                return map;
            }
        };
        RequestQueue queue = Volley.newRequestQueue(context);
        queue.add(stringRequest);
    }

    @Override
    public int getItemCount() {
        return kategoriModelList.size();
    }

    public class allAdapter extends RecyclerView.ViewHolder {
        TextView nama, create;
        ImageButton hapus, edit;
        public allAdapter(@NonNull View itemView) {
            super(itemView);
            nama = itemView.findViewById(R.id.nmKategori);
            create = itemView.findViewById(R.id.create_at_kat);
            hapus =itemView.findViewById(R.id.delKat);
            edit = itemView.findViewById(R.id.editKat);
        }
    }
}
