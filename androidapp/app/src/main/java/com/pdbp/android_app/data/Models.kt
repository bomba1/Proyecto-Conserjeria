package com.pdbp.android_app.data


data class Propiedades(
    val message: String,
    val propiedades: List<Propiedad>
)

data class Personas(
    val message: String,
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

