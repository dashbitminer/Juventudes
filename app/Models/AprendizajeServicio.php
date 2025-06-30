<?php

namespace App\Models;

use Carbon\Carbon;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AprendizajeServicio extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;


    protected $table = 'aprendizaje_servicios';

    protected $casts = [
        'fecha_inicio_prevista' => 'date',
        'fecha_fin_prevista' => 'date',
        'fecha_fin_cambio' => 'date',
        'fecha_inicio_cambio' => 'date',
    ];

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function dateForHumans() {
        return Carbon::parse( $this->created_at)->format( 'M d, Y, g:i A' );
    }

    public function paisServicioDesarrollar()
    {
        return $this->belongsToMany(PaisServicioDesarrollar::class, 'pais_servicio_desarrollar_aprendizaje', 'aprendizaje_servicio_id', 'pais_servicio_desarrollar_id')
        ->withPivot('id', 'descripcion_otros_servicios_desarrollar')
        ->withTimestamps();
    }

    public function paisHabilidadesAdquirir()
    {
        return $this->belongsToMany(PaisHabilidadAdquirir::class, 'pais_habilidad_adquirir_aprendizaje', 'aprendizaje_servicio_id', 'pais_habilidad_adquirir_id')
        ->withPivot('id', 'descripcion_otras_habilidades')
        ->withTimestamps();
    }


    public function directorio()
    {
        return $this->belongsTo(Directorio::class, 'directorio_id');
    }

    public function paisMotivoCambioOrganizacion()
    {
        return $this->belongsTo(PaisMotivoCambioOrganizacion::class, 'pais_motivo_cambio_organizacion_id');
    }

    public function cohorteParticipanteProyecto()
    {
        return $this->belongsTo(CohorteParticipanteProyecto::class, 'cohorte_participante_proyecto_id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function inclusionSocialTema(): BelongsToMany
    {
        return $this->belongsToMany(PaisInclusionSocialTema::class, 'as_inclusion_social_temas', 'aprendizaje_servicio_id', 'pais_inclusion_social_tema_id');
    }

    public function medioambienteTema(): BelongsToMany
    {
        return $this->belongsToMany(PaisMedioAmbienteTema::class, 'as_medioambiente_temas', 'aprendizaje_servicio_id', 'pais_medioambiente_tema_id');
    }

    public function culturaTema(): BelongsToMany
    {
        return $this->belongsToMany(PaisCulturaTema::class, 'as_cultura_temas', 'aprendizaje_servicio_id', 'pais_cultura_tema_id');
    }


    public function lastEstado()
    {
        return $this->hasOne(EstadoRegistroAprendizajeServicio::class, 'aprendizaje_servicio_id')
            ->latestOfMany();
    }

    public function estados_registros(): BelongsToMany
    {
        return $this->belongsToMany(EstadoRegistro::class, 'estado_registro_aservicio', 'aprendizaje_servicio_id', 'estado_registro_id')
                        ->withTimestamps()
                        ->withPivot(['comentario', 'created_at', 'created_by']);
    }

}
