<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class SesionTitulo extends Model
{
    use HasFactory;

    const CERRADO = 0;

    const ABIERTO = 1;

    protected $table = 'sesion_titulos';

    protected $fillable = [
        'titleable_id',
        'titleable_type',
        'cohorte_pais_proyecto_id',
        'cohorte_pais_proyecto_perfil_id',
        'actividad_id',
        'subactividad_id',
        'modulo_id',
        'submodulo_id',
        'titulo_abierto',
        'titulo_id',
    ];

    public function creado(): string {
        return Carbon::parse( $this->created_at)
            ->format( 'M j, Y' );
    }

    public function titleable(): MorphTo
    {
        return $this->morphTo();
    }

    public function titulos(): BelongsTo
    {
        return $this->belongsTo(Titulo::class, 'titulo_id');
    }

    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }

    public function subactividad(): BelongsTo
    {
        return $this->belongsTo(Subactividad::class, 'subactividad_id');
    }

    public function modulo(): BelongsTo
    {
        return $this->belongsTo(Modulo::class, 'modulo_id');
    }

    public function submodulo(): BelongsTo
    {
        return $this->belongsTo(Submodulo::class, 'submodulo_id');
    }

    public function cohortePaisProyecto(): BelongsTo
    {
        return $this->belongsTo(CohortePaisProyecto::class, 'cohorte_pais_proyecto_id');
    }

    public function cohortePaisProyectoPerfil(): BelongsTo
    {
        return $this->belongsTo(CohortePaisProyectoPerfil::class, 'cohorte_pais_proyecto_perfil_id');
    }
}
