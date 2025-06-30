<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Wildside\Userstamps\Userstamps;

class Sesion extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'sesiones';

    protected $fillable = [
        'cohorte_pais_proyecto_id',
        'cohorte_pais_proyecto_perfil_id',
        'user_id',
        'actividad_id',
        'subactividad_id',
        'modulo_id',
        'submodulo_id',
        'grupo_id',
        'modalidad',
        'fecha',
        'fecha_fin',
        'titulo_id',
        'titulo',
        'tipo',
        'hora',
        'minuto',
        'comentario',
        'modelable_id',
        'modelable_type',
        'active_at',
    ];

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function getTitulo(): HasOne
    {
        return $this->hasOne(Titulo::class, 'id', 'titulo_id');
    }

    public function creado(): string {
        return Carbon::parse( $this->created_at)
            ->format( 'M j, Y' );
    }

    public function formatFecha(): string {
        return Carbon::parse( $this->fecha)
            ->format( 'd/m/Y' );
    }

    public function formatFechaFin(): string {
        return Carbon::parse( $this->fecha_fin)
            ->format( 'd/m/Y' );
    }

    public function formatDuracion(): int {
        return intval($this->duracion);
    }

    public function sesionParticipantesAsistencia(): HasMany
    {
        return $this->hasMany(SesionParticipante::class, 'sesion_id')
            ->where('asistencia', 1);
    }

    public function sesionParticipantes(): HasMany
    {
        return $this->hasMany(SesionParticipante::class, 'sesion_id');
    }

    public function modelable(): MorphTo
    {
        return $this->morphTo();
    }

    public function actividad(): BelongsTo
    {
        return $this->belongsTo(Actividad::class);
    }

    public function subactividad(): BelongsTo
    {
        return $this->belongsTo(Subactividad::class);
    }

    public function modulo(): BelongsTo
    {
        return $this->belongsTo(Modulo::class);
    }

    public function submodulo(): BelongsTo
    {
        return $this->belongsTo(Submodulo::class);
    }

    public function cohortePaisProyecto(): BelongsTo
    {
        return $this->belongsTo(CohortePaisProyecto::class, 'cohorte_pais_proyecto_id');
    }

    public function cohortePaisProyectoPerfil(): BelongsTo
    {
        return $this->belongsTo(CohortePaisProyectoPerfil::class, 'cohorte_pais_proyecto_perfil_id');
    }
}
