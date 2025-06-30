<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisTipoSector extends Model
{
    use HasFactory;

    protected $table = 'pais_tipo_sector';

    protected $guarded = [];

    public function tipoSector()
    {
        return $this->belongsTo(TipoSector::class, 'tipo_sector_id');
    }

    public function costShares()
    {
        return $this->hasMany(CostShare::class, 'pais_tipo_sector_id');
    }
}
