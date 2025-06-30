<?php

namespace App\Models;

use Carbon\Carbon;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FichaFormacion extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'ficha_formaciones';

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function dateForHumans() {
        return Carbon::parse( $this->created_at)->format( 'M d, Y, g:i A' );
    }

    public function paisMedioVerficicacionFormacion()
    {
        return $this->belongsToMany(PaisMedioVerificacionFormacion::class, 'pais_verificacion_ficha_formacion', 'ficha_formacion_id', 'pais_medio_verificacion_formacion_id')->withPivot('active_at', 'medio_verificacion_file')
        ->withPivot(['medio_verificacion_file', 'active_at'])
        ->withTimestamps();
    }

    public function paisMedioVida()
    {
        return $this->belongsTo(PaisMedioVida::class, 'pais_medio_vida_id');
    }

    public function paisTipoEstudio()
    {
        return $this->belongsTo(PaisTipoEstudio::class, 'pais_tipo_estudio_id');
    }

    public function paisAreaFormacion()
    {
        return $this->belongsTo(PaisAreaFormacion::class, 'pais_area_formacion_id');
    }

    public function paisNivelEducativoFormacion()
    {
        return $this->belongsTo(PaisNivelEducativoFormacion::class, 'pais_nivel_educativo_formacion_id');
    }

    public function cohorteParticipanteProyecto()
    {
        return $this->belongsTo(CohorteParticipanteProyecto::class, 'cohorte_participante_proyecto_id');
    }

    public function directorio()
    {
        return $this->belongsTo(Directorio::class, 'directorio_id');
    }


    public function lastEstado()
    {
        return $this->hasOne(EstadoRegistroFichaFormacion::class, 'ficha_formacion_id')
            ->latestOfMany();
    }

    public function estados_registros(): BelongsToMany
    {
        return $this->belongsToMany(EstadoRegistro::class, 'estado_registro_ficha_formacion', 'ficha_formacion_id', 'estado_registro_id')
                        ->withTimestamps()
                        ->withPivot(['comentario', 'created_at', 'created_by']);
    }

}
