package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ProgressBar;

import com.example.myapplication.Adapter.LaporanAdapter;
import com.example.myapplication.Model.LaporanModel;

import java.util.ArrayList;
import java.util.List;

public class ListPelaporan extends AppCompatActivity {

    List<LaporanModel> laporanModelList;
    LaporanAdapter adapter;
    ProgressBar progressBar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_pelaporan);
        Intent intent = getIntent();
        int id = intent.getIntExtra("id",0);

        fetchData(id);
        progressBar = findViewById(R.id.pg);
        laporanModelList = new ArrayList<>();
        RecyclerView recyclerView1 = findViewById(R.id.lapor);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this));
        adapter = new LaporanAdapter(ListPelaporan.this, laporanModelList);
        recyclerView1.setHasFixedSize(true);
        recyclerView1.setAdapter(adapter);
        RecyclerView.ItemDecoration decoration = new DividerItemDecoration(getApplicationContext(), DividerItemDecoration.VERTICAL);
        recyclerView1.setLayoutManager(new LinearLayoutManager(this,LinearLayoutManager.VERTICAL, false));
    }

    private void fetchData(int id) {
        progressBar.setVisibility(View.VISIBLE);


    }

}