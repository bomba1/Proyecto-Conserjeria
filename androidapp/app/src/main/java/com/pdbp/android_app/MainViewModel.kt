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

    // Variables de personas
    private val _personasData = MutableLiveData<List<Persona>>()
    val personasData: LiveData<List<Persona>>
        get() = _personasData

    // Funcion que retorna personas
    fun getPersonas() {
        viewModelScope.launch {
            try{
                val personas = apiRestEndPoints.findPersonas()
                _personasData.value = personas.personas

            } catch (e: Exception) {
                Log.d("Service Error:", e.toString())
            }
        }
    }

    // Variables de propiedades
    private val _propiedadesData = MutableLiveData<List<Propiedad>>()
    val propiedadesData: LiveData<List<Propiedad>>
        get() = _propiedadesData

    // Funcion que retorna propiedades
    fun getPropiedades() {
        viewModelScope.launch {
            try{
                val propiedades = apiRestEndPoints.findPropiedades()
                _propiedadesData.value = propiedades.propiedades
            } catch (e: Exception) {
                Log.d("Service Error:", e.toString())
            }
        }
    }

    // Variables de Visita
    private val _visitasData = MutableLiveData<List<Visita>>()
    val visitasData: LiveData<List<Visita>>
        get() = _visitasData

    // Funcion que retorna propiedades
    fun getVisitas() {
        viewModelScope.launch {
            try{
                val visitas = apiRestEndPoints.findVisitas()
                _visitasData.value = visitas.visitas

            } catch (e: Exception) {
                Log.d("Service Error:", e.toString())
            }
        }
    }

    // Variables de registro de una visita
    private val _registroResponse = MutableLiveData<RegistroResponse>()
    val registroResponse: LiveData<RegistroResponse>
        get() = _registroResponse

    // Funcion que retorna la respuesta del registro de una visita(el cual es la misma visita)
    fun registro(parentesco: String, empresa_reparto: Boolean, persona_id: String, propiedad_id: String) {
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

                val response = apiRestEndPoints.registroVisitas(dateString, parentesco, empresa_reparto_string, persona_id, propiedad_id)
                _registroResponse.value = response
                Log.d("_registroResponse:", _registroResponse.value.toString())

            } catch (e: Exception) {
                Log.d("Service Error:", e.toString())
            }
        }
    }

    // Variables de login
    private val _loginResponse = MutableLiveData<LoginResponse>()
    val loginResponse: LiveData<LoginResponse>
        get() = _loginResponse

    // Funcion que retorna la respuesta del login
    fun tryToLogin(email: String, password: String) {
        _loginResponse.value = null

        viewModelScope.launch {
            try{
                val response = apiRestEndPoints.login(email, password)
                _loginResponse.value = response
                //Log.d("_loginResponse:", _loginResponse.value.toString())

            } catch (e: Exception) {
                Log.d("Service Error:", e.toString())
            }
        }
    }
}