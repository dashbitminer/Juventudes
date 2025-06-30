<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CohortePaisProyectoPerfil extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'cohorte_pais_proyecto_perfil';

    protected $guarded = [];

    public function perfilesParticipante()
    {
        return $this->belongsTo(PerfilesParticipante::class, 'perfil_participante_id');
    }
}
