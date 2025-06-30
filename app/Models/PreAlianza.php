<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PreAlianza extends Model
{
    use HasFactory;
    use SluggableScopeHelpers;
    use SoftDeletes;
    use Userstamps;
    use Sluggable;

    const ESTADO_ATRASADO = 1;
    const ESTADO_CIERTO_ATRASO = 2;
    const ESTADO_EN_TIEMPO = 3;

    protected $table = 'pre_alianzas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
                'source' => 'nombre_organizacion',
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
     * Get the socioImplementador that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function socioImplementador(): BelongsTo
    {
        return $this->belongsTo(SocioImplementador::class, 'socio_implementador_id', 'id');
    }


     /**
     * The areascoberturas that belong to the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function areascoberturas(): BelongsToMany
    {
        return $this->belongsToMany(Departamento::class, 'prealianza_area_cobertura', 'prealianza_id', 'departamento_id');
    }

     /**
     * The areascoberturas that belong to the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coberturanacional(): BelongsToMany
    {
        return $this->belongsToMany(Departamento::class, 'cobertura_nacional_prealianza', 'prealianza_id', 'departamento_id');
    }



    /**
     * Get the user that owns the PreAlianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoSector(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSector::class, 'pais_tipo_sector_id');
    }

    /**
     * Get the user that owns the PreAlianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoSectorPublico(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSectorPublico::class, 'pais_tipo_sector_publico_id');
    }

    public function tipoSectorPrivado(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSectorPrivado::class, 'pais_tipo_sector_privado_id');
    }

    public function tamanoEmpresaPrivada(): BelongsTo
    {
        return $this->belongsTo(PaisTamanoEmpresaPrivada::class, 'pais_tamano_empresa_privada_id');
    }

    public function origenEmpresaPrivada(): BelongsTo
    {
        return $this->belongsTo(PaisOrigenEmpresaPrivada::class, 'pais_origen_empresa_privada_id');
    }

    public function tipoSectorComunitaria(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSectorComunitaria::class, 'pais_tipo_sector_comunitaria_id');
    }

    public function tipoSectorAcademica(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSectorAcademica::class, 'pais_tipo_sector_academica_id');
    }

    public function tipoAlianza(): BelongsTo
    {
        return $this->belongsTo(PaisTipoAlianza::class, 'pais_tipo_alianza_id');
    }

    public function coberturaGeografica(): BelongsTo
    {
        return $this->belongsTo(PaisCoberturaGeografica::class, 'pais_cobertura_geografica_id');
    }

    /**
     * Get all of the comments for the PreAlianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actualizacionPrealianza(): HasMany
    {
        return $this->hasMany(ActualizacionPrealianza::class, 'prealianza_id');
    }

    /**
     * Get the most recent actualizacionPrealianza for the PreAlianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastActualizacionPrealianza(): HasOne
    {
        return $this->hasOne(ActualizacionPrealianza::class, 'prealianza_id', 'id')->latestOfMany();
    }

    public function impactoPotencial(): BelongsToMany
    {
        return $this->belongsToMany(PaisCostShareCategoria::class, 'prea_pais_impacto_potenciales', 'pre_alianza_id', 'pais_impacto_potencial_id');
    }

    public function tipoActores()
    {
        return $this->hasMany(PreAlianzaTipoActor::class, 'pre_alianza_id');
    }
}
