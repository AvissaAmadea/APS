package com.example.myapplication.Admin;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.myapplication.R;

import org.w3c.dom.Text;

import java.util.List;

public class userAdapter extends RecyclerView.Adapter<userAdapter.allUser>{

    Context context;
    private List<userModel> userModelList;

    public userAdapter(List<userModel> userModelList) {
        this.context = context;
        this.userModelList = userModelList;
    }

    @NonNull
    @Override
    public userAdapter.allUser onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(context).inflate(R.layout.ui_list_pengguna,parent, false);
        allUser allUser = new allUser(view);
        return allUser;

    }

    @Override
    public void onBindViewHolder(@NonNull userAdapter.allUser holder, int position) {
        userModel model = userModelList.get(position);
        holder.nama.setText(model.getNama());
        holder.nip.setText(model.getNip());
        holder.dinas.setText(model.getDinas());
        holder.role.setText(model.getRole());
        holder.create_at.setText(model.getCreate_at());
        holder.status.setText(model.getStatus());
    }

    @Override
    public int getItemCount() {
        return 0;
    }

    public class allUser extends RecyclerView.ViewHolder {
        TextView nama, dinas, nip, role, create_at,status;

        public allUser(@NonNull View itemView) {
            super(itemView);
            nama = itemView.findViewById(R.id.nm_user_user);
            dinas = itemView.findViewById(R.id.asal_dinas);
            nip =itemView.findViewById(R.id.nip_user);
            role =itemView.findViewById(R.id.roles);
            create_at = itemView.findViewById(R.id.create_at);
            status = itemView.findViewById(R.id.status_user);

        }
    }
}
