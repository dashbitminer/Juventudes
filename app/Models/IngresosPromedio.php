<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Wildside\Userstamps\Userstamps;

class IngresosPromedio extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    use SluggableScopeHelpers;
    use Sluggable;

    protected $table = 'ingresos_promedios';

    protected $fillable = [
        'nombre',
        'slug',
        'comentario',
        'active_at',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nombre',
            ],
        ];
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function pais(): BelongsToMany
    {
        return $this->belongsToMany(Pais::class, 'pais_ingresos_promedios', 'ingresos_promedio_id', 'pais_id')
            ->withPivot('active_at')
            ->withTimestamps();
    }
}
