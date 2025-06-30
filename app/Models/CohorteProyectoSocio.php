<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CohorteProyectoSocio extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'cohorte_proyecto_socio';

    protected $guarded = [];

    /**
     * The roles that belong to the CohorteProyectoSocio
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subactividades(): BelongsToMany
    {
        return $this->belongsToMany(Subactividad::class, 'cohorte_subactividad', 'cohorte_proyecto_socio_id', 'subactividad_id');
    }
}
