package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.ProgressBar;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Adapter.DinasAdapter;
import com.example.myapplication.Model.DinasModel;
import com.example.myapplication.Model.LaporanModel;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.List;

public class ListDinas extends AppCompatActivity {

    TextView textView;
    ProgressBar progressBar;
    List<DinasModel> dinasModelList;
    DinasAdapter adapter;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list_dinas);
        textView = findViewById(R.id.text);
        progressBar = findViewById(R.id.progressbar);
        progressBar.setVisibility(View.VISIBLE);
        fetchDinas();
    }

    private void fetchDinas() {
        StringRequest stringRequest = new StringRequest(Db.getDinas,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            progressBar.setVisibility(View.GONE);
                            JSONObject jsonResponse = new JSONObject(response);
                            JSONArray array = jsonResponse.getJSONArray("report");
                            for (int i = 0; i < array.length(); i++) {
                                JSONObject object = array.getJSONObject(i);
                                dinasModelList.add(new DinasModel(
                                        object.getString("nama_dinas"),
                                        object.getString("alamat"),
                                        object.getInt("id_dinas")
                                ));
                            }
                            adapter.notifyDataSetChanged();
                        } catch (Exception e) {
                            e.printStackTrace();
                            progressBar.setVisibility(View.GONE);
                            textView.setVisibility(View.VISIBLE);
                        }
                    }
                    }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(ListDinas.this, "error", Toast.LENGTH_SHORT).show();
            }
        });
        RequestQueue q = Volley.newRequestQueue(this);
        q.add(stringRequest);
    }

}