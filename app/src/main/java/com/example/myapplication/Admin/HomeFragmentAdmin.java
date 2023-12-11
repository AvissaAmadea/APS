package com.example.myapplication.Admin;

import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.GridView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.example.myapplication.Db;
import com.example.myapplication.GridAdapter;
import com.example.myapplication.R;
import com.example.myapplication.Register;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import org.w3c.dom.Text;

public class HomeFragmentAdmin extends Fragment {

    private GridView gridView;
    private String[] MenuItems = {"Daftar Aset", "Transaksi", "Pelaporan", "Riwayat", "Kelola","Laporan"};
    private int[] MenuItemsIcons = {R.drawable.baseline_list_alt_24, R.drawable.baseline_assignment_turned_in_24,
            R.drawable.baseline_report_24, R.drawable.baseline_history_24, R.drawable.baseline_people_24, R.drawable.baseline_assessment_24};

    TextView nama;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home_admin, container, false);

        nama = view.findViewById(R.id.nm_user);

        StringRequest stringRequest = new StringRequest(Request.Method.POST, Db.getUser,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonResponse = new JSONObject(response);
                            String userName = jsonResponse.getString("nama");

                            // Update the TextView with the user's name
                            nama.setText(userName);

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        });

        gridView = view.findViewById(R.id.gridViewAdmin);
        GridAdapter gridAdapter = new GridAdapter(requireContext(), MenuItems, MenuItemsIcons);
        gridView.setAdapter(gridAdapter);
        // Set item click listener
        gridView.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                gridView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                    @Override
                    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                        // Handle item click
                        String selectedItem = ((String) parent.getItemAtPosition(position));
                        handleMenuItemClick(selectedItem);
                    }
                });


            }
        });
        return view;
    }


    private void handleMenuItemClick(String menuItem) {
        // Start corresponding activity based on the selected menu item
        Intent intent;
        switch (menuItem) {
            case "Daftar Aset":


            case "Laporan":


            case "Transaksi":


            case "Verifikasi":


            case "Kelola Aset":


            case "Kelola Anggota":


            default:
                showToast("Activity not found for menu item: " + menuItem);
        }
    }

    private void showToast(String message) {
        Toast.makeText(requireContext(), message, Toast.LENGTH_SHORT).show();
    }
}