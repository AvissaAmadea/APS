package com.example.myapplication;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
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

            EditText textView = view.findViewById(R.id.etNama_profile);
            EditText nipUs = view.findViewById(R.id.etNIP_profile);
            EditText email = view.findViewById(R.id.etEmail_prof);
            EditText tvdinas = view.findViewById(R.id.etDinas_profile);
            EditText tvusername = view.findViewById(R.id.etUsername_profile);
            textView.setText(receivedValue);
            nipUs.setText(nip);
            email.setText(mail);
            tvdinas.setText(dinas);
            tvusername.setText(username);
            edit.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    String nama = textView.getText().toString();
                    String snip = nipUs.getText().toString();
                    String semail = email.getText().toString();
                    String sdinas = tvdinas.getText().toString();
                    String susername = tvusername.getText().toString();

                    AlertDialog.Builder builder = new AlertDialog.Builder(getContext());
                    builder.setTitle("Simpan Data");
                    builder.setMessage("Yakin Simpan Data?");
                    builder.setNegativeButton("Batal", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {
                            dialogInterface.dismiss();
                        }
                    });
                    builder.setPositiveButton("Yakin", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {
                            editData(nama, snip, semail, sdinas, susername, id);
                        }
                    });
                    builder.create().show();
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

    private void editData(String nama, String snip, String semail, String sdinas, String susername, int id) {
        StringRequest request = new StringRequest(Request.Method.POST, Db.editProfil,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Toast.makeText(getContext(), "success"+response, Toast.LENGTH_SHORT).show();
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getContext(),  ""+error, Toast.LENGTH_SHORT).show();
                Log.d("error","error"+error);
            }
        }){

            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                HashMap<String, String> map = new HashMap<>();
                map.put("nama_dinas", sdinas);
                map.put("nip",snip);
                map.put("username", susername);
                map.put("nama", nama);
                map.put("email", semail);
                map.put("id", String.valueOf(id));
                return map;
            }
        };
        RequestQueue q = Volley.newRequestQueue(requireContext());
        q.add(request);
    }
}