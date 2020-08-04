package com.pdbp.android_app

import com.pdbp.android_app.data.LoginResponse
import com.pdbp.android_app.data.Personas
import com.pdbp.android_app.data.Propiedades
import com.pdbp.android_app.data.Visitas
import okhttp3.OkHttpClient
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.Field
import retrofit2.http.FormUrlEncoded
import retrofit2.http.GET
import retrofit2.http.POST

/**
 * The interface for routes
 */
interface ApiRestEndPoints {

    //Route to get all personas
    @GET("persona")
    suspend fun findPersonas() : Personas

    //Route to get all propiedades
    @GET("propiedad")
    suspend fun findPropiedades() : Propiedades

    //Route to get all visitas
    @GET("registro")
    suspend fun findVisitas() : Visitas

    //Route to get all visitas
    @POST("login")
    @FormUrlEncoded
    suspend fun login(@Field("email") email: String , @Field("password") password: String) : LoginResponse
}

//Here we obtain de url from the server, to connect to web
val retrofit = Retrofit.Builder()
    .baseUrl(" http://192.168.0.50:8000/api/")
    .client(OkHttpClient())
    .addConverterFactory(GsonConverterFactory.create())
    .build()

// Here we create the connection
val apiRestEndPoints: ApiRestEndPoints = retrofit.create(ApiRestEndPoints::class.java)

