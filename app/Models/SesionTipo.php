<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SesionTipo extends Model
{
    use HasFactory;

    const SESION_GENERAL = 0;

    const HORAS_PARTICIPANTE = 1;

    protected $table = 'sesion_tipos';

    protected $fillable = [
        'typesable_id',
        'typesable_type',
        'cohorte_pais_proyecto_id',
        'cohorte_pais_proyecto_perfil_id',
        'actividad_id',
        'subactividad_id',
        'modulo_id',
        'submodulo_id',
        'tipo',
        'duracion',
    ];

    public function typesable(): MorphTo
    {
        return $this->morphTo();
    }
}
