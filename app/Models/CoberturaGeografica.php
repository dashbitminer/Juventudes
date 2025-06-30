<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CoberturaGeografica extends Model
{
    use HasFactory;
    use SluggableScopeHelpers;
    use SoftDeletes;
    use Userstamps;
    use Sluggable;

    const NACIONAL = 1;
    const INTERNACIONAL = 2;
    const NACIONAL_INTERNACIONAL = 3;
    const NO_DEFINIDO = 4;


    protected $table = 'cobertura_geograficas';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
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
        return $this->belongsToMany(Pais::class, 'pais_cobertura_geografica', 'cobertura_geografica_id', 'pais_id')
            ->withPivot('active_at')
            ->withTimestamps();
    }
}
