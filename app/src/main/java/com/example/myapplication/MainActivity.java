package com.example.myapplication;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.MenuItem;
import android.widget.Toast;

import com.example.myapplication.Admin.AdminActivity;
import com.example.myapplication.Admin.HomeFragmentAdmin;
import com.example.myapplication.Opd.HomeFragmentOPD;
import com.example.myapplication.Sekre.HomeFragmentSekre;
import com.google.android.material.navigation.NavigationView;

public class MainActivity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener{
    private DrawerLayout drawerLayout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);



        Toolbar toolbar = findViewById(R.id.toolbar2); //Ignore red line errors
        setSupportActionBar(toolbar);

        drawerLayout = findViewById(R.id.drawer_layout3);
        NavigationView navigationView = findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(this, drawerLayout, toolbar, R.string.open_nav,
                R.string.close_nav);
        drawerLayout.addDrawerListener(toggle);
        toggle.syncState();

        if (savedInstanceState == null) {
            Intent intent1 = getIntent();
            int idR = intent1.getIntExtra("id_role",0);
            int id1 = intent1.getIntExtra("id_user", 0);
            String nama1 = intent1.getStringExtra("nama");
            String nip1 = intent1.getStringExtra("nip");
            if(idR == 1){
                HomeFragmentAdmin fragment = new HomeFragmentAdmin();
                Bundle bundle = new Bundle();
                String nama = nama1;
                String nip = nip1;
                int id = id1;
                int role =idR;
                bundle.putString("nama", nama);
                bundle.putString("nip", nip);
                bundle.putInt("id", id);
                bundle.putInt("role", role);
                fragment.setArguments(bundle);
                getSupportFragmentManager().beginTransaction()
                        .replace(R.id.fragment_container, fragment)
                        .commit();
                navigationView.setCheckedItem(R.id.nav_home);
            }else if (idR == 2){
                HomeFragmentOPD fragment = new HomeFragmentOPD();
                Bundle bundle = new Bundle();
                String nama = nama1;
                String nip = nip1;
                int id = id1;
                bundle.putString("nama", nama);
                bundle.putString("nip", nip);
                bundle.putInt("id",id);
                fragment.setArguments(bundle);
                getSupportFragmentManager().beginTransaction()
                        .replace(R.id.fragment_container, fragment)
                        .commit();
                navigationView.setCheckedItem(R.id.nav_home);
            } else if (idR==3) {
                HomeFragmentSekre fragmentProf = new HomeFragmentSekre();
                Bundle b = new Bundle();
                String namap = nama1;
                String nipp = nip1;
                int id = id1;// Replace with the actual data you want to pass
                b.putString("nama", namap);
                b.putString("nip", nipp);
                b.putInt("id", id);
                fragmentProf.setArguments(b);

                getSupportFragmentManager().beginTransaction()
                        .replace(R.id.fragment_container, fragmentProf)
                        .commit();
//                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, new ProfilFragment()).commit();
                navigationView.setCheckedItem(R.id.nav_home);
            }else {
                Toast.makeText(MainActivity.this, "Unvalid Roles", Toast.LENGTH_SHORT).show();
            }

        }
    }
    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
        switch (item.getItemId()) {
            case R.id.nav_home:
                Intent intent1 = getIntent();
                int idR = intent1.getIntExtra("id_role",0);
                int id1 = intent1.getIntExtra("id_user", 0);
                String nama1 = intent1.getStringExtra("nama");
                String nip1 = intent1.getStringExtra("nip");
                if(idR == 1){
                    HomeFragmentAdmin fragment = new HomeFragmentAdmin();
                    Bundle bundle = new Bundle();
                    String nama = nama1;
                    String nip = nip1;
                    int id = id1;
                    int role =idR;
                    bundle.putString("nama", nama);
                    bundle.putString("nip", nip);
                    bundle.putInt("id", id);
                    bundle.putInt("role", role);
                    fragment.setArguments(bundle);
                    getSupportFragmentManager().beginTransaction()
                            .replace(R.id.fragment_container, fragment)
                            .commit();
                }else if (idR == 2){
                    HomeFragmentOPD fragment = new HomeFragmentOPD();
                    Bundle bundle = new Bundle();
                    String nama = nama1;
                    String nip = nip1;
                    int id = id1;
                    bundle.putString("nama", nama);
                    bundle.putString("nip", nip);
                    bundle.putInt("id",id);
                    fragment.setArguments(bundle);
                    getSupportFragmentManager().beginTransaction()
                            .replace(R.id.fragment_container, fragment)
                            .commit();
                } else if (idR==3) {
                    HomeFragmentSekre fragmentProf = new HomeFragmentSekre();
                    Bundle b = new Bundle();
                    String namap = nama1;
                    String nipp = nip1;
                    int idrole = idR;
                    int id = id1;// Replace with the actual data you want to pass
                    b.putString("nama", namap);
                    b.putString("nip", nipp);
                    b.putInt("id", id);
                    b.putInt("idR", id);
                    fragmentProf.setArguments(b);

                    getSupportFragmentManager().beginTransaction()
                            .replace(R.id.fragment_container, fragmentProf)
                            .commit();
//                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, new ProfilFragment()).commit();

                }else {
                    Toast.makeText(MainActivity.this, "Unvalid Roles", Toast.LENGTH_SHORT).show();
                }
                break;
            case R.id.setting:
                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, new SettingFragment()).commit();
                break;

            case R.id.profil:
                Intent intent = getIntent();
                int id = intent.getIntExtra("id_user", 0);
                String namaProf = intent.getStringExtra("nama");
                String nipProf = intent.getStringExtra("nip");
                String mail = intent.getStringExtra("email");
                String dinas = intent.getStringExtra("dinas");
                String username = intent.getStringExtra("username");
                ProfilFragment fragmentProf = new ProfilFragment();
                Bundle b = new Bundle();
                String namap = namaProf;
                String nipp = nipProf;// Replace with the actual data you want to pass
                b.putString("nama", namap);
                b.putString("nip", nipp);
                b.putString("email", mail);
                b.putString("dinas", dinas);
                b.putString("username", username);
                b.putInt("id", id);
                fragmentProf.setArguments(b);

                getSupportFragmentManager().beginTransaction()
                        .replace(R.id.fragment_container, fragmentProf)
                        .commit();
//                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, new ProfilFragment()).commit();
                break;

            case R.id.notif:
                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, new NotifFragment()).commit();
                break;

            case R.id.logout:
                AlertDialog.Builder builder = new AlertDialog.Builder(this);
                builder.setTitle("Keluar");
                builder.setMessage("Yakin Keluar?");
                builder.setNegativeButton("Batal", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        dialogInterface.dismiss();
                    }
                });
                builder.setPositiveButton("Ya", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        startActivity(new Intent(MainActivity.this, Login.class));
                    }
                });
                break;
        }

        drawerLayout.closeDrawer(GravityCompat.START);
        return true;
    }

    @Override
    public void onBackPressed() {
        if (drawerLayout.isDrawerOpen(GravityCompat.START)) {
            drawerLayout.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }
}