<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    protected $table = 'comunidades';

    protected $fillable = [
        "nombre","direccion"
    ];

    protected $hidden = [
        'updated_at', 'created_at'
    ];
}
