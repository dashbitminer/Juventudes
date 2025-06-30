<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisHabilidadAdquirir extends Model
{
    use HasFactory;

    protected $table = 'pais_habilidad_adquirir';

    protected $guarded = [];

    public function habilidadAdquirir()
    {
        return $this->belongsTo(\App\Models\HabilidadesAdquirir::class);
    }
}
