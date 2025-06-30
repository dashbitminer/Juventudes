<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PracticaEmpleabilidad extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'practica_empleabilidad';

    protected $guarded = [];

    protected $casts = [
        'fecha_inicio_prevista' => 'date',
        'fecha_fin_prevista' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function dateForHumans() {
        return Carbon::parse( $this->created_at)->format( 'M d, Y, g:i A' );
    }

    public function paisServicioDesarrollar()
    {
        return $this->belongsToMany(PaisServicioDesarrollar::class, 'pais_servicio_desarrollar_empleabilidad', 'practica_empleo_id', 'pais_servicio_desarrollar_id')
        ->withPivot('id', 'descripcion_otros_servicios_desarrollar')
        ->withTimestamps();
    }

    public function paisHabilidadesAdquirir()
    {
        return $this->belongsToMany(PaisHabilidadAdquirir::class, 'pais_habilildad_adquirir_empleabilidad', 'practica_empleo_id', 'pais_habilidad_adquirir_id')
        ->withPivot('id', 'descripcion_otras_habilidades')
        ->withTimestamps();
    }

    public function paisMotivoCambioOrganizacion()
    {
        return $this->belongsTo(PaisMotivoCambioOrganizacion::class, 'pais_motivo_cambio_organizacion_id');
    }

    public function directorio()
    {
        return $this->belongsTo(Directorio::class, 'directorio_id');
    }

    public function cohorteParticipanteProyecto()
    {
        return $this->belongsTo(CohorteParticipanteProyecto::class, 'cohorte_participante_proyecto_id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function lastEstado()
    {
        return $this->hasOne(EstadoRegistroPracticaEmpleabilidad::class, 'practica_empleabilidad_id')
            ->latestOfMany();
    }

    public function estados_registros(): BelongsToMany
    {
        return $this->belongsToMany(EstadoRegistro::class, 'estado_registro_pempleabilidad', 'practica_empleabilidad_id', 'estado_registro_id')
                        ->withTimestamps()
                        ->withPivot(['comentario', 'created_at', 'created_by']);
    }


}
