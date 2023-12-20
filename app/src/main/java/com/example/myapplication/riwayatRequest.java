package com.example.myapplication;

import android.content.Context;

import androidx.annotation.NonNull;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.Volley;
import com.example.myapplication.Model.riwayatItem;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import java.util.ArrayList;
import java.util.List;

public class riwayatRequest {

    private static final String BASE_URL = "http://172.18.2.207/aps1/Peminjaman/getPeminjaman.php";

    private final Context context;
    private final RequestQueue requestQueue;

    public riwayatRequest(Context context) {
        this.context = context;
        this.requestQueue = Volley.newRequestQueue(context);
    }

    public void getBorrowHistory(int userId, final BorrowHistoryCallback callback) {
        String url = BASE_URL + "get_borrow_history.php?user_id=" + userId;

        JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(
                Request.Method.GET,
                url,
                null,
                new Response.Listener<JSONArray>() {
                    @Override
                    public void onResponse(JSONArray response) {
                        List<riwayatItem> historyItems = parseBorrowHistory(response);
                        callback.onSuccess(historyItems);
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        callback.onError(error.toString());
                    }
                }
        );

        requestQueue.add(jsonArrayRequest);
    }

    @NonNull
    private List<riwayatItem> parseBorrowHistory(@NonNull JSONArray jsonArray) {
        List<riwayatItem> historyItems = new ArrayList<>();

        try {
            for (int i = 0; i < jsonArray.length(); i++) {
                JSONObject jsonObject = jsonArray.getJSONObject(i);

                String namaAset = jsonObject.getString("nama_aset");
                String tglPinjam = jsonObject.getString("tglPinjam");
                String tglKembali = jsonObject.getString("tglKembali");
                String tujuan = jsonObject.getString("tujuan");
                String status = jsonObject.getString("status_peminjaman");

                historyItems.add(new riwayatItem(namaAset, tglPinjam, tglKembali, tujuan, status));
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }

        return historyItems;
    }

    public interface BorrowHistoryCallback {
        void onSuccess(List<riwayatItem> historyItems);

        void onError(String errorMessage);
    }
}
