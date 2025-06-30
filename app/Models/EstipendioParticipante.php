<?php

namespace App\Models;

use App\Models\Estipendio;
use App\Models\Participante;
use App\Models\CohortePaisProyecto;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstipendioParticipante extends Model
{

    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'estipendio_participantes';

    protected $guarded = [];

    public function estipendio()
    {
        return $this->belongsTo(Estipendio::class);
    }

    public function participante()
    {
        return $this->belongsTo(Participante::class);
    }

    // public function cohortePaisProyecto()
    // {
    //     return $this->belongsTo(CohortePaisProyecto::class);
    // }
}
