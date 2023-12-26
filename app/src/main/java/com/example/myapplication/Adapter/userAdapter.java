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
import com.example.myapplication.Admin.FormPengguna;
import com.example.myapplication.Admin.ListAsetAdmin;
import com.example.myapplication.Admin.ListPengguna;
import com.example.myapplication.Db;
import com.example.myapplication.DetailAset;
import com.example.myapplication.FormPeminjaman;
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
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                AlertDialog.Builder alertDialog = new AlertDialog.Builder(context);
                CharSequence[] dialogItem = {"Edit Data", "Hapus Data"};
                alertDialog.setTitle("Pilih");
                alertDialog.setItems(dialogItem, new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        switch (i){
                            case 0 :
                                Intent intent = new Intent(context, FormPengguna.class);
                                intent.putExtra("id", userModelList.get(position).getId_user());
                                intent.putExtra("nama", userModelList.get(position).getNama());
                                intent.putExtra("email", userModelList.get(position).getEmail());
                                intent.putExtra("nama_roles", userModelList.get(position).getRole());
                                intent.putExtra("nama_dinas", userModelList.get(position).getDinas());
                                intent.putExtra("status", userModelList.get(position).getStatus());
                                intent.putExtra("nip", userModelList.get(position).getNip());
                                intent.putExtra("username", userModelList.get(position).getUsername());
                                context.startActivity(intent);
                                break;


                            case 1:

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
                                        DeleteDataUser(userModelList.get(position).getId_user(), userModelList.get(position).getDinas(),
                                                userModelList.get(position).getUsername(), userModelList.get(position).getNip(), userModelList.get(position).getRole(),
                                                userModelList.get(position).getCreate_at());
                                    }
                                });
                                builder.create().show();

                                break;

                        }
                    }
                });
                alertDialog.create().show();
            }
        });



    }

    private void DeleteDataUser(int id_user, String username, String nip, String dinas, String role, String create_at) {
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.deleteUser,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Toast.makeText(context, "Berhasil Dihapus", Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(context, ListPengguna.class);
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
                map.put("id_user", String.valueOf(id_user));
                map.put("username", username);
                map.put("nama_dinas", dinas);
                map.put("nama_roles", role);
                map.put("nip", nip);
                map.put("create_at",create_at);
                return map;
            }
        };
        RequestQueue queue = Volley.newRequestQueue(context);
        queue.add(stringRequest);
    }


    @Override
    public int getItemCount() {
        return userModelList.size();

    }

    public class allUser extends RecyclerView.ViewHolder {
        TextView nama, dinas, nip, role, create_at;

        public allUser(@NonNull View itemView) {
            super(itemView);
            nama = itemView.findViewById(R.id.nm_user_user);
            dinas = itemView.findViewById(R.id.asal_dinas_user);
            nip =itemView.findViewById(R.id.nip_user);
            role =itemView.findViewById(R.id.roles);
            create_at = itemView.findViewById(R.id.create_at_user);

        }


        public void onClick(View view) {

        }
    }}
