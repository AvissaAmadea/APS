package com.example.myapplication.Opd;

import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.cardview.widget.CardView;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import android.content.Intent;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import com.example.myapplication.Admin.HomeFragmentAdmin;
import com.example.myapplication.NotifFragment;
import com.example.myapplication.Opd.HomeFragmentOPD;
import com.example.myapplication.ProfilFragment;
import com.example.myapplication.R;
import com.example.myapplication.SettingFragment;
import com.google.android.material.navigation.NavigationView;

public class OpdActivity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener {

    private DrawerLayout drawerLayout;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_opd);


        Toolbar toolbar = findViewById(R.id.toolbar); //Ignore red line errors
        setSupportActionBar(toolbar);

        drawerLayout = findViewById(R.id.drawer_layout);
        NavigationView navigationView = findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(this, drawerLayout, toolbar, R.string.open_nav,
                R.string.close_nav);
        drawerLayout.addDrawerListener(toggle);
        toggle.syncState();

        if (savedInstanceState == null) {
            Intent intent1 = getIntent();
            int id1 = intent1.getIntExtra("id_user", 0);
            String nama1 = intent1.getStringExtra("nama");
            String nip1 = intent1.getStringExtra("nip");
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
        }
    }

    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
        switch (item.getItemId()) {
            case R.id.nav_home:
                Intent intent1 = getIntent();
                int id1 = intent1.getIntExtra("id_user", 0);
                String nama1 = intent1.getStringExtra("nama");
                String nip1 = intent1.getStringExtra("nip");
                HomeFragmentOPD fragment = new HomeFragmentOPD();
                Bundle bundle = new Bundle();
                String nama = nama1;
                String nip = nip1;
                bundle.putString("nama", nama);
                bundle.putString("nip", nip);
                fragment.setArguments(bundle);
                getSupportFragmentManager().beginTransaction()
                        .replace(R.id.fragment_container, fragment)
                        .commit();
//                getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, new HomeFragmentOPD()).commit();
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
                Toast.makeText(this, "Logout!", Toast.LENGTH_SHORT).show();
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