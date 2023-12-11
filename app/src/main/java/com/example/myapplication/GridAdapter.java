package com.example.myapplication;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.example.myapplication.R;

public class GridAdapter extends BaseAdapter {

    private Context context;
    private String[] menuItems;
    private int[] menuItemIcons;

    public GridAdapter(Context context, String[] menuItems, int[] menuItemIcons) {
        this.context = context;
        this.menuItems = menuItems;
        this.menuItemIcons = menuItemIcons;
    }

    @Override
    public int getCount() {
        return menuItems.length;
    }

    @Override
    public Object getItem(int position) {
        return menuItems[position];
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        View gridViewItem;

        if (convertView == null) {
            LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            gridViewItem = inflater.inflate(R.layout.grid_item, null);

            TextView textView = gridViewItem.findViewById(R.id.gridItemText);
            ImageView imageView = gridViewItem.findViewById(R.id.gridItemImage);

            textView.setText(menuItems[position]);
            imageView.setImageResource(menuItemIcons[position]);
        } else {
            gridViewItem = convertView;
        }

        return gridViewItem;
    }
}
