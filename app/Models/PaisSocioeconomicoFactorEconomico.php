<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Wildside\Userstamps\Userstamps;

class PaisSocioeconomicoFactorEconomico extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    

    protected $table = 'pais_factores_economicos';


    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function socioeconomico(): BelongsToMany
    {
        return $this->belongsToMany(Socioeconomico::class, 'socioeconomico_factores_economicos', 'pais_factores_economico_id', 'socioeconomico_id');
    }
}
