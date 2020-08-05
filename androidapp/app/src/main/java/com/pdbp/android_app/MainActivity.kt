package com.pdbp.android_app

import android.content.Intent
import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.compose.Composable
import androidx.ui.material.MaterialTheme
import androidx.ui.tooling.preview.Preview
import com.pdbp.android_app.activity.LoginActivity

/**
 * Main Class
 */
class MainActivity : AppCompatActivity() {

    //Here we call functions to show the Models
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        // Comenzamos la aplicacion con el login
        startActivity(Intent(this, LoginActivity::class.java))
    }


}

