<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CohorteSubactividad extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'cohorte_subactividad';

    protected $guarded = [];

    public function subactividades(): BelongsTo
    {
        return $this->belongsTo(Subactividad::class, 'subactividad_id');
    }

    /**
     * The roles that belong to the CohorteSubactividad
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modulos(): BelongsToMany
    {
        return $this->belongsToMany(
            Modulo::class,
            'cohorte_subactividad_modulo',
            'cohorte_subactividad_id',
            'modulo_id'
        )->withPivot(['cohorte_pais_proyecto_id', 'cohorte_pais_proyecto_perfil_id']);
    }
}
