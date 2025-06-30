<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisTipoSectorPublico extends Model
{
    use HasFactory;

    protected $table = 'pais_tipo_sector_publico';

    protected $guaded = [];

    public function tipoSectorPublico()
    {
        return $this->belongsTo(TipoSectorPublico::class, 'tipo_sector_publico_id');
    }
}
