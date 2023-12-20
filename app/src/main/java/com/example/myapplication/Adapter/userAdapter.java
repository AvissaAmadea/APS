package com.example.myapplication.Adapter;

import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
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
import com.example.myapplication.Db;
import com.example.myapplication.Model.userModel;
import com.example.myapplication.R;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class userAdapter extends RecyclerView.Adapter<userAdapter.allUser>{

    Context context;
    private List<userModel> userModelList;


    private AdapterView.OnItemClickListener onItemClickListener;


    public userAdapter(Context context,List<userModel> userModelList) {
        this.context = context;
        this.userModelList = userModelList;
    }

    @NonNull
    @Override
    public userAdapter.allUser onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.ui_list_pengguna,parent, false);
        allUser allUser = new allUser(view);
        return allUser;

    }

    @Override
    public void onBindViewHolder(@NonNull userAdapter.allUser holder, int position) {
        userModel model = userModelList.get(position);
        holder.nama.setText(model.getUsername());
        holder.nip.setText(model.getNip());
        holder.dinas.setText(model.getDinas());
        holder.role.setText(model.getRole());
        holder.create_at.setText(model.getCreate_at());


    }

    public void Delete(int item){
        userModelList.remove(item);
        notifyItemRemoved(item);
    }

    @Override
    public int getItemCount() {
        return userModelList.size();

    }

    public class allUser extends RecyclerView.ViewHolder {
        TextView nama, dinas, nip, role, create_at;
        ImageButton hapus, edit;

        public allUser(@NonNull View itemView) {
            super(itemView);
            nama = itemView.findViewById(R.id.nm_user_user);
            dinas = itemView.findViewById(R.id.asal_dinas_user);
            nip =itemView.findViewById(R.id.nip_user);
            role =itemView.findViewById(R.id.roles);
            create_at = itemView.findViewById(R.id.create_at_user);
            hapus = itemView.findViewById(R.id.deleteAsetAdmin);
            edit = itemView.findViewById(R.id.editAsetAdmin);

        }


        public void onClick(View view) {

        }
    }}
