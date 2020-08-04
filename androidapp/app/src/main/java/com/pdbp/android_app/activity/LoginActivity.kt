package com.pdbp.android_app.activity

import android.content.Intent
import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.viewModels
import androidx.compose.Composable
import androidx.compose.getValue
import androidx.compose.state
import androidx.core.content.ContextCompat.startActivity
import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import androidx.ui.core.ContextAmbient
import androidx.ui.core.setContent
import androidx.ui.foundation.Text
import androidx.ui.foundation.TextField
import androidx.ui.foundation.TextFieldValue
import androidx.ui.graphics.Color
import androidx.ui.layout.Column
import androidx.ui.livedata.observeAsState
import androidx.ui.material.Button
import com.pdbp.android_app.MainViewModel
import com.pdbp.android_app.apiRestEndPoints
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

    // Observamos si se obtiene el token
    val loginResponse by viewModel.loginResponse.observeAsState()

    // UI que contiene el campo de email y password
    Column {

        // Declaramos los input como variables dinamicas
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

        // Boton de login, el cual hace la peticion del token
        Button(onClick =
        {
           viewModel.tryToLogin(email.value.text,password.value.text)
        },
            backgroundColor = Color.Red) {
            Text("Login")
        }

        // Si se obtiene el token
        if(!loginResponse?.token.isNullOrBlank()){

            // Se obtienen los datos para crear una nueva actividad
            val context = ContextAmbient.current
            val intent = Intent(context,RegistroActivity::class.java)

            // Entregamos los datos del usuario que ingreso
            RegistroActivity.setLoginData(loginResponse)
            startActivity(context,intent,null)
        }

    }

}


