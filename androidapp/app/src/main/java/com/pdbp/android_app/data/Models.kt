package com.pdbp.android_app.data


/**
 * Class that contains a list of Propiedad from json
 */
data class Propiedades(
    val message: String,
    val propiedades: List<Propiedad>
)

/**
 * Class that contains a list of Personafrom json
 */
data class Personas(
    val message: String,
    val personas: List<Persona>
)

/**
 * Class that contains a list of Visita from json
 */
data class Visitas(
    val message: String,
    val visitas: List<Visita>
)

/**
 * Class that represents the model of Persona
 */
data class Persona(
    val id: Int,
    val rut: String,
    val nombre: String,
    val telefono: String,
    val email: String
)

/**
 * Class that represents the model of Propiedad
 */
data class Propiedad(
    val id: Int,
    val numero: Int,
    val tipo: String,
    val comunidad_id: Int
)

/**
 * Class that represents the model of Visita
 */
data class Visita(
    val id: Int,
    val fecha: String,
    val parentesco: String,
    val empresa_reparto: String,
    val persona_id: Int,
    val propiedad_id: Int
)
