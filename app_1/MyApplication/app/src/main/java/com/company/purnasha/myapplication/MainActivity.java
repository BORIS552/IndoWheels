package com.company.purnasha.myapplication;

import android.os.Environment;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import java.io.File;

public class MainActivity extends AppCompatActivity {
    ListView lview;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        lview = (ListView) findViewById(R.id.lview1);
        String path=getFilesDir().getAbsolutePath();
        File f = new File(path);//converted string object to file
        String[] values = f.list();//getting the list of files in string array
        //now presenting the data into screen
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(getApplicationContext(),android.R.layout.simple_spinner_dropdown_item, values);
        lview.setAdapter(adapter);//setting the adapter
    }
}
