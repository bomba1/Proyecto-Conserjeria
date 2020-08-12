package com.pdbp.android_app.activity

import android.content.Intent
import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.viewModels
import androidx.compose.Composable
import androidx.compose.getValue
import androidx.compose.setValue
import androidx.core.content.ContextCompat.startActivity
import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import androidx.ui.core.ContextAmbient
import androidx.ui.core.Modifier
import androidx.ui.core.setContent
import androidx.ui.foundation.Text
import androidx.ui.graphics.Color
import androidx.ui.input.ImeAction
import androidx.ui.input.PasswordVisualTransformation
import androidx.ui.layout.Column
import androidx.ui.layout.fillMaxWidth
import androidx.ui.layout.padding
import androidx.ui.livedata.observeAsState
import androidx.ui.material.*
import androidx.ui.savedinstancestate.savedInstanceState
import androidx.ui.tooling.preview.Preview
import androidx.ui.unit.dp
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

@Preview
@Composable
fun MyApp(){
    MaterialTheme{
        TopAppBar(title = {
            Text("LOGIN")
        })
    }
}

@Composable
fun Login(viewModel: MainViewModel) {

    // Observamos si se obtiene el token
    val loginResponse by viewModel.loginResponse.observeAsState()

    // UI que contiene el campo de email y password
    Column(
            modifier = Modifier.padding(bottom = 15.dp)
    ) {

        TopAppBar(title = {
            Text("LOGIN")
        })


        // Declaramos los input como variables dinamicas
        var email by savedInstanceState { "" }
        var password by savedInstanceState { "" }

        OutlinedTextField(
            modifier = Modifier.padding(15.dp)+ Modifier.fillMaxWidth(),
            imeAction = ImeAction.Done,
            value = email,
            onValueChange = { email = it},
            placeholder = { Text("example@gmail.com") },
            label = { Text("Email") }
        )

        OutlinedTextField(
                modifier = Modifier.padding(15.dp) + Modifier.fillMaxWidth(),
                imeAction = ImeAction.Done,
                visualTransformation = PasswordVisualTransformation(),
                value = password,
                onValueChange = { password = it },
                label = { Text("Password") }
        )

        // Boton de login, el cual hace la peticion del token
        Button(
                modifier = Modifier.padding(start = 15.dp,top = 15.dp),
                onClick ={viewModel.tryToLogin(email,password)},
                backgroundColor = Color.Red
        ){Text("Login")}


        // Si se obtiene el token
        if(!loginResponse?.token.isNullOrBlank()){

            // Se obtienen los datos para crear una nueva actividad
            val context = ContextAmbient.current
            val intent = Intent(context,RegistroActivity::class.java)

            // Entregamos los datos del usuario que ingreso
            RegistroActivity.setLoginData(loginResponse)
            startActivity(context,intent,null)
        }

        // Si ocurrio un error
        if(!loginResponse?.message.isNullOrBlank()){

            loginResponse?.error?.forEach {
                Text(it)
            }
        }

    }
}



