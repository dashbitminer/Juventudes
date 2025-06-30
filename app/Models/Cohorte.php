<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Cohorte extends Model
{
    use HasFactory;
    use SluggableScopeHelpers;
    use Sluggable;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'cohortes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        // 'fecha_inicio',
        // 'fecha_fin',
        'slug',
        'active_at',
       // 'pais_proyecto_id',
        // 'rol',
        // 'comentario',
        // 'comparar_fecha_nacimiento',
    ];

    // public $cast = [
    //     'comparar_fecha_nacimiento' => 'date',
    // ];

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


    /**
     * The roles that belong to the Cohorte
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function socioImplementador(): BelongsToMany
    {
        return $this->belongsToMany(SocioImplementador::class, 'cohorte_socio_users', 'cohorte_id', 'socios_implementador_id');
    }



    /**
     * Get the proyecto that owns the Cohorte
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisProyecto(): BelongsTo
    {
        return $this->belongsTo(PaisProyecto::class, 'pais_proyecto_id');
    }

    public function tituloSesion(): MorphOne
    {
        return $this->morphOne(SesionTitulo::class, 'titleable');
    }
}
