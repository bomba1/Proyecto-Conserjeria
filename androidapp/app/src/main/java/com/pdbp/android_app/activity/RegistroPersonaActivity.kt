package com.pdbp.android_app.activity

import android.content.Intent
import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.viewModels
import androidx.compose.Composable
import androidx.compose.getValue
import androidx.compose.setValue
import androidx.compose.state
import androidx.core.content.ContextCompat
import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import androidx.ui.core.Alignment
import androidx.ui.core.ContextAmbient
import androidx.ui.core.Modifier
import androidx.ui.core.setContent
import androidx.ui.foundation.Text
import androidx.ui.input.ImeAction
import androidx.ui.layout.Column
import androidx.ui.layout.padding
import androidx.ui.livedata.observeAsState
import androidx.ui.material.*
import androidx.ui.savedinstancestate.savedInstanceState
import androidx.ui.unit.dp
import com.pdbp.android_app.MainViewModel
import com.pdbp.android_app.apiRestEndPoints
import com.pdbp.android_app.ui.AndroidappTheme

class RegistroPersonaActivity() : ComponentActivity() {

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
                RegistroPersona(viewModel = viewModel)
            }

        }

    }

}

@Composable
fun RegistroPersona(viewModel: MainViewModel){

    // Observamos si se obtiene la respuesta luego de hacer un registro de persona
    val personaResponse by viewModel.personaResponse.observeAsState()
    var registroActivity by savedInstanceState { false }
    // UI que contiene los campos a llenar para el registro de personas
    Column(
            modifier = Modifier.padding(bottom = 15.dp),
            horizontalGravity = Alignment.CenterHorizontally
    ) {

        TopAppBar(title = {
            Text("REGISTRO PERSONA")
        })


        // Declaramos los input como variables dinamicas
        var rut by savedInstanceState { "" }
        var nombre by savedInstanceState { "" }
        var telefono by savedInstanceState { "" }
        var email by savedInstanceState { "" }

        OutlinedTextField(
                imeAction = ImeAction.Done,
                modifier = Modifier.padding(start = 15.dp),
                value = rut,
                onValueChange = { rut = it},
                placeholder = { Text("12.345.678-9") },
                label = { Text("Rut") }
        )

        OutlinedTextField(
                imeAction = ImeAction.Done,
                modifier = Modifier.padding(start = 15.dp),
                value = nombre,
                onValueChange = { nombre = it},
                placeholder = { Text("Juanito Perez") },
                label = { Text("Nombre Persona") }
        )

        OutlinedTextField(
                imeAction = ImeAction.Done,
                modifier = Modifier.padding(start = 15.dp),
                value = telefono,
                onValueChange = { telefono = it},
                placeholder = { Text("9XXXXXXXX") },
                label = { Text("Telefono Persona") }
        )

        OutlinedTextField(
                imeAction = ImeAction.Done,
                modifier = Modifier.padding(start = 15.dp),
                value = email,
                onValueChange = { email = it},
                placeholder = { Text("ejemplo@gmail.com") },
                label = { Text("Email Persona") }
        )

        // Boton el cual hara la peticion del registro y mandara un post al servidor
        Button(modifier = Modifier.padding(start = 15.dp,top = 15.dp),
                onClick ={viewModel.registroPersona(rut, nombre, telefono, email, LoginActivity.token)})
        { Text("Registrar Persona") }

        // Boton el cual hara nos dejara volver a la actividad Registro Visita
        Button(modifier = Modifier.padding(start = 15.dp,top = 15.dp),
                onClick ={ registroActivity = true })
        { Text("Volver a Registro Visita") }

        // Si se obtiene la respuesta al registro
        if(personaResponse?.persona != null){

            val openDialog = state { true }

            if (openDialog.value) {
                AlertDialog(
                        onCloseRequest = {
                            openDialog.value = false
                        },
                        title = {
                            Text("EXITO")
                        },
                        text = {
                            Text(text = "La persona fue ingresada con exito")
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

            rut = ""
            nombre = ""
            telefono = ""
            email = ""

        }

        if (registroActivity){
            registroActivity = false
            abrirRegistroVisita()
        }

        // Si ocurrio un error
        if(personaResponse?.message.equals("Validation Error")){

            personaResponse?.error?.forEach {
                Text(it)
            }
        }

    }

}

@Composable
fun abrirRegistroVisita() {
    // Se obtienen los datos para crear una nueva actividad
    val context = ContextAmbient.current
    val intent = Intent(context, RegistroActivity::class.java)
    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK)
    ContextCompat.startActivity(context, intent, null)
}

