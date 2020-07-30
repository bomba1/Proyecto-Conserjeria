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
import com.pdbp.android_app.ui.AndroidappTheme

class MainActivity : AppCompatActivity() {


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
                //Personas(personasData = viewModel.personasData)
                Propiedades(propiedadesData = viewModel.propiedadesData)
            }
        }

        //viewModel.getPersonas()
        viewModel.getPropiedades()
    }
}


@Composable
fun Personas(personasData: LiveData<List<Persona>>){
    val personas by personasData.observeAsState(emptyList())
    AdapterList(
        data = personas
    ) { persona ->
        PersonaItem(persona = persona)
    }
}

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

@Composable
fun Propiedades(propiedadesData: LiveData<List<Propiedad>>){
    val propiedades by propiedadesData.observeAsState(emptyList())
    AdapterList(
        data = propiedades
    ) { propiedad ->
        PropiedadItem(propiedad = propiedad)
    }
}


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

@Composable
fun Greeting(name: String) {
    Text(text = "Hello $name!")
}

@Preview(showBackground = true)
@Composable
fun DefaultPreview() {
    AndroidappTheme {
        Greeting("Android")
    }
}