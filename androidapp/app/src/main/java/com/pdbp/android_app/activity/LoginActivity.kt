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

/**
 * Class Login Activity
 */
class LoginActivity : ComponentActivity() {

    //ViewModel Template
    private val viewModel by viewModels<MainViewModel> {
        object : ViewModelProvider.Factory{
            override fun <T : ViewModel?> create(modelClass: Class<T>): T {
                return MainViewModel(apiRestEndPoints) as T
            }

        }
    }

    // Object that contains useful data from the register, like the token
    companion object {
        var name: String =""
        var email: String =""
        var token : String = ""

        // function that set the data above
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

/**
 * Function that shows LOGIN on top
 */
@Preview
@Composable
fun MyApp(){
    MaterialTheme{
        TopAppBar(title = {
            Text("LOGIN")
        })
    }
}

/**
 * Function that does the login
 */
@Composable
fun Login(viewModel: MainViewModel) {

    // We see if the token is obtained
    val loginResponse by viewModel.loginResponse.observeAsState()

    // UI that contains the email and password
    Column(
        modifier = Modifier.padding(bottom = 15.dp),
        horizontalGravity = Alignment.CenterHorizontally
    ) {

        TopAppBar(title = {
            Text("LOGIN")
        })


        // Declaring the inputs as dinamic variables
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

        // Login button that does the request
        Button(
            modifier = Modifier.padding(start = 15.dp,top = 15.dp) ,
            onClick ={viewModel.tryToLogin(email,password)}
        ){Text("Login")}


        // If we obtain the token
        if(!loginResponse?.token.isNullOrBlank()){

            // Getting necesary data to start new activity
            val context = ContextAmbient.current
            val intent = Intent(context,RegistroActivity::class.java)

            // We set the data for later use(token)
            LoginActivity.setLoginData(loginResponse)
            startActivity(context,intent,null)

        }

        // If an error occurs
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



