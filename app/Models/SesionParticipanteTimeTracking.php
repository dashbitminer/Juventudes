<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionParticipanteTimeTracking extends Model
{
    use HasFactory;

    protected $table = 'sesion_participante_time_trackings';

    protected $fillable = [
        'sesion_participante_id',
        'fecha',
        'hora',
        'minuto',
    ];
}
