<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PersonaVive extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    use SluggableScopeHelpers;
    use Sluggable;


    protected $table = 'persona_vives';

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


    /**
     * The socioeconomicos that belong to the PersonaVive
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function socioeconomicos(): BelongsToMany
    {
        return $this->belongsToMany(Socioeconomico::class, 'socioeconomico_persona_vive', 'persona_vive_id', 'socioeconomico_id');
    }

}
