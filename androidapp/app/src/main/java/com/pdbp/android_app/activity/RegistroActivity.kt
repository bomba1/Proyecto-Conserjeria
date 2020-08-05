package com.pdbp.android_app.activity

import android.content.Intent
import android.os.Bundle
import androidx.activity.ComponentActivity
import androidx.activity.viewModels
import androidx.compose.Composable
import androidx.compose.getValue
import androidx.compose.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import androidx.ui.core.Modifier
import androidx.ui.core.setContent
import androidx.ui.foundation.Text
import androidx.ui.graphics.Color
import androidx.ui.layout.Column
import androidx.ui.livedata.observeAsState
import androidx.ui.material.Button
import androidx.ui.material.Checkbox
import com.pdbp.android_app.MainViewModel
import com.pdbp.android_app.apiRestEndPoints
import com.pdbp.android_app.data.LoginResponse
import com.pdbp.android_app.ui.AndroidappTheme
import androidx.ui.layout.Row
import androidx.ui.layout.padding
import androidx.ui.material.OutlinedTextField
import androidx.ui.material.TopAppBar
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

    // UI que contiene los campos a llenar para el registro de visitas
    Column(
            modifier = Modifier.padding(bottom = 15.dp)
    ) {

        TopAppBar(title = {
            Text("REGISTRO")
        })


        // Declaramos los input como variables dinamicas
        var parentesco by savedInstanceState { "" }
        var empresa_reparto by savedInstanceState { false }
        var persona_id by savedInstanceState { "" }
        var propiedad_id by savedInstanceState { "" }

        OutlinedTextField(
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
                modifier = Modifier.padding(start = 15.dp),
                value = persona_id,
                onValueChange = { persona_id = it},
                placeholder = { Text("12.345.678-9") },
                label = { Text("Rut Persona") }
        )

        OutlinedTextField(
                modifier = Modifier.padding(start = 15.dp),
                value = propiedad_id,
                onValueChange = { propiedad_id = it},
                placeholder = { Text("123456") },
                label = { Text("Numero Propiedad") }
        )

        // Boton el cual hara la peticion del registro y mandara un post al servidor
        Button(modifier = Modifier.padding(start = 15.dp,top = 15.dp),
                onClick ={viewModel.registro(parentesco,empresa_reparto,persona_id,propiedad_id)},
                backgroundColor = Color.Blue) {
            Text("Registrar Visita")
        }

        // Si se obtiene la respuesta al registro, abrimos
        if(!registroResponse?.message.isNullOrBlank()){

            Text(text = "Los datos de la visita ingresada son:")
            Text(text = registroResponse?.visita?.fecha.toString())
            Text(text = registroResponse?.visita?.parentesco.toString())
            Text(text = registroResponse?.visita?.empresa_reparto.toString())
            Text(text = registroResponse?.visita?.persona_id.toString())
            Text(text = registroResponse?.visita?.propiedad_id.toString())

        }

    }

}