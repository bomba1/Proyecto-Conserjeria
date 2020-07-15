<?php

namespace App\Providers;

use App\Persona;
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
    }
}
