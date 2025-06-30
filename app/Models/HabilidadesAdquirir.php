<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HabilidadesAdquirir extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    use SluggableScopeHelpers;
    use Sluggable;

    const OTRAS_HABILIDADES = 10;

    protected $table = 'habilidades_adquirir';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'slug',
        'comentario',
        'active_at',
    ];

    public $cast = [
        'active_at' => 'datetime',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
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

    public function paises()
    {
        return $this->belongsToMany(Pais::class, 'pais_habilidad_adquirir', 'habilidad_adquirir_id', 'pais_id');
    }
}
