<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Wildside\Userstamps\Userstamps;

class PcjSostenibilidad extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;
    use SluggableScopeHelpers;
    use Userstamps;

    protected $table = 'pcj_sostenibilidades';

    protected $fillable = [
        'nombre',
        'slug',
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

    public function paises(): BelongsToMany
    {
        return $this->belongsToMany(Pais::class, 'pais_pcj_sostenibilidades', 'pcj_sostenibilidad_id', 'pais_id');
    }
}
