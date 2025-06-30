<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CohortePaisProyecto extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'cohorte_pais_proyecto';

    protected $guarded = [];

    /**
     * The roles that belong to the CohorteProyectoSocio
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actividades(): BelongsToMany
    {
        return $this->belongsToMany(Actividad::class, 'cohorte_actividades', 'cohorte_pais_proyecto_id', 'actividad_id')
            ->withPivot('cohorte_pais_proyecto_perfil_id');
    }

    /**
     * Get the cohorte that owns the CohortePaisProyecto
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cohorte(): BelongsTo
    {
        return $this->belongsTo(Cohorte::class);
    }

    /**
     * Get the rangoEdades for the CohortePaisProyecto
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rangoEdades()
    {
        return $this->hasMany(CohortePaisProyectoRangoEdad::class);
    }

    /**
     * The perfilesParticipante that belong to the CohortePaisProyecto
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perfilesParticipante(): BelongsToMany
    {
        return $this->belongsToMany(PerfilesParticipante::class, 'cohorte_pais_proyecto_perfil', 'cohorte_pais_proyecto_id', 'perfil_participante_id')
                ->withPivot('id')
                ->withTimestamps();
    }


    public function paisProyecto(): BelongsTo
    {
        return $this->belongsTo(PaisProyecto::class);
    }
}
