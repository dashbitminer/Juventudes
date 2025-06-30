<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EstadoRegistro extends Model
{
    use HasFactory;
    use SluggableScopeHelpers;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'estado_registros';

    const DOCUMENTACION_PENDIENTE = 1;
    const PENDIENTE_REVISION = 2;
    const OBSERVADO = 3;
    const VALIDADO = 4;
    const RECHAZADO = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'slug',
        'active_at',
        'icon',
        'color',
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
     * The roles that belong to the Estado
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function participantes(): BelongsToMany
    {
        return $this->belongsToMany(Participante::class, 'estado_participante', 'estado_id', 'participante_id')->withTimestamps();
    }


    /**
     * Get the latest estado associated with the Participante
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function lastEstado()
    {
        //return $this->estados()->orderBy('pivot_created_at', 'desc')->first();
        return $this->hasOne(EstadoParticipante::class)->latestOfMany();
    }





}
