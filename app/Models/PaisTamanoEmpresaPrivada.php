<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisTamanoEmpresaPrivada extends Model
{
    use HasFactory;

    protected $table = 'pais_tamano_empresa_privada';

    protected $guaded = [];

    public function tamanoEmpresaPrivada()
    {
        return $this->belongsTo(TamanoEmpresaPrivada::class, 'tamano_empresa_privada_id');
    }
}
