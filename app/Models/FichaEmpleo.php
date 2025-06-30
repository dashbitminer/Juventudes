<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Wildside\Userstamps\Userstamps;
use Carbon\Carbon;

class FichaEmpleo extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'ficha_empleos';

    protected $fillable = [
        'cohorte_participante_proyecto_id',
        'medio_vida_id',
        'directorio_id',
        'sector_empresa_organizacion_id',
        'tipo_empleo_id',
        'cargo',
        'salario_id',
        'habilidades',
        'medio_verificacion_id',
        'medio_verificacion_otros',
        'informacion_adicional',
        'gestor_id',
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

    public function mediosVida(): BelongsTo
    {
        return $this->belongsTo(MedioVida::class, 'medio_vida_id');
    }

    public function directorios(): BelongsTo
    {
        return $this->belongsTo(Directorio::class, 'directorio_id');
    }

    public function directorio(): BelongsTo
    {
        return $this->belongsTo(Directorio::class, 'directorio_id');
    }

    public function cohorteParticipanteProyecto()
    {
        return $this->belongsTo(CohorteParticipanteProyecto::class, 'cohorte_participante_proyecto_id');
    }

    public function sectorEmpresaOrganizacion(): BelongsTo
    {
        return $this->belongsTo(SectorEmpresaOrganizacion::class, 'sector_empresa_organizacion_id');
    }

    public function tipoEmpleo(): BelongsTo
    {
        return $this->belongsTo(TipoEmpleo::class, 'tipo_empleo_id');
    }

    public function salario(): BelongsTo
    {
        return $this->belongsTo(Salario::class, 'salario_id');
    }

    public function mediosVerificacion(): BelongsToMany
    {
        return $this->belongsToMany(
            MedioVerificacion::class,
            'medio_verificacion_archivos',
            'ficha_empleo_id',
            'medio_verificacion_id'
        )
        ->withPivot(['documento','active_at'])
        ->withTimestamps();
    }

    public function lastEstado()
    {
        return $this->hasOne(EstadoRegistroFichaEmpleo::class, 'ficha_empleo_id')
            ->latestOfMany();
    }

    public function estados_registros(): BelongsToMany
    {
        return $this->belongsToMany(EstadoRegistro::class, 'estado_registro_ficha_empleo', 'ficha_empleo_id', 'estado_registro_id')
                        ->withTimestamps()
                        ->withPivot(['comentario', 'created_at', 'created_by']);
    }

}
