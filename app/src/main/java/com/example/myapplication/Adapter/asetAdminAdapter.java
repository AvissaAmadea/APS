package com.example.myapplication.Adapter;

import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Spinner;
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
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Admin.FormAset;
import com.example.myapplication.Db;
import com.example.myapplication.Model.asetAdminModel;
import com.example.myapplication.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class asetAdminAdapter extends RecyclerView.Adapter<asetAdminAdapter.allAsetAdmin> {
    Context contextAdmin;
    private List<asetAdminModel> asetAdminModelList;

    private  AdapterView.OnItemClickListener onItemClickListener;

    public asetAdminAdapter(Context contextAdmin, List<asetAdminModel> asetAdminModelList) {
        this.contextAdmin = contextAdmin;
        this.asetAdminModelList = asetAdminModelList;
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


    }
    public void Delete(int item){
        asetAdminModelList.remove(item);
        notifyItemRemoved(item);
    }

    @Override
    public int getItemCount() {
        return asetAdminModelList.size();
    }

    public class allAsetAdmin extends RecyclerView.ViewHolder{

        TextView nama_aset, dinas, status, kategori;
        ImageButton hapus, edit;


        public allAsetAdmin(@NonNull View itemView) {
            super(itemView);
            kategori = itemView.findViewById(R.id.kategori_aset_admin);
            nama_aset = itemView.findViewById(R.id.nm_aset_aset);
            status = itemView.findViewById(R.id.status_aset_user);
            hapus = itemView.findViewById(R.id.deleteAsetAdmin);
            edit = itemView.findViewById(R.id.editAsetAdmin);
        }
    }
}
