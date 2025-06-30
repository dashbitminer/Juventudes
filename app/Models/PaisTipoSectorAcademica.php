<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisTipoSectorAcademica extends Model
{
    use HasFactory;

    protected $table = 'pais_tipo_sector_academica';

    protected $guarded = [];

    public function tipoSectorAcademica()
    {
        return $this->belongsTo(TipoSectorAcademica::class, 'tipo_sector_academica_id');
    }
}
