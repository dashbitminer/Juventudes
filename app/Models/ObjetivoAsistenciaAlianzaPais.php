<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ObjetivoAsistenciaAlianzaPais extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'objetivo_asistencia_alianza_pais';

    protected $guarded = [];

    public function objetivoAsistenciaAlianza()
    {
        return $this->belongsTo(ObjetivoAsistenciaAlianza::class, 'objetivo_asistencia_alianza_id');
    }
}
