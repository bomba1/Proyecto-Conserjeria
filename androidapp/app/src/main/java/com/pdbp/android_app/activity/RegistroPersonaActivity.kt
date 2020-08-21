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
import androidx.ui.layout.padding
import androidx.ui.livedata.observeAsState
import androidx.ui.material.*
import androidx.ui.savedinstancestate.savedInstanceState
import androidx.ui.unit.dp
import com.pdbp.android_app.MainViewModel
import com.pdbp.android_app.apiRestEndPoints
import com.pdbp.android_app.ui.AndroidappTheme

/**
 * Class that simulates a window RegistroPersona
 */
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

/**
 * Function that does the register of Persona
 */
@Composable
fun RegistroPersona(viewModel: MainViewModel){

    // Seeing if we obtain a response from the server
    val personaResponse by viewModel.personaResponse.observeAsState()
    var registroActivity by savedInstanceState { false }
    // UI that contains the fields from Persona
    Column(
            modifier = Modifier.padding(bottom = 15.dp),
            horizontalGravity = Alignment.CenterHorizontally
    ) {

        TopAppBar(title = {
            Text("REGISTRO PERSONA")
        })


        // Declaring inputs as dinamic variables
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

        // Button with the purpose getting a request from the server
        Button(modifier = Modifier.padding(start = 15.dp,top = 15.dp),
                onClick ={viewModel.registroPersona(rut, nombre, telefono, email, LoginActivity.token)})
        { Text("Registrar Persona") }

        // Button that let us go back to the activity RegistroActivity
        Button(modifier = Modifier.padding(start = 15.dp,top = 15.dp),
                onClick ={ registroActivity = true })
        { Text("Volver a Registro Visita") }

        // If we obtain the request
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

        // If an error occurs
        if(personaResponse?.message.equals("Validation Error")){

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
                            personaResponse?.error?.forEach {
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
 * Function that starts a new activity
 */
@Composable
fun abrirRegistroVisita() {
    // Obtaining the data to start new activity
    val context = ContextAmbient.current
    val intent = Intent(context, RegistroActivity::class.java)
    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK or Intent.FLAG_ACTIVITY_CLEAR_TASK)
    ContextCompat.startActivity(context, intent, null)
}

