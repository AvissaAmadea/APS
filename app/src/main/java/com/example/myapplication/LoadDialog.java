package com.example.myapplication;

import android.app.Dialog;
import android.content.Context;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.widget.TextView;

import org.w3c.dom.Text;

public class LoadDialog {
    Context context;
    Dialog dialog;

    public LoadDialog(Context context) {
        this.context = context;
    }

    public void ShowDialog(String title){
        dialog = new Dialog(context);
        dialog.setContentView(R.layout.load_dialog);
        dialog.getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));

        TextView textView = dialog.findViewById(R.id.load);
        textView.setText(title);
        dialog.create();
        dialog.show();
    }

    public void HideDialog(){
        dialog.dismiss();
    }
}
