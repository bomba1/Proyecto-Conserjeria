package com.pdbp.android_app

import android.content.Intent
import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import com.pdbp.android_app.activity.LoginActivity

/**
 * Main Class
 */
class MainActivity : AppCompatActivity() {

    //Here we call functions to show the Models
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        startActivity(Intent(this, LoginActivity::class.java))
    }


}

