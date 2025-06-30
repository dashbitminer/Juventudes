<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ValidadorRegistrador extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'validador_registradores';

    protected $fillable = [
        'validador_id',
        'registrador_id',
        'pais_proyecto_id',
        'comentario',
        'active_at',
    ];
}
