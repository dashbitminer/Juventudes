<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisMedioVerificacionFormacion extends Model
{
    use HasFactory;

    protected $table = 'pais_medio_verificacion_formaciones';

    protected $guarded = [];

    public function medioVerificacionFormacion()
    {
        return $this->belongsTo(MedioVerificacionFormacion::class, 'medio_verificacion_formacion_id');
    }
}
