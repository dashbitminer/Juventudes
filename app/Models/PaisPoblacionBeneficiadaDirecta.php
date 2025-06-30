<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Wildside\Userstamps\Userstamps;

class PaisPoblacionBeneficiadaDirecta extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    

    protected $table = 'pais_poblacion_beneficiadas';


    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function servicio_comuntario(): BelongsToMany
    {
        return $this->belongsToMany(ServicioComunitario::class, 'sc_poblacion_directas', 'pais_poblacion_beneficiada_id', 'servicio_comunitario_id');
    }

}
