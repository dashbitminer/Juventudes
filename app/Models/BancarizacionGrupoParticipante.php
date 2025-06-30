<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BancarizacionGrupoParticipante extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'bancarizacion_grupo_participantes';

    protected $fillable = [
        'bancarizacion_grupo_id',
        'participante_id',
        'active_at',
    ];

    public function bancarizacionGrupo()
    {
        return $this->belongsTo(BancarizacionGrupo::class);
    }

    public function participante()
    {
        return $this->belongsTo(Participante::class, 'participante_id');
    }
}
