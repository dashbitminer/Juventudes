<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoordinadorGestor extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'coordinador_gestores';

    protected $fillable = [
        'coordinador_id',
        'gestor_id',
        'cohorte_pais_proyecto_id',
        'comentario',
        'active_at',
    ];
}
