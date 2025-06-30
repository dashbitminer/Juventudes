<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComunidadEtnica extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    use SluggableScopeHelpers;
    use Sluggable;


    protected $table = 'comunidad_etnicas';

    const NINGUNO = 34;
    const NO_SABE = 35;
    const PREFIERE_NO_CONTESTAR = 36;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'groupo_etnico_id',
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

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function grupoEtnico()
    {
        return $this->belongsTo(GrupoEtnico::class, 'grupo_etnico_id');
    }

}
