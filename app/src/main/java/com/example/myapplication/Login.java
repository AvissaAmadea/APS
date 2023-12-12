package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Admin.AdminActivity;
import com.example.myapplication.Admin.HomeFragmentAdmin;
import com.example.myapplication.Opd.OpdActivity;
import com.example.myapplication.Sekre.SekreActivity;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Login extends AppCompatActivity {

    EditText etUsername, etPassword;
    TextView link, forgot_password;

    Button login;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        etUsername =findViewById(R.id.username_login);
        etPassword = findViewById(R.id.password_login);
        link = findViewById(R.id.to_register);
        forgot_password = findViewById(R.id.lupa_password);
        login = findViewById(R.id.btn_login);

        link.setOnClickListener(view -> {
            startActivity(new Intent(Login.this, Register.class));
        });

        login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String username = etUsername.getText().toString();
                String password = etPassword.getText().toString();

                performLogin(username, password);
            }
        });
    }

    private void performLogin(String username, String password) {
        StringRequest sq = new StringRequest(
                Request.Method.POST,
                Db.urlLogin,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonResponse = new JSONObject(response);
                            if (jsonResponse.has("error")) {
                                String errorMassage = jsonResponse.getString("error");
                                Toast.makeText(Login.this, errorMassage, Toast.LENGTH_SHORT).show();
                            } else {
                                String username = jsonResponse.getString("username");
                                int id_role = jsonResponse.getInt("id_role");
                                if (id_role == 1) {
                                    startActivity(new Intent(Login.this, AdminActivity.class));
                                } else if (id_role == 2) {
                                    startActivity(new Intent(Login.this, OpdActivity.class));
                                } else if (id_role == 3) {
                                    startActivity(new Intent(Login.this, SekreActivity.class));
                                } else {
                                    Toast.makeText(Login.this, "Unvalid Roles", Toast.LENGTH_SHORT).show();
                                }
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("Volley Error", "Error: " + error.getMessage());
                        Toast.makeText(Login.this, "Error occurred", Toast.LENGTH_SHORT).show();
                    }
                }
        ){
          @Override
          protected Map<String, String> getParams(){
              Map<String, String> params = new HashMap<>();
              params.put("username", username);
              params.put("password",password);
              return params;
          }
        };
        Volley.newRequestQueue(this).add(sq);
    }
}