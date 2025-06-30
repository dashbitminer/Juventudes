<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisTipoRecurso extends Model
{
    use HasFactory;

    protected $table = 'pais_tipo_recurso';

    protected $guarded = [];

    public function tipoRecurso()
    {
        return $this->belongsTo(TipoRecurso::class, 'tipo_recurso_id');
    }
}
