package com.example.myapplication;

import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import java.util.HashMap;
import java.util.Map;

public class ProfilFragment extends Fragment {

    userManage userManage;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_profil, container, false);

        Button edit = view.findViewById(R.id.button);
        Button out = view.findViewById(R.id.button2);




        // Retrieve the data from the arguments
        if (getArguments() != null) {
            String receivedValue = getArguments().getString("nama");
            String nip = getArguments().getString("nip");
            String mail = getArguments().getString("email");
            String dinas = getArguments().getString("dinas");
            String username = getArguments().getString("username");
            int id = getArguments().getInt("id");

            TextView textView = view.findViewById(R.id.etNama_profile);
            TextView nipUs = view.findViewById(R.id.etNIP_profile);
            TextView email = view.findViewById(R.id.etEmail_prof);
            TextView tvdinas = view.findViewById(R.id.etDinas_profile);
            TextView tvusername = view.findViewById(R.id.etUsername_profile);
            textView.setText(receivedValue);
            nipUs.setText(nip);
            email.setText(mail);
            tvdinas.setText(dinas);
            tvusername.setText(username);
            edit.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    editData(receivedValue, nip, mail, dinas, username, id);
                }
            });
            out.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    startActivity(new Intent(getContext(), Login.class));
                    getActivity().finish();
                }
            });
        }


        return view;
    }

    private void editData(String receivedValue, String nip, String mail, String dinas, String username, int id) {
        StringRequest request = new StringRequest(Request.Method.POST, Db.editProfil,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Toast.makeText(getContext(), "success", Toast.LENGTH_SHORT).show();
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getContext(), "error" +error, Toast.LENGTH_SHORT).show();
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                HashMap<String, String> map = new HashMap<>();
                map.put("nama_dinas", dinas);
                map.put("nip",nip);
                map.put("username", username);
                map.put("nama", receivedValue);
                map.put("email", mail);
                map.put("dinas", dinas);
                map.put("id", String.valueOf(id));
                return map;
            }
        };
        RequestQueue q = Volley.newRequestQueue(getContext());
        q.add(request);
    }
}