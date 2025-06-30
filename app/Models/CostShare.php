<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class CostShare extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'cost_shares';

    protected $guarded = [];

        /**
     * Get the ciudad that owns the Apalancamiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function areascoberturas(): BelongsToMany
    {
        return $this->belongsToMany(Departamento::class, 'cost_share_area_cobertura', 'cost_share_id', 'departamento_id');
    }

    /**
     * Get the latest estado associated with the Participante
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function lastEstado()
    {
        return $this->hasOne(EstadoRegistroCostShare::class, 'cost_share_id')
            ->latestOfMany();
    }


    /**
     * Get the tipoSectorSelected that owns the Apalancamiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoSectorSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSector::class, 'pais_tipo_sector_id');
    }

     /**
     * Get the PaisTipoSectorPublicoSelected that owns the Apalancamiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisTipoSectorPublicoSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSectorPublico::class, 'pais_tipo_sector_publico_id');
    }

    /**
     * Get the paisTipoSectorPrivadoSelected that owns the Apalancamiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisTipoSectorPrivadoSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSectorPrivado::class, 'pais_tipo_sector_privado_id');
    }

    /**
     * Get the paisOrigenEmpresaPublicaSelected that owns the Apalancamiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisTamanoEmpresaPrivadaSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTamanoEmpresaPrivada::class, 'pais_tamano_empresa_privada_id');
    }

    /**
     * Get the paisTipoSectorComunitariaSelected that owns the Apalancamiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisTipoSectorComunitariaSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSectorComunitaria::class, 'pais_tipo_sector_comunitaria_id');
    }

    /**
     * Get the paisTipoSectorAcademicaSelected that owns the Apalancamiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisTipoSectorAcademicaSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSectorAcademica::class, 'pais_tipo_sector_academica_id');
    }

    /**
     * Get the paisOrigenEmpresaPrivadaSelected that owns the Apalancamiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisOrigenEmpresaPrivadaSelected(): BelongsTo
    {
        return $this->belongsTo(PaisOrigenEmpresaPrivada::class, 'pais_origen_empresa_privada_id');
    }

    /**
     * The roles that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function estados_registros(): BelongsToMany
    {
        return $this->belongsToMany(EstadoRegistro::class, 'estado_registro_cost_share', 'cost_share_id', 'estado_registro_id')
                        ->withTimestamps()
                        ->withPivot(['comentario', 'created_at', 'created_by']);
    }

    /**
     * Get the socioImplementador that owns the Apalancamiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function socioImplementador(): BelongsTo
    {
        return $this->belongsTo(SocioImplementador::class, 'socio_implementador_id', 'id');
    }

    /**
     * Get the latest estado associated with the paisOrganizacionAlianza
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function organizacionAlianza(): HasOneThrough
    {
        return $this->hasOneThrough(
            OrganizacionAlianza::class,
            PaisOrganizacionAlianza::class,
            'id', 
            'id', 
            'pais_organizacion_alianza_id', 
            'organizacion_alianza_id' 
        )->select([
            'organizacion_alianzas.id as organizacion_alianza_id',
            'organizacion_alianzas.nombre as organizacion_alianza_nombre',
            'pais_organizacion_alianza.id as pais_organizacion_alianza_id',
        ]);
    }

    public function categoria(): BelongsToMany
    {
        return $this->belongsToMany(PaisCostShareCategoria::class, 'cs_pais_costshare_categorias', 'cost_share_id', 'pais_costshare_categoria_id');
    }

    public function actividad(): BelongsToMany
    {
        return $this->belongsToMany(PaisCostShareActividad::class, 'cs_pais_costshare_actividades', 'cost_share_id', 'pais_costshare_actividad_id');
    }

    public function resultado(): BelongsToMany
    {
        return $this->belongsToMany(PaisCostShareResultado::class, 'cs_pais_costshare_resultados', 'cost_share_id', 'pais_costshare_resultado_id')
        ->withPivot('porcentaje');
    }

    public function registrador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gestor_id', 'id');
    }

    public function costshareCategorias(): BelongsToMany
    {
        return $this->belongsToMany(PaisCostShareCategoria::class, 'cs_pais_costshare_categorias', 'cost_share_id', 'pais_costshare_categoria_id')
            ->join('costshare_categorias as cc', 'pais_costshare_categorias.costshare_categoria_id', '=', 'cc.id')
            ->select('cc.*');
    }  
    
    public function costshareActividades(): BelongsToMany
    {
        return $this->belongsToMany(PaisCostShareActividad::class, 'cs_pais_costshare_actividades', 'cost_share_id', 'pais_costshare_actividad_id')
            ->join('costshare_actividades as ca', 'pais_costshare_actividades.costshare_actividad_id', '=', 'ca.id')
            ->select('ca.*');
    } 

    public function paisCostShareValoracion()
    {
        return $this->belongsTo(PaisCostShareValoracion::class, 'pais_costshare_valoracion_id');
    }

}