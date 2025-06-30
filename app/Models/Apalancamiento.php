<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Apalancamiento extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'apalancamientos';

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

    /**
     * The areascoberturas that belong to the Apalancamiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function areascoberturas(): BelongsToMany
    {
        return $this->belongsToMany(Departamento::class, 'apalancamiento_area_cobertura', 'apalancamiento_id', 'departamento_id');
    }

    /**
     * Get the latest estado associated with the Participante
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function lastEstado()
    {
        return $this->hasOne(EstadoRegistroApalancamiento::class, 'apalancamiento_id')
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

    public function paisTipoRecursoSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTipoRecurso::class, 'pais_tipo_recurso_id');
    }

    public function paisOrigenRecursoSelected(): BelongsTo
    {
        return $this->belongsTo(PaisOrigenRecurso::class, 'pais_origen_recurso_id');
    }

    public function paisFuenteRecursoSelected(): BelongsTo
    {
        return $this->belongsTo(PaisFuenteRecurso::class, 'pais_fuente_recurso_id');
    }

    /**
     * The roles that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function estados_registros(): BelongsToMany
    {
        return $this->belongsToMany(EstadoRegistro::class, 'estado_registro_apalancamiento', 'apalancamiento_id', 'estado_registro_id')
                        ->withTimestamps()
                        ->withPivot(['comentario', 'created_at', 'created_by']);
    }

    /**
     * Get the organizacionSelected that owns the Apalancamiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modalidadEstrategiaApalancamientoSelected(): BelongsTo
    {
        return $this->belongsTo(ModalidadEstrategiaAlianzaPais::class, 'modalidad_estrategia_alianza_pais_id');
    }

    /**
     * Get the PaisObjetivoAsistenciaAlianzaSelected that owns the Apalancamiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisObjetivoAsistenciaApalancamientoSelected(): BelongsTo
    {
        return $this->belongsTo(ObjetivoAsistenciaAlianzaPais::class, 'objetivo_asistencia_alianza_pais_id');
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

    public function registrador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gestor_id', 'id');
    }

    
}