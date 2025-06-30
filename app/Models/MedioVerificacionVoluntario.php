<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MedioVerificacionVoluntario extends Model
{
    use HasFactory;
    use SluggableScopeHelpers;
    use SoftDeletes;
    use Userstamps;
    use Sluggable;


    protected $table = 'medio_verificacion_voluntarios';

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
        return $this->belongsToMany(Pais::class, 'pais_medio_verificacion_voluntario', 'medio_verificacion_voluntario_id', 'pais_id')
            ->withPivot('active_at')
            ->withTimestamps();
    }

}
