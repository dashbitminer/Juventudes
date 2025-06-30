<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisOrigenEmpresaPrivada extends Model
{
    use HasFactory;

    protected $table = 'pais_origen_empresa_privada';

    protected $guarded = [];

    public function origenEmpresaPrivada()
    {
        return $this->belongsTo(OrigenEmpresaPrivada::class, 'origen_empresa_privada_id');
    }

}
