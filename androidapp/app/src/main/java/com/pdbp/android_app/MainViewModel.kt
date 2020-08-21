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

package com.pdbp.android_app

import android.util.Log
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.pdbp.android_app.data.*
import com.pdbp.android_app.utils.getCurrentDateTime
import com.pdbp.android_app.utils.toString
import kotlinx.coroutines.launch

/**
 * Class that executes functions from ApiRest
 */
class MainViewModel(
    private val apiRestEndPoints: ApiRestEndPoints
) : ViewModel() {

    // Variables from registro visita
    private val _registroResponse = MutableLiveData<RegistroResponse>()
    val registroResponse: LiveData<RegistroResponse>
        get() = _registroResponse

    // Function that returns the response of visita
    fun registro(parentesco: String, empresa_reparto: Boolean, persona_id: String, propiedad_id: String, token: String) {
        _registroResponse.value = null

        viewModelScope.launch {
            try{
                //Obtaining the current time
                val date = getCurrentDateTime()
                val dateString = date.toString("yyyy-MM-dd HH:mm:ss")

                //transforming the boolean into a string
                var empresa_reparto_string = "NO"
                if (empresa_reparto) {
                    empresa_reparto_string = "SI"
                }

                val response = apiRestEndPoints.registroVisitas(dateString, parentesco, empresa_reparto_string, persona_id, propiedad_id, "Bearer $token")
                _registroResponse.value = response
                Log.d("_registroResponse:", _registroResponse.value.toString())

            } catch (e: Exception) {
                Log.d("Service Error:", e.toString())
            }
        }
    }

    // Variables from persona register
    private val _personaResponse = MutableLiveData<PersonaResponse>()
    val personaResponse: LiveData<PersonaResponse>
        get() = _personaResponse

    // Function that returns the response of persona
    fun registroPersona(rut: String, nombre: String, telefono: String, email: String, token: String) {
        _personaResponse.value = null

        viewModelScope.launch {
            try{

                val response = apiRestEndPoints.registroPersona(rut, nombre, telefono, email, "Bearer $token")
                _personaResponse.value = response

            } catch (e: Exception) {
                Log.d("Service Error:", e.toString())
            }
        }
    }

    // Variables of login
    private val _loginResponse = MutableLiveData<LoginResponse>()
    val loginResponse: LiveData<LoginResponse>
        get() = _loginResponse

    // Function that returns the response of login
    fun tryToLogin(email: String, password: String) {
        _loginResponse.value = null

        viewModelScope.launch {
            try{
                val response = apiRestEndPoints.login(email, password)
                _loginResponse.value = response

            } catch (e: Exception) {
                Log.d("Service Error:", e.toString())
            }
        }
    }

}