<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisServicioDesarrollar extends Model
{
    use HasFactory;

    protected $table = 'pais_servicio_desarrollar';

    protected $guaded = [];

    public function servicioDesarrollar()
    {
        return $this->belongsTo(\App\Models\ServiciosDesarrollar::class);
    }
}
