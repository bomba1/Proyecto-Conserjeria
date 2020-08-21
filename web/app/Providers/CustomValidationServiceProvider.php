<?php
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

namespace App\Providers;

use App\Persona;
use App\Propiedad;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class CustomValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //1.- Validacion de la k minuscula en rut(Store)
        Validator::extend('k_validator', function ($attribute, $value, $parameters, $validator) {
            //Separamos los primeros 8 numeros y el digito verificador en variables distintas
            list($numero, $digitoVerificador) = explode('-', $value);

            //Si el digito verificador es k minuscula, se reemplaza por k mayuscula y se ve si ya existe en la base de datos
            //Sino se devuelve el rut a su estado original
            if ($digitoVerificador == 'k') {
                $numero = $numero.'-K';

                //Buscamos la persona y si ya se encuentra se responde un mensaje que dice que el rut ya esta en uso
                $contarPersona = Persona::where('rut',$numero)->count();

                if ($contarPersona == 1) {
                    return false;
                }
            } else {
                $numero = $numero.'-'.$digitoVerificador;
            }
            return true;
        });

        Validator::replacer('k_validator', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, $message == 'validation.k_validator'
                ? 'El rut ya esta en uso.'
                : $message);
        });

        //2.- Validacion del email en update(Update)
        Validator::extend('unique_email_update', function ($attribute, $value, $parameters, $validator) {
            $email = $value;
            $rut = $parameters[0];

            //Si el email no esta en uso, retorna true.
            $contar_emails = Persona::where('email',$email)->count();
            if($contar_emails == 0)
                return true;

            //Si el email es encontrado, verificamos si es de la persona que hace el cambio.
            $persona = Persona::where('email',$email)->first();
            $rut_email = $persona->rut;

            if ($rut_email == $rut) {
                return true;
            }else {
                return false;
            }

        });

        Validator::replacer('unique_email_update', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, $message == 'validation.unique_email_update'
                ? 'El email ya esta en uso.'
                : $message);
        });

        //3.- Validacion del numero unico en Propiedad
        Validator::extend('unique_numero_update', function ($attribute, $value, $parameters, $validator) {
            $numero = $value;
            $id = $parameters[0];

            //Si el numero no esta en uso, retorna true.
            $contar_numero= Propiedad::where('numero',$numero)->count();
            if($contar_numero== 0)
                return true;

            //Si el email es encontrado, verificamos si es de la persona que hace el cambio.
            $propiedad = Propiedad::where('numero',$numero)->first();
            $id_persona = $propiedad->id;

            if ($id_persona == $id) {
                return true;
            }else {
                return false;
            }

        });

        Validator::replacer('unique_numero_update', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, $message == 'validation.unique_numero_update'
                ? 'El numero ya esta en uso.'
                : $message);
        });
    }
}
