<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisTipoSectorPrivado extends Model
{
    use HasFactory;

    protected $table = 'pais_tipo_sector_privado';

    protected $guaded = [];

    public function tipoSectorPrivado()
    {
        return $this->belongsTo(TipoSectorPrivado::class, 'tipo_sector_privado_id');
    }
}
