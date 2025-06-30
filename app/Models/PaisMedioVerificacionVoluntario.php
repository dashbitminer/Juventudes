<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisMedioVerificacionVoluntario extends Model
{
    use HasFactory;

    protected $table = 'pais_medio_verificacion_voluntario';

    protected $guarded = [];

    public function medioVerificacionVoluntario()
    {
        return $this->belongsTo(MedioVerificacionVoluntario::class);
    }
}
