<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BancarizacionGrupo extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    CONST GUATEMALA_LIMITE_FILAS = 100;

    CONST HONDURAS_LIMITE_FILAS = 100;


    protected $table = 'bancarizacion_grupos';

    protected $fillable = [
        'nombre',
        'cohorte_pais_proyecto_id',
        'descripcion',
        'monto',
        'active_at',
    ];

    public function cohortePaisProyecto()
    {
        return $this->belongsTo(CohortePaisProyecto::class);
    }

    public function participantes()
    {
        return $this->belongsToMany(Participante::class, 'bancarizacion_grupo_participantes', 'bancarizacion_grupo_id', 'participante_id')
            ->withPivot('active_at', 'id', 'deleted_at')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
