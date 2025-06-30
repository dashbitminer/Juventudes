<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Wildside\Userstamps\Userstamps;

class PaisInclusionSocialTema extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    

    protected $table = 'pais_inclusion_social_temas';


    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function aprendizaje_servicio(): BelongsToMany
    {
        return $this->belongsToMany(AprendizajeServicio::class, 'as_inclusion_social_temas', 'pais_inclusion_social_tema_id', 'aprendizaje_servicio_id');
    }
}
