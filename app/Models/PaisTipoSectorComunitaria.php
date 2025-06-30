<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisTipoSectorComunitaria extends Model
{
    use HasFactory;

    protected $table = 'pais_tipo_sector_comunitaria';

    protected $guaded = [];

    public function tipoSectorComunitaria()
    {
        return $this->belongsTo(TipoSectorComunitaria::class, 'tipo_sector_comunitaria_id');
    }
}
