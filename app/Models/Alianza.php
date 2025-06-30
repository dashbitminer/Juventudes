<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alianza extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'alianzas';

    protected $guarded = [];


    /**
     * The areascoberturas that belong to the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function areascoberturas(): BelongsToMany
    {
        return $this->belongsToMany(Departamento::class, 'alianza_area_cobertura', 'alianza_id', 'departamento_id');
    }

    /**
     * Get the user that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoAlianzaSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTipoAlianza::class, 'pais_tipo_alianza_id');
    }

    /**
     * Get the tipoSectorSelected that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoSectorSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSector::class, 'pais_tipo_sector_id');
    }

    /**
     * Get the propositoAlianzaSelected that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function propositoAlianzaSelected(): BelongsTo
    {
        return $this->belongsTo(PaisPropositoAlianza::class, 'pais_proposito_alianza_id');
    }

    /**
     * Get the organizacionAlianzaSelected that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modalidadEstrategiaAlianzaSelected(): BelongsTo
    {
        return $this->belongsTo(ModalidadEstrategiaAlianzaPais::class, 'modalidad_estrategia_alianza_pais_id');
    }

    /**
     * Get the PaisObjetivoAsistenciaAlianzaSelected that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisObjetivoAsistenciaAlianzaSelected(): BelongsTo
    {
        return $this->belongsTo(ObjetivoAsistenciaAlianzaPais::class, 'objetivo_asistencia_alianza_pais_id');
    }

    /**
     * Get the PaisTipoSectorPublicoSelected that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisTipoSectorPublicoSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSectorPublico::class, 'pais_tipo_sector_publico_id');
    }

    /**
     * Get the paisTipoSectorPrivadoSelected that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisTipoSectorPrivadoSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSectorPrivado::class, 'pais_tipo_sector_privado_id');
    }

    /**
     * Get the paisOrigenEmpresaPrivadaSelected that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisOrigenEmpresaPrivadaSelected(): BelongsTo
    {
        return $this->belongsTo(PaisOrigenEmpresaPrivada::class, 'pais_origen_empresa_privada_id');
    }

    /**
     * Get the paisOrigenEmpresaPublicaSelected that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisTamanoEmpresaPrivadaSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTamanoEmpresaPrivada::class, 'pais_tamano_empresa_privada_id');
    }

    /**
     * Get the paisTipoSectorComunitariaSelected that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisTipoSectorComunitariaSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSectorComunitaria::class, 'pais_tipo_sector_comunitaria_id');
    }

    /**
     * Get the paisTipoSectorAcademicaSelected that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paisTipoSectorAcademicaSelected(): BelongsTo
    {
        return $this->belongsTo(PaisTipoSectorAcademica::class, 'pais_tipo_sector_academica_id');
    }


    /**
     * Get the ciudad that owns the Alianza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    /**
     * Get the latest estado associated with the Participante
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function lastEstado()
    {
        return $this->hasOne(EstadoRegistroAlianza::class, 'alianza_id')->latestOfMany();
    }

    /**
     * The roles that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function estados_registros(): BelongsToMany
    {
        return $this->belongsToMany(EstadoRegistro::class, 'estado_registro_alianza', 'alianza_id', 'estado_registro_id')
                        ->withTimestamps()
                        ->withPivot(['comentario', 'created_at', 'created_by']);
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

    public function registrador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gestor_id', 'id');
    }

    public function getEstadoDisplayAttribute()
{
    if ($this->lastEstado->estado_registro->nombre === 'Documentación pendiente' && !empty($this->documento_respaldo)) {
        $estado = \App\Models\EstadoRegistro::find(2); // "Pendiente de revisión"
        return [
            'nombre' => $estado->nombre,
            'color' => $estado->color,
            'icon'  => $estado->icon,
        ];
    }

    return [
        'nombre' => $this->lastEstado->estado_registro->nombre,
        'color' => $this->lastEstado->estado_registro->color,
        'icon'  => $this->lastEstado->estado_registro->icon,
    ];
}



}
