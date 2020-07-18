<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    protected $table = 'propiedades';

    protected $fillable = [
        "numero","id_comunidad","tipo"
    ];

    protected $hidden = [
        'updated_at', 'created_at'
    ];
}
