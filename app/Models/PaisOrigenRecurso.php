<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisOrigenRecurso extends Model
{
    use HasFactory;

    protected $table = 'pais_origen_recurso';

    protected $guarded = [];

    public function origenRecurso()
    {
        return $this->belongsTo(OrigenRecurso::class, 'origen_recurso_id');
    }
}
