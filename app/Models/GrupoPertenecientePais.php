<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrupoPertenecientePais extends Model
{
    use HasFactory;

    protected $table = 'grupo_perteneciente_pais';

    protected $guarded = [];

    public function grupoPerteneciente()
    {
        return $this->belongsTo(GrupoPerteneciente::class, 'grupo_perteneciente_id');
    }
}
