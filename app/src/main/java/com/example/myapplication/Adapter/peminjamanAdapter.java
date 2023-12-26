package com.example.myapplication.Adapter;

import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

public class peminjamanAdapter extends RecyclerView.Adapter<peminjamanAdapter.allPinjam>{
    @NonNull
    @Override
    public allPinjam onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        return null;
    }

    @Override
    public void onBindViewHolder(@NonNull allPinjam holder, int position) {

    }


    @Override
    public int getItemCount() {
        return 0;
    }

    public class allPinjam extends RecyclerView.ViewHolder {
        public allPinjam(@NonNull View itemView) {
            super(itemView);
        }

    }
}
