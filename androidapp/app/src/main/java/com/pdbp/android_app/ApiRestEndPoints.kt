/*
 * MIT License
 *
 * Copyright (c) 2020 Leon-Salas-Santander
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

package com.pdbp.android_app

import com.pdbp.android_app.data.*
import okhttp3.OkHttpClient
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.*

/**
 * The interface for routes
 */
interface ApiRestEndPoints {

    //Route to store a visita
    @POST("registro")
    @FormUrlEncoded
    suspend fun registroVisitas(@Field("fecha") fecha: String ,
                                @Field("parentesco") parentesco: String,
                                @Field("empresa_reparto") empresa_reparto: String,
                                @Field("persona_rut") persona_rut: String,
                                @Field("propiedad_numero") propiedad_numero: String,
                                @Header("Authorization") token: String) : RegistroResponse

    //Route to store a visita
    @POST("persona")
    @FormUrlEncoded
    suspend fun registroPersona(@Field("rut") rut: String ,
                                @Field("nombre") nombre: String,
                                @Field("telefono") telefono: String,
                                @Field("email") email: String,
                                @Header("Authorization") token: String) : PersonaResponse

    //Route to login to the server
    @POST("login")
    @FormUrlEncoded
    suspend fun login(@Field("email") email: String ,
                      @Field("password") password: String) : LoginResponse


}

//Here we obtain de url from the server, to connect to web
val retrofit = Retrofit.Builder()
    .baseUrl(" http://192.168.1.82:8000/api/")
    .client(OkHttpClient())
    .addConverterFactory(GsonConverterFactory.create())
    .build()

// Here we create the connection
val apiRestEndPoints: ApiRestEndPoints = retrofit.create(ApiRestEndPoints::class.java)

