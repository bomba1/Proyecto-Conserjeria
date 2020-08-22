# Proyecto Conserjería 
El Proyecto Conserjería tiene como funcionalidades básicas:  

• Registro y verificación de las visitas a una comunidad.  
• Listado de personas no admitidas en la comunidad.  
• Registro de encomiendas y paquetería recibidas.

# Datos
```
Asignatura: Proyecto Software Basado en Plataformas
Semestre: 7mo Semestre.
Carrera: Ingeniería Civil en Computación e Informática.
Universidad: Universidad Católica del Norte Sede Antofagasta.
Profesor: Mg. Diego Patricio Urrutia Astorga.
```

# Developers
• Miguel Oscar Leon Garrido. (migand21@gmail.com)  
• Pablo Matias Salas Olivares. (pablo.salas@alumnos.ucn.cl)  
• Ignacio Andres Santander Quiñones. (ignaciosantanderq13@gmail.com)

# Technologies
- Java:
  - JDK v9.
  - Jetbrains Intellij 2020 2 EAP.
  - GRadle v6.5.
  - JUnit v5.7.0.
  - GSon v2.8.6.
  - SLF4J v.1.8.0 + Logback v1.3.0.
  - ORMLite v5.1 + SQLite v3.31.1.
  - Javalin v3.8.0.
- PHP:
  - PHP v7.4.7.
  - Jetbrains Intellij 2020 2 EAP + PHP Plugin.
  - Laravel v7.2.5.
- Android:
  - Android Studio Code.
  - Jetpack Compose. 
  - Retrofit.
  
 # Instrucciones
 
 ###Web  
 Ejecutar comandos:
 - php artisan passport:install, para nuevos usuarios registrados  
 - php artisan migrate:fresh --seed, para refrescar los seed  
 - php artisan serve --host $IPV4 --port=8000, para montar el servidor  
 
 ###Android  
 Cambiar en el código:  
 - IP en ApiRestEndPoints por la IPV4 obtenida en CMD.
 - IP en network_security_config por la IPV4 obtenida en CMD.

 
