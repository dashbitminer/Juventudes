<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComunidadEtnicaParticipante extends Model
{
    use HasFactory;

    protected $table = 'comunidad_etnica_participantes';

    protected $guarded = [];
}
