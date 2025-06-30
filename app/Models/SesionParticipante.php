<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SesionParticipante extends Model
{
    use HasFactory;

    protected $table = 'sesion_participantes';

    protected $fillable = [
        'sesion_id',
        'participante_id',
        'asistencia',
        'duracion',
    ];

    public function tracking(): HasMany
    {
        return $this->hasMany(SesionParticipanteTimeTracking::class, 'sesion_participante_id', 'id');
    }
}
