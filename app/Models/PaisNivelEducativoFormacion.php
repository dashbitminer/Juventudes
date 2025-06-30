<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisNivelEducativoFormacion extends Model
{
    use HasFactory;

    protected $table = 'pais_nivel_educativo_formaciones';

    protected $guarded = [];

    public function nivelEducativoFormacion()
    {
        return $this->belongsTo(NivelEducativoFormacion::class, 'nivel_educativo_formacion_id');
    }
}
