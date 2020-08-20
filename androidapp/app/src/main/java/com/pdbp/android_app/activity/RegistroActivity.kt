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
import androidx.ui.graphics.Color
import androidx.ui.input.ImeAction
import androidx.ui.layout.Column
import androidx.ui.livedata.observeAsState
import com.pdbp.android_app.MainViewModel
import com.pdbp.android_app.apiRestEndPoints
import com.pdbp.android_app.ui.AndroidappTheme
import androidx.ui.layout.Row
import androidx.ui.layout.padding
import androidx.ui.material.*
import androidx.ui.savedinstancestate.savedInstanceState
import androidx.ui.unit.dp

class RegistroActivity() : ComponentActivity() {

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
                Registro(viewModel = viewModel)
            }

        }

        //Obtenemos los datos llenar los modelos
        viewModel.getPersonas()
        viewModel.getPropiedades()
        viewModel.getVisitas()

    }

}

@Composable
fun Registro(viewModel: MainViewModel){

    // Obsevamos si se obtiene la respuesta luego de hacer un registro de visita(la cual es la misma visita)
    val registroResponse by viewModel.registroResponse.observeAsState()
    var registroPersonaActivity by savedInstanceState { false }

    // UI que contiene los campos a llenar para el registro de visitas
    Column(
            modifier = Modifier.padding(bottom = 15.dp),
            horizontalGravity = Alignment.CenterHorizontally
    ) {

        TopAppBar(title = {
            Text("REGISTRO")
        })


        // Declaramos los input como variables dinamicas
        var parentesco by savedInstanceState { "" }
        var empresa_reparto by savedInstanceState { false }
        var persona_rut by savedInstanceState { "" }
        var propiedad_numero by savedInstanceState { "" }

        OutlinedTextField(
                imeAction = ImeAction.Done,
                modifier = Modifier.padding(start = 15.dp),
                value = parentesco,
                onValueChange = { parentesco = it},
                placeholder = { Text("hermano") },
                label = { Text("Parentesco") }
        )

        Row(
                modifier = Modifier.padding(start = 15.dp,top = 5.dp)
        ) {
            Checkbox(
                    checked = empresa_reparto,
                    onCheckedChange = { empresa_reparto = it }
            )
            Text(
                    text = "Empresa Reparto",
                    modifier = Modifier.padding(start = 8.dp)
            )
        }

        OutlinedTextField(
                imeAction = ImeAction.Done,
                modifier = Modifier.padding(start = 15.dp),
                value = persona_rut,
                onValueChange = { persona_rut = it},
                placeholder = { Text("12.345.678-9") },
                label = { Text("Rut Persona") }
        )

        OutlinedTextField(
                imeAction = ImeAction.Done,
                modifier = Modifier.padding(start = 15.dp),
                value = propiedad_numero,
                onValueChange = { propiedad_numero = it},
                placeholder = { Text("123456") },
                label = { Text("Numero Propiedad") }
        )


        // Boton el cual hara la peticion del registro y mandara un post al servidor
        Button(modifier = Modifier.padding(start = 15.dp,top = 15.dp),
                onClick ={viewModel.registro(parentesco,empresa_reparto,persona_rut,propiedad_numero, LoginActivity.token)}
        ) { Text("Registrar Visita") }

        // Boton para ir a registrar una persona
        Button(
                modifier = Modifier.padding(start = 15.dp,top = 15.dp),
                onClick ={ registroPersonaActivity = true }
        ) {Text("Registrar Persona")}

        // Si se obtiene la respuesta al registro, abrimos
        if(registroResponse?.visita != null){

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
                            Text(text = "La visita fue ingresada con exito")
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

            parentesco = ""
            empresa_reparto = false
            persona_rut = ""
            propiedad_numero = ""

        }

        if (registroPersonaActivity) {
            registroPersonaActivity = false
            abrirRegistroPersona()
        }

        // Si ocurrio un error
        if(registroResponse?.message.equals("Validation Error")){

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
                            registroResponse?.error?.forEach {
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

@Composable
fun abrirRegistroPersona() {

    // Se obtienen los datos para crear una nueva actividad
    val context = ContextAmbient.current
    val intent = Intent(context, RegistroPersonaActivity::class.java)
    ContextCompat.startActivity(context, intent, null)

}