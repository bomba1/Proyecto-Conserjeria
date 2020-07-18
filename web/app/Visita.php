<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $fillable = [
        "fecha","id_persona","id_propiedad"
    ];

    protected $hidden = [
        'updated_at', 'created_at'
    ];
}
