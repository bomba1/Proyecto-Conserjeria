# Diagrama de Clases

@startuml

Visita "*" --> "1" Persona: tiene
Visita "*"--> "1" Propiedad: accede
Comunidad o-- "*" Propiedad: es parte

class Persona {
  - rut: String
  - nombre: String 
  - telefono: String 
  - email: String 
  + Persona ()
  + getRut(): String
  + getNombre(): String
  + getTelefono(): String
  + getEmail(): String 
  + setRut(rut: String): void
  + setNombre(nombre: String): void
  + setTelefono(telefono: String): void
  + setEmail(email: String ): void
}

class Propiedad {
   - numero: Long
   - tipo: TipoPropiedad
   + Propiedad()
   + getNumero(): Long
   + getTipo(): TipoPropiedad
   + setNumero(numero: Long): void
   + setTipo(tipo: TipoPropiedad): void
}

enum TipoPropiedad {
    CASA
    DEPARTAMENTO
}

class Comunidad {
    - nombre: String
    - direccion: String
    - tipo: TipoComunidad
    + Comunidad()
    + getNombre(): String
    + getDireccion(): String
    + getTipo(): TipoComunidad
    + setNombre(nombre: String): void
    + setDireccion(direccion: String): void
    + setTipo(tipo: TipoComunidad): void
}

enum TipoComunidad {
   CONDOMINIO
   EDIFICIO 
}

class Visita {
    - fecha: DateTime
    + Visita()
    + getFecha(): DateTime
    + setFecha(fecha: DateTime): void
}

@enduml
