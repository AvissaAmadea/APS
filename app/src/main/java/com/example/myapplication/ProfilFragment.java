package com.example.myapplication;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import org.w3c.dom.Text;

public class ProfilFragment extends Fragment {



    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_profil, container, false);

        Button edit = view.findViewById(R.id.button);
        Button out = view.findViewById(R.id.button2);

        edit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

            }
        });

        // Retrieve the data from the arguments
        if (getArguments() != null) {
            String receivedValue = getArguments().getString("nama");
            String nip = getArguments().getString("nip");
            String mail = getArguments().getString("email");
            String dinas = getArguments().getString("dinas");
            String username = getArguments().getString("username");

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
        }

        return view;
    }
}