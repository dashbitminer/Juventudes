<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Wildside\Userstamps\Userstamps;

class PaisImpactoPotencial extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    

    protected $table = 'prea_pais_impacto_potenciales';


    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function pre_alianza(): BelongsToMany
    {
        return $this->belongsToMany(PreAlianza::class, 'prea_pais_impacto_potenciales', 'pais_impacto_potencial_id', 'pre_alianza_id');
    }
}
