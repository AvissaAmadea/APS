package com.example.myapplication.Adapter;

import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
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
import com.example.myapplication.Admin.FormAset;
import com.example.myapplication.Admin.ListAsetAdmin;
import com.example.myapplication.Db;
import com.example.myapplication.DetailAset;
import com.example.myapplication.FormPeminjaman;
import com.example.myapplication.LoadDialog;
import com.example.myapplication.Model.asetAdminModel;
import com.example.myapplication.R;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class asetAdminAdapter extends RecyclerView.Adapter<asetAdminAdapter.allAsetAdmin> {
    Context contextAdmin;
    LoadDialog loadDialog;
    private Dialog dialog;
    private List<asetAdminModel> asetAdminModelList;

    private  AdapterView.OnItemClickListener onItemClickListener;

    public asetAdminAdapter(Context contextAdmin, List<asetAdminModel> asetAdminModelList) {
        this.contextAdmin = contextAdmin;
        this.asetAdminModelList = asetAdminModelList;
    }
    public interface  Dialog{
        void onClick(int pos);
    }

    public void setDialog(Dialog dialog) {
        this.dialog = dialog;
    }

    @NonNull
    @Override
    public asetAdminAdapter.allAsetAdmin onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.ui_list_aset_admin, parent, false);
        allAsetAdmin allAsetAdmin = new allAsetAdmin(view);
        return allAsetAdmin;
    }

    @Override
    public void onBindViewHolder(@NonNull asetAdminAdapter.allAsetAdmin holder, @SuppressLint("RecyclerView") int position) {
        asetAdminModel model = asetAdminModelList.get(position);
        holder.nama_aset.setText(model.getNamaAset());
        holder.status.setText(model.getStatusAset());
        holder.kategori.setText(model.getKategoriAsetAdmin());
        holder.detail.setText(model.getDetailAdmin());
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                AlertDialog.Builder alertDialog = new AlertDialog.Builder(contextAdmin);
                CharSequence[] dialogItem = {"Lihat Detail","Edit Data", "Hapus Data", "Ajukan Peminjaman"};
                alertDialog.setTitle("Pilih");
                alertDialog.setItems(dialogItem, new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        switch (i){
                            case 0 :
                                Intent intent = new Intent(contextAdmin, DetailAset.class);
                                intent.putExtra("id", asetAdminModelList.get(position).getIdAset());
                                intent.putExtra("nama_aset", asetAdminModelList.get(position).getNamaAset());
                                intent.putExtra("detail", asetAdminModelList.get(position).getDetailAdmin());
                                intent.putExtra("nama_kategori", asetAdminModelList.get(position).getKategoriAsetAdmin());
                                intent.putExtra("nama_dinas", asetAdminModelList.get(position).getDinasAsetAdmin());
                                intent.putExtra("status", asetAdminModelList.get(position).getStatusAset());
                                contextAdmin.startActivity(intent);
                                break;
                            case 1:
                                Intent intent1 = new Intent(contextAdmin, FormAset.class);
                                intent1.putExtra("id", asetAdminModelList.get(position).getIdAset());
                                intent1.putExtra("nama_aset", asetAdminModelList.get(position).getNamaAset());
                                intent1.putExtra("detail", asetAdminModelList.get(position).getDetailAdmin());
                                intent1.putExtra("nama_kategori", asetAdminModelList.get(position).getKategoriAsetAdmin());
                                intent1.putExtra("nama_dinas", asetAdminModelList.get(position).getDinasAsetAdmin());
                                intent1.putExtra("status", asetAdminModelList.get(position).getStatusAset());
                                contextAdmin.startActivity(intent1);
                                break;

                            case 2:

                                AlertDialog.Builder builder = new AlertDialog.Builder(contextAdmin);
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
                                        DeleteDataAset(asetAdminModelList.get(position).getIdAset(), asetAdminModelList.get(position).getNamaAset(),
                                                asetAdminModelList.get(position).getKategoriAsetAdmin(), asetAdminModelList.get(position).getDetailAdmin(),
                                                asetAdminModelList.get(position).getStatusAset());
                                    }
                                });
                                builder.create().show();

                                break;
                            case 3:
                                Intent intent2 = new Intent(contextAdmin, FormPeminjaman.class);
                                intent2.putExtra("nama_aset", asetAdminModelList.get(position).getNamaAset());
                                contextAdmin.startActivity(intent2);
                                break;
                        }
                    }
                });
                alertDialog.create().show();
            }
        });


    }

    private void DeleteDataAset(int idAset, String namaAset, String kategoriAsetAdmin, String detailAdmin, String statusAset) {

        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.delAset,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Toast.makeText(contextAdmin, "Berhasil Dihapus", Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(contextAdmin, ListAsetAdmin.class);
                        contextAdmin.startActivity(intent);
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(contextAdmin, "Gagal Dihapus", Toast.LENGTH_SHORT).show();
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                HashMap<String, String> map = new HashMap<>();
                map.put("id_aset", String.valueOf(idAset));
                map.put("nama_aset", namaAset);
                map.put("nama_kategori", kategoriAsetAdmin);
                map.put("detail", detailAdmin);
                map.put("status_aset", statusAset);
                return map;
            }
        };
        RequestQueue queue = Volley.newRequestQueue(contextAdmin);
        queue.add(stringRequest);
    }

    @Override
    public int getItemCount() {
        return asetAdminModelList.size();
    }

    public class allAsetAdmin extends RecyclerView.ViewHolder {

        TextView nama_aset, detail, status, kategori;
        ImageButton hapus, edit;


        public allAsetAdmin(@NonNull View itemView) {
            super(itemView);
            kategori = itemView.findViewById(R.id.kategori_aset_admin);
            nama_aset = itemView.findViewById(R.id.nm_aset_aset);
            status = itemView.findViewById(R.id.status_aset_user);
            detail = itemView.findViewById(R.id.ddetail);
        }


    }

}



