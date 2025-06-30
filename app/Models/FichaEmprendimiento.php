<?php

namespace App\Models;

use Carbon\Carbon;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FichaEmprendimiento extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'ficha_emprendimientos';

    protected $casts = [
        'fecha_inicio_emprendimiento' => 'date',
    ];

    protected $fillable = [
        'cohorte_participante_proyecto_id',
        'medio_vida_id',
        'nombre',
        'rubro_emprendimiento_id',
        'fecha_inicio_emprendimiento',
        'etapa_emprendimiento_id',
        'tiene_capital_semilla',
        'capital_semilla_id',
        'capital_semilla_otros',
        'monto_local',
        'monto_dolar',
        'tiene_red_emprendimiento',
        'red_empredimiento',
        'medio_verificacion_otros',
        'medio_verificacion_file',
        'informacion_adicional',
        'gestor_id',
        'comentario',
        'active_at',
    ];

    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function dateForHumans() {
        return Carbon::parse( $this->created_at)->format( 'M d, Y, g:i A' );
    }

    public function participante(): BelongsToMany
    {
        return $this->belongsToMany(
            Participante::class,
            'cohorte_participante_proyecto',
            'participante_id',
            'id'
        );
    }

    public function medioVerificacion(): BelongsToMany
    {
        return $this->belongsToMany(
            MedioVerificacionEmprendimiento::class,
            'emprendimiento_medio_verificaciones',
            'ficha_emprendimiento_id',
            'medio_verificacion_id'
        )
        ->withPivot('active_at', 'comentario')
        ->withTimestamps();
    }

    // public function mediosVida(): BelongsTo
    // {
    //     return $this->belongsTo(IngresosPromedio::class, 'ingresos_promedio_id');
    // }

    public function mediosVida(): BelongsTo
    {
        return $this->belongsTo(MedioVida::class, 'medio_vida_id');
    }

    public function directorio()
    {
        return $this->belongsTo(Directorio::class, 'directorio_id');
    }

    public function cohorteParticipanteProyecto()
    {
        return $this->belongsTo(CohorteParticipanteProyecto::class, 'cohorte_participante_proyecto_id');
    }

    public function rubroEmprendimiento()
    {
        return $this->belongsTo(RubroEmprendimiento::class, 'rubro_emprendimiento_id');
    }

    public function etapaEmprendimiento(): BelongsTo
    {
        return $this->belongsTo(EtapaEmprendimiento::class, 'etapa_emprendimiento_id');
    }

    public function capitalSemilla(): BelongsTo
    {
        return $this->belongsTo(CapitalSemilla::class, 'capital_semilla_id');
    }

    public function ingresosPromedio(): BelongsTo
    {
        return $this->belongsTo(IngresosPromedio::class, 'ingresos_promedio_id');
    }

    public function lastEstado()
    {
        return $this->hasOne(EstadoRegistroFichaEmprendimiento::class, 'ficha_emprendimiento_id')
            ->latestOfMany();
    }

    public function estados_registros(): BelongsToMany
    {
        return $this->belongsToMany(EstadoRegistro::class, 'estado_registro_femprendimiento', 'ficha_emprendimiento_id', 'estado_registro_id')
                        ->withTimestamps()
                        ->withPivot(['comentario', 'created_at', 'created_by']);
    }
}
