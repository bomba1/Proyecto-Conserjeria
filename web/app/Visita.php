<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $fillable = [
        "fecha","parentesco","empresa_reparto","persona_id","propiedad_id"
    ];

    protected $hidden = [
        'updated_at', 'created_at'
    ];

    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id');
    }

    public function propiedad(){
        return $this->belongsTo(Propiedad::class,'propiedad_id');
    }
}
