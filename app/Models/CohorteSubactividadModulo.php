<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CohorteSubactividadModulo extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'cohorte_subactividad_modulo';

    protected $guarded = [];

    /**
     * The roles that belong to the CohorteProyectoSocio
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function submodulos(): BelongsToMany
    {
        return $this->belongsToMany(
            Submodulo::class,
            'modulo_subactividad_submodulo',
            'cohorte_subactividad_modulo_id',
            'submodulo_id'
        )->withPivot(['cohorte_pais_proyecto_id', 'cohorte_pais_proyecto_perfil_id']);
    }
}
