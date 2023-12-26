package com.example.myapplication;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.text.method.HideReturnsTransformationMethod;
import android.text.method.PasswordTransformationMethod;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Admin.AdminActivity;
import com.example.myapplication.Opd.OpdActivity;
import com.example.myapplication.Sekre.SekreActivity;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class Login extends AppCompatActivity {

    ProgressBar progressBar;
    EditText etUsername, etPassword;
    TextView link, forgot_password;
    LoadDialog loadDialog = new LoadDialog(this);
    boolean passwordVisible;

    Button login;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        etUsername = findViewById(R.id.username_login);
        etPassword = findViewById(R.id.password_login);
        link = findViewById(R.id.to_register);
        forgot_password = findViewById(R.id.lupa_password);
        login = findViewById(R.id.btn_login);

        link.setOnClickListener(view -> {
            startActivity(new Intent(Login.this, Register.class));
        });


        etPassword.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent motionEvent) {
                final int Right = 2;
                if (motionEvent.getAction() == MotionEvent.ACTION_UP) {
                    if (motionEvent.getRawX() >= etPassword.getRight() - etPassword.getCompoundDrawables()[Right].getBounds().width()) {
                        int selection = etPassword.getSelectionEnd();
                        if (passwordVisible) {

                            etPassword.setCompoundDrawablesRelativeWithIntrinsicBounds(R.drawable.baseline_password_24, 0, R.drawable.outline_visibility_off_24, 0);
                            etPassword.setTransformationMethod(PasswordTransformationMethod.getInstance());
                            passwordVisible = false;
                        } else {
                            etPassword.setCompoundDrawablesRelativeWithIntrinsicBounds(R.drawable.baseline_password_24, 0, R.drawable.outline_visibility_24, 0);
                            etPassword.setTransformationMethod(HideReturnsTransformationMethod.getInstance());
                            passwordVisible = true;
                        }
                        etPassword.setSelection(selection);
                        return true;
                    }
                }
                return false;
            }
        });


        login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                loadDialog.ShowDialog("Login");
                String username = etUsername.getText().toString();
                String password = etPassword.getText().toString();

                if (username.isEmpty() || password.isEmpty()) {
                    Toast.makeText(Login.this, "Masukkan Data dengan Benar", Toast.LENGTH_SHORT).show();
                } else {

                    performLogin(username, password);
                }
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
                            loadDialog.HideDialog();
                            JSONObject jsonResponse = new JSONObject(response);
                            if (jsonResponse.has("error")) {
                                String errorMassage = jsonResponse.getString("error");
                                Toast.makeText(Login.this, errorMassage, Toast.LENGTH_SHORT).show();
                            } else {
                                int id_user = jsonResponse.getInt("id_user");
                                int id_role = jsonResponse.getInt("id_role");
                                String nama = jsonResponse.getString("nama");
                                String nip = jsonResponse.getString("nip");
                                String email = jsonResponse.getString("email");
                                String username = jsonResponse.getString("username");
                                String dinas = jsonResponse.getString("nama_dinas");
//                                loginModelList.add(new LoginModel(id_user, id_role, nama,username, email, nip, dinas));
                                if (id_role == 1) {
                                    Intent intent = new Intent(Login.this, AdminActivity.class);
                                    intent.putExtra("id_user",id_user);
                                    intent.putExtra("nama", nama);
                                    intent.putExtra("nip", nip);
                                    intent.putExtra("email", email);
                                    intent.putExtra("dinas", dinas);
                                    intent.putExtra("username", username);
                                    intent.putExtra("id_role", id_role);
                                    startActivity(intent);
                                } else if (id_role == 2) {
                                    Intent intent = new Intent(Login.this, OpdActivity.class);
                                    intent.putExtra("id_user",id_user);
                                    intent.putExtra("nama", nama);
                                    intent.putExtra("nip", nip);
                                    intent.putExtra("email", email);
                                    intent.putExtra("dinas", dinas);
                                    intent.putExtra("username", username);
                                    intent.putExtra("id_role", id_role);
                                    startActivity(intent);
                                } else if (id_role == 3) {
                                    Intent intent = new Intent(Login.this, SekreActivity.class);
                                    intent.putExtra("id_user",id_user);
                                    intent.putExtra("nama", nama);
                                    intent.putExtra("nip", nip);
                                    intent.putExtra("email", email);
                                    intent.putExtra("dinas", dinas);
                                    intent.putExtra("username", username);
                                    intent.putExtra("id_role", id_role);
                                    startActivity(intent);
                                } else {
                                    Toast.makeText(Login.this, "Unvalid Roles", Toast.LENGTH_SHORT).show();
                                }
                            }

                        } catch (JSONException e) {
                            loadDialog.HideDialog();
                            e.printStackTrace();
                            Toast.makeText(Login.this, "response" +response, Toast.LENGTH_SHORT).show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        loadDialog.HideDialog();
                        Log.e("Volley Error", "Error: " + error.getMessage());
                        Toast.makeText(Login.this, "Password atau username salah", Toast.LENGTH_SHORT).show();
                    }
                }
        ) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("username", username);
                params.put("password", password);
                return params;
            }
        };
        Volley.newRequestQueue(this).add(sq);
    }
}
