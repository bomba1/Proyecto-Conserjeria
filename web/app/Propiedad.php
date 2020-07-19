<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    protected $table = 'propiedades';

    protected $fillable = [
        "numero","comunidad_id","tipo"
    ];

    protected $hidden = [
        'updated_at', 'created_at'
    ];

    public function comunidad(){
        return $this->belongsTo(Comunidad::class,'comunidad_id');
    }

    public function visitas(){
        return $this->hasMany(Visita::class,'propiedad_id');
    }
}
