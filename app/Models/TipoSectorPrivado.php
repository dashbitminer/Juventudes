<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TipoSectorPrivado extends Model
{
    use HasFactory;
    use SluggableScopeHelpers;
    use Sluggable;
    use SoftDeletes;
    use Userstamps;

    const OTRO_TIPO_SECTOR_PRIVADO = 12;

    protected $table = 'tipo_sector_privados';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'comentario',
        'categoria_razon_id',
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
        return $this->belongsToMany(Pais::class, 'pais_tipo_sector_privado')
            ->withPivot('active_at')
            ->withTimestamps();
    }
}
