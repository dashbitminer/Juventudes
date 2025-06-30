<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrigenEmpresaPrivada extends Model
{
    use HasFactory;
    use SluggableScopeHelpers;
    use Sluggable;
    use SoftDeletes;
    use Userstamps;


    protected $table = 'origen_empresa_privadas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'comentario',
        'slug',
        'active_at',
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

    /**
     * The pais that belong to the TipoAlianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pais(): BelongsToMany
    {
        return $this->belongsToMany(Pais::class, 'pais_origen_empresa_privada')
            ->withPivot('active_at')
            ->withTimestamps();
    }
}
