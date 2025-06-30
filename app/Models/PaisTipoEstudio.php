<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisTipoEstudio extends Model
{
    use HasFactory;

    protected $table = 'pais_tipo_estudio';

    protected $guarded = [];

    public function tipoEstudio()
    {
        return $this->belongsTo(TipoEstudio::class, 'tipo_estudio_id');
    }
}
