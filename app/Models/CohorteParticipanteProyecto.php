<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CohorteParticipanteProyecto extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'cohorte_participante_proyecto';

    protected $guarded = [];

    public function participante()
    {
        return $this->belongsTo(Participante::class);
    }

    public function cohortePaisProyecto()
    {
        return $this->belongsTo(CohortePaisProyecto::class, 'cohorte_pais_proyecto_id');
    }

}
