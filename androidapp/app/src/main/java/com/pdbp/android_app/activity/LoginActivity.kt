package com.pdbp.android_app.activity

import android.content.Intent
import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.viewModels
import androidx.compose.Composable
import androidx.compose.getValue
import androidx.compose.setValue
import androidx.compose.state
import androidx.core.content.ContextCompat.startActivity
import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import androidx.ui.core.Alignment
import androidx.ui.core.ContextAmbient
import androidx.ui.core.Modifier
import androidx.ui.core.setContent
import androidx.ui.foundation.Text
import androidx.ui.input.ImeAction
import androidx.ui.input.PasswordVisualTransformation
import androidx.ui.layout.*
import androidx.ui.livedata.observeAsState
import androidx.ui.material.*
import androidx.ui.savedinstancestate.savedInstanceState
import androidx.ui.tooling.preview.Preview
import androidx.ui.unit.dp
import com.pdbp.android_app.MainViewModel
import com.pdbp.android_app.apiRestEndPoints
import com.pdbp.android_app.data.LoginResponse
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

    // Objeto que contiene datos utiles en el registro, sobretodo el token
    companion object {
        var name: String =""
        var email: String =""
        var token : String = ""

        // funcion para asignar los datos
        fun setLoginData(loginResponse: LoginResponse?) {
            if (loginResponse != null) {
                this.name = loginResponse.user.name
                this.email = loginResponse.user.email
                this.token = loginResponse.token
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
        modifier = Modifier.padding(bottom = 15.dp),
        horizontalGravity = Alignment.CenterHorizontally
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
            modifier = Modifier.padding(start = 15.dp,top = 15.dp) ,
            onClick ={viewModel.tryToLogin(email,password)}
        ){Text("Login")}


        // Si se obtiene el token
        if(!loginResponse?.token.isNullOrBlank()){

            // Se obtienen los datos para crear una nueva actividad
            val context = ContextAmbient.current
            val intent = Intent(context,RegistroActivity::class.java)

            // Guardamos los datos del usuario y su token
            LoginActivity.setLoginData(loginResponse)
            startActivity(context,intent,null)

        }

        // Si ocurrio un error
        if(!loginResponse?.message.isNullOrBlank()){

            val openDialog = state { true }

            if (openDialog.value) {
                AlertDialog(
                        onCloseRequest = {
                            openDialog.value = false
                        },
                        title = {
                            Text("ERROR")
                        },
                        text = {
                            loginResponse?.error?.forEach {
                                Text(it)
                            }
                        },
                        confirmButton = {
                            Button(
                                    onClick = {
                                        openDialog.value = false
                                    }){
                                Text("Ok")
                            }
                        },
                        buttonLayout = AlertDialogButtonLayout.Stacked
                )

            }

        }

    }

}



