package com.pdbp.android_app

import android.util.Log
import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.pdbp.android_app.data.Persona
import com.pdbp.android_app.data.Propiedad
import kotlinx.coroutines.launch

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
                Log.d("persona",personas.toString())
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
                Log.d("propiedad",propiedades.toString())
                _propiedadesData.value = propiedades.propiedades
            } catch (e: Exception) {
                Log.d("Service Error:", e.toString())
            }
        }
    }


}