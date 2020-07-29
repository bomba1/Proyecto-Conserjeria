package com.pdbp.android_app.data

import com.google.gson.annotations.SerializedName

data class Propiedades(
    val propiedades: List<Propiedad>
)

data class Personas(
    val personas: List<Persona>
)

data class Persona(
    val id: Int,
    val rut: String,
    val nombre: String,
    val telefono: String,
    val email: String
)

data class Propiedad(
    val id: Int,
    val numero: Int,
    val tipo: String,
    val comunidad_id: Int
)

