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
  Persona ()
}

class Propiedad {
   - numero: Long
   - tipo: TipoPropiedad
   Propiedad ()
}

enum TipoPropiedad {
    CASA
    DEPARTAMENTO
}

enum TipoComunidad {
   CONDOMINIO
   EDIFICIO 
}

class Comunidad {
    - nombre: String
    - direccion: String
    - tipo: TipoComunidad
    Comunidad ()
}

class Visita {
    - fecha: DateTime
    Visita ()
}

@enduml
