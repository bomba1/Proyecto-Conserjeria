package com.pdbp.android_app.activity

import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.viewModels
import androidx.compose.Composable
import androidx.compose.getValue
import androidx.compose.state
import androidx.lifecycle.LiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import androidx.ui.core.setContent
import androidx.ui.foundation.AdapterList
import androidx.ui.foundation.Text
import androidx.ui.foundation.TextField
import androidx.ui.foundation.TextFieldValue
import androidx.ui.graphics.Color
import androidx.ui.layout.Column
import androidx.ui.livedata.observeAsState
import androidx.ui.material.Button
import com.pdbp.android_app.MainViewModel
import com.pdbp.android_app.apiRestEndPoints
import com.pdbp.android_app.data.Persona
import com.pdbp.android_app.data.Propiedad
import com.pdbp.android_app.data.Visita
import com.pdbp.android_app.ui.AndroidappTheme


class LoginActivity : ComponentActivity() {

    //ViewModel Template
    private val viewModel by viewModels<MainViewModel> {
        object : ViewModelProvider.Factory{
            override fun <T : ViewModel?> create(modelClass: Class<T>): T {
                return MainViewModel(apiRestEndPoints) as T
            }

        }
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContent {
            AndroidappTheme {
                Login(viewModel = viewModel)
            }
        }

    }
}

@Composable
fun Login(viewModel: MainViewModel){
    val loginResponse by viewModel.loginResponse.observeAsState()
    Column {
        val email = state { TextFieldValue("") }
        val password = state { TextFieldValue("") }

        TextField(
            value = email.value,
            onValueChange = { email.value = it }
        )

        TextField(
            value = password.value,
            onValueChange = { password.value = it }
        )
        Text("The email has this text: "+email.value.text)
        Text("The password has this text: "+password.value.text)

        Button(onClick =
        {
           viewModel.tryToLogin(email.value.text,password.value.text)
        },
            backgroundColor = Color.Red) {
            Text("Login")
        }

        Text("response: "+loginResponse.toString())

        if(loginResponse?.token.isNullOrBlank())
            Text("loginResponse?.token.isNullOrBlank(): "+loginResponse.toString())
    }







}

