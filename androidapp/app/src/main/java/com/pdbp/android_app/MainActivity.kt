package com.pdbp.android_app

import android.os.Bundle
import android.util.Log
import androidx.activity.viewModels
import androidx.appcompat.app.AppCompatActivity
import androidx.compose.Composable
import androidx.compose.getValue
import androidx.lifecycle.LiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.ViewModelProvider
import androidx.ui.core.Modifier
import androidx.ui.core.setContent
import androidx.ui.foundation.AdapterList
import androidx.ui.foundation.Text
import androidx.ui.layout.Column
import androidx.ui.layout.Row
import androidx.ui.layout.padding
import androidx.ui.livedata.observeAsState
import androidx.ui.tooling.preview.Preview
import androidx.ui.unit.dp
import com.pdbp.android_app.data.Persona
import com.pdbp.android_app.data.Propiedad
import com.pdbp.android_app.data.Visita
import com.pdbp.android_app.ui.AndroidappTheme

/**
 * Main Class
 */
class MainActivity : AppCompatActivity() {

    //ViewModel Template
    private val viewModel by viewModels<MainViewModel> {
        object : ViewModelProvider.Factory{
            override fun <T : ViewModel?> create(modelClass: Class<T>): T {
                return MainViewModel(apiRestEndPoints) as T
            }

        }
    }

    //Here we call functions to show the Models
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        setContent {
            AndroidappTheme {
                //Personas(personasData = viewModel.personasData)
                //Propiedades(propiedadesData = viewModel.propiedadesData)
                Visitas(visitasData = viewModel.visitasData)
            }
        }

        //viewModel.getPersonas()
        //viewModel.getPropiedades()
        viewModel.getVisitas()
    }
}

/**
 * This functions let us show personas
 */
@Composable
fun Personas(personasData: LiveData<List<Persona>>){
    val personas by personasData.observeAsState(emptyList())

    AdapterList(
        data = personas
    ) { persona ->
        PersonaItem(persona = persona)
    }
}

/**
 * Here we show every atribute of persona
 */
@Composable
fun PersonaItem(persona: Persona) {

    Column(
    ) {
        Text(text = persona.rut)
        Text(text = persona.nombre)
        Text(text = persona.telefono)
        Text(text = persona.email)
    }
}

/**
 * This functions let us show propiedades
 */
@Composable
fun Propiedades(propiedadesData: LiveData<List<Propiedad>>){
    val propiedades by propiedadesData.observeAsState(emptyList())
    AdapterList(
        data = propiedades
    ) { propiedad ->
        PropiedadItem(propiedad = propiedad)
    }
}

/**
 * Here we show every atribute of propiedad
 */
@Composable
fun PropiedadItem(propiedad: Propiedad) {
    Column(
    ) {
        Text(text = propiedad.id.toString())
        Text(text = propiedad.numero.toString())
        Text(text = propiedad.tipo)
        Text(text = propiedad.comunidad_id.toString())
    }
}

/**
 * This functions let us show visitas
 */
@Composable
fun Visitas(visitasData: LiveData<List<Visita>>){
    val visitas by visitasData.observeAsState(emptyList())
    AdapterList(
        data = visitas
    ) { visita ->
        VisitaItem(visita = visita)
    }
}

/**
 * Here we show every atribute of visita
 */
@Composable
fun VisitaItem(visita: Visita) {
    Column(
    ) {
        Text(text = visita.id.toString())
        Text(text = visita.fecha)
        Text(text = visita.parentesco)
        Text(text = visita.empresa_reparto)
        Text(text = visita.persona_id.toString())
        Text(text = visita.propiedad_id.toString())
    }
}
