package com.pdbp.android_app

import com.pdbp.android_app.data.Personas
import com.pdbp.android_app.data.Propiedades
import okhttp3.OkHttpClient
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.GET

interface ApiRestEndPoints {

    @GET("persona")
    suspend fun findPersonas() : Personas

    @GET("propiedad")
    suspend fun findPropiedades() : Propiedades
}

val retrofit = Retrofit.Builder()
    .baseUrl("http://127.0.0.1:8000/api/")
    .client(OkHttpClient())
    .addConverterFactory(GsonConverterFactory.create())
    .build()

val apiRestEndPoints: ApiRestEndPoints = retrofit.create(ApiRestEndPoints::class.java)