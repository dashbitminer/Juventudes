<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisFuenteRecurso extends Model
{
    use HasFactory;

    protected $table = 'pais_fuente_recurso';

    protected $guarded = [];

    public function fuenteRecurso()
    {
        return $this->belongsTo(FuenteRecurso::class, 'fuente_recurso_id');
    }
}
