<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FichaVoluntario extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;


    protected $table = 'ficha_voluntarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'fecha_inicio_voluntariado' => 'date',
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
        return $this->belongsToMany(PaisServicioDesarrollar::class, 'pais_servicio_desarrollar_voluntario', 'ficha_voluntario_id', 'pais_servicio_desarrollar_id');
    }


    public function paisMedioVida()
    {
        return $this->belongsTo(PaisMedioVida::class, 'pais_medio_vida_id');
    }

    public function paisVinculadoDebido()
    {
        return $this->belongsTo(PaisVinculadoDebido::class, 'pais_vinculado_debido_id');
    }

    public function paisMedioVerificacionVoluntario()
    {
        return $this->belongsTo(PaisMedioVerificacionVoluntario::class, 'pais_medio_verificacion_voluntario_id');
    }

    public function paisAreaIntervencion()
    {
        return $this->belongsTo(PaisAreaIntervencion::class, 'pais_area_intervencion_id');
    }

    public function directorio()
    {
        return $this->belongsTo(Directorio::class, 'directorio_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cohorteParticipanteProyecto()
    {
        return $this->belongsTo(CohorteParticipanteProyecto::class, 'cohorte_participante_proyecto_id');
    }

    public function lastEstado()
    {
        return $this->hasOne(EstadoRegistroFichaVoluntariado::class, 'ficha_voluntario_id')
            ->latestOfMany();
    }

    public function estados_registros(): BelongsToMany
    {
        return $this->belongsToMany(EstadoRegistro::class, 'estado_registro_ficha_voluntario', 'ficha_voluntario_id', 'estado_registro_id')
                        ->withTimestamps()
                        ->withPivot(['comentario', 'created_at', 'created_by']);
    }


}
