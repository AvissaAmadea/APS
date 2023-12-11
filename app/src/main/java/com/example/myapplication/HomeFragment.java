package com.example.myapplication;

import android.content.Context;
import android.content.Intent;
import android.database.DataSetObserver;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.GridView;
import android.widget.Toast;


public class HomeFragment extends Fragment {


    private GridView gridView;
    private String[] commonMenuItems = {"Daftar Aset", "Transaksi", "Pelaporan", "Riwayat"};
    private int[] commonMenuItemIcons = {R.drawable.baseline_list_alt_24, R.drawable.baseline_assignment_turned_in_24,
            R.drawable.baseline_report_24, R.drawable.baseline_history_24};
    private String[] menuSekda = {"Daftar Aset", "Transaksi", "Pelaporan", "Riwayat","Verifikasi", "Laporan"};
    private int[] menuSekdaIcons = {R.drawable.baseline_list_alt_24, R.drawable.baseline_assignment_turned_in_24,
            R.drawable.baseline_report_24, R.drawable.baseline_history_24,R.drawable.baseline_verified_24, R.drawable.baseline_assessment_24};

    private String[] menuAdmin = {"Daftar Aset", "Transaksi", "Pelaporan", "Riwayat","Kelola Anggota", "Laporan"};
    private int[] menuAdminIcons = {R.drawable.baseline_list_alt_24, R.drawable.baseline_assignment_turned_in_24,
            R.drawable.baseline_report_24, R.drawable.baseline_history_24,R.drawable.baseline_people_24,R.drawable.baseline_assessment_24};

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home, container, false);

        gridView = view.findViewById(R.id.gridView);

        Bundle args = getArguments();
        String nama_roles = args != null ? args.getString("nama_roles") : "";

        // Set up the GridView based on the user's role
        if ("admin".equals(nama_roles)) {
            setGridViewAdapter(menuAdmin, menuAdminIcons);
        } else if ("OPD".equals(nama_roles)) {
            setGridViewAdapter(commonMenuItems, commonMenuItemIcons);
        } else if ("Sekda".equals(nama_roles)) {
            setGridViewAdapter(menuSekda, menuSekdaIcons);
        }


        // Set item click listener
        gridView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                // Handle item click and start corresponding activity
                String selectedItem = ((String) parent.getItemAtPosition(position));
                handleMenuItemClick(selectedItem);
            }
        });

        return view;
    }


    private void setGridViewAdapter(String[] menuItems, int[] menuItemIcons) {
        // Combine the common items with role-specific items
        String[] combinedMenuItems = new String[commonMenuItems.length + menuItems.length];
        System.arraycopy(commonMenuItems, 0, combinedMenuItems, 0, commonMenuItems.length);
        System.arraycopy(menuItems, 0, combinedMenuItems, commonMenuItems.length, menuItems.length);

        int[] combinedMenuItemIcons = new int[commonMenuItemIcons.length + menuItemIcons.length];
        System.arraycopy(commonMenuItemIcons, 0, combinedMenuItemIcons, 0, commonMenuItemIcons.length);
        System.arraycopy(menuItemIcons, 0, combinedMenuItemIcons, commonMenuItemIcons.length, menuItemIcons.length);

        // Set up the GridView with the custom adapter
        GridAdapter gridAdapter = new GridAdapter(requireContext(), combinedMenuItems, combinedMenuItemIcons);
        gridView.setAdapter(gridAdapter);
    }
    private void handleMenuItemClick(String menuItem) {
        // Start corresponding activity based on the selected menu item
        Intent intent;
        switch (menuItem) {
            case "Daftar Buku":


            case "Laporan":


            case "Transaksi":


            case "Verifikasi":


            case "Kelola Buku":


            case "Kelola Anggota":


            default:
                showToast("Activity not found for menu item: " + menuItem);
        }
    }

    private void showToast(String message) {
        Toast.makeText(requireContext(), message, Toast.LENGTH_SHORT).show();
    }
}

