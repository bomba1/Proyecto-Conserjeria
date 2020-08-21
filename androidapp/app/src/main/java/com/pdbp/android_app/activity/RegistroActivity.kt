/*
 * MIT License
 *
 * Copyright (c) 2020 Leon-Salas-Santander
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

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
import androidx.ui.livedata.observeAsState
import com.pdbp.android_app.MainViewModel
import com.pdbp.android_app.apiRestEndPoints
import com.pdbp.android_app.ui.AndroidappTheme
import androidx.ui.layout.Row
import androidx.ui.layout.padding
import androidx.ui.material.*
import androidx.ui.savedinstancestate.savedInstanceState
import androidx.ui.unit.dp

/**
 * Class Registro Activity
 */
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

    }

}

/**
 * Function that register a Visita
 */
@Composable
fun Registro(viewModel: MainViewModel){

    // We see if we obtain a response from the web server
    val registroResponse by viewModel.registroResponse.observeAsState()
    var registroPersonaActivity by savedInstanceState { false }

    // UI that contains the data from visita
    Column(
            modifier = Modifier.padding(bottom = 15.dp),
            horizontalGravity = Alignment.CenterHorizontally
    ) {

        TopAppBar(title = {
            Text("REGISTRO")
        })


        // Declaring inputs as dinamic variables
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


        // Button that does the request to the server
        Button(modifier = Modifier.padding(start = 15.dp,top = 15.dp),
                onClick ={viewModel.registro(parentesco,empresa_reparto,persona_rut,propiedad_numero, LoginActivity.token)}
        ) { Text("Registrar Visita") }

        // Button with the purpose of registering a Persona
        Button(
                modifier = Modifier.padding(start = 15.dp,top = 15.dp),
                onClick ={ registroPersonaActivity = true }
        ) {Text("Registrar Persona")}

        // If we obtain the response, a pop up shows
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

        // If we obtain a error from the requests
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

/**
 * Function that opens a new activity
 */
@Composable
fun abrirRegistroPersona() {

    // Gathering data to open new activity
    val context = ContextAmbient.current
    val intent = Intent(context, RegistroPersonaActivity::class.java)
    ContextCompat.startActivity(context, intent, null)

}