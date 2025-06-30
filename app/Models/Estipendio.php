<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estipendio extends Model
{

    use HasFactory;
    use SoftDeletes;
    use Userstamps;


    protected $table = 'estipendios';

    protected $guarded = [];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function socioImplementador()
    {
        return $this->belongsTo(SocioImplementador::class, 'socio_implementador_id');
    }

    public function perfilParticipante()
    {
        return $this->belongsTo(PerfilesParticipante::class, 'perfil_participante_id');
    }


    public function participantes()
    {
        return $this->belongsToMany(Participante::class, 'estipendio_participantes', 'estipendio_id', 'participante_id');
    }

    // public function participante()
    // {
    //     return $this->belongsTo(Participante::class);
    // }

    // public function cohorteParticipanteProyecto()
    // {
    //     return $this->belongsTo(CohorteParticipanteProyecto::class, 'cohorte_participante_proyecto_id');
    // }

    // public function agrupacion()
    // {
    //     return $this->belongsTo(Agrupacion::class);
    // }
}
