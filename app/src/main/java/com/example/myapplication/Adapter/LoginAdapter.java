package com.example.myapplication.Adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.myapplication.Model.LoginModel;
import com.example.myapplication.R;

import java.util.List;

public class LoginAdapter extends RecyclerView.Adapter<LoginAdapter.User> {
    Context loginCont;
    private List<LoginModel> loginModels;

    private AdapterView.OnItemClickListener onItemClickListener;

    public LoginAdapter(Context loginCont, List<LoginModel> loginModels) {
        this.loginCont = loginCont;
        this.loginModels = loginModels;
    }

    @NonNull
    @Override
    public LoginAdapter.User onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        return null;
    }

    @Override
    public void onBindViewHolder(@NonNull LoginAdapter.User holder, int position) {

    }

    @Override
    public int getItemCount() {
        return 0;
    }

    public class User extends RecyclerView.ViewHolder {
        TextView nama, nip;
        public User(@NonNull View itemView) {
            super(itemView);
            nama = itemView.findViewById(R.id.nm_userMain);
        }
    }
}
