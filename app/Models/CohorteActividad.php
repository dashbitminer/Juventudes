<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CohorteActividad extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'cohorte_actividades';

    protected $guarded = [];

    public function actividades(): BelongsToMany
    {
        return $this->belongsToMany(Actividad::class);
    }

    public function cohorteSubactividad(): HasMany
    {
        return $this->hasMany(CohorteSubactividad::class, 'cohorte_actividad_id');
    }
}
