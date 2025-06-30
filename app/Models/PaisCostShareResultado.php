<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Wildside\Userstamps\Userstamps;

class PaisCostShareResultado extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    

    protected $table = 'pais_costshare_resultados';


    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function cost_shares(): BelongsToMany
    {
        return $this->belongsToMany(CostShare::class, 'cs_pais_costshare_resultados', 'pais_costshare_actividad_id', 'cost_share_id');
    }
}
