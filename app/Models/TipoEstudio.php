<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TipoEstudio extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    use SluggableScopeHelpers;
    use Sluggable;

    const OTRO = 6;

    protected $table = 'tipo_estudios';


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
        return $this->belongsToMany(Pais::class, 'pais_tipo_estudio')
            ->withPivot('active_at')
            ->withTimestamps();
    }
}
