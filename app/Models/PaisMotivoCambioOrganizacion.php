<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisMotivoCambioOrganizacion extends Model
{
    use HasFactory;

    protected $table = 'pais_motivo_cambio_organizacion';

    protected $guarded = [];

    public function motivoCambioOrganizacion()
    {
        return $this->belongsTo(MotivosCambioOrganizacion::class, 'motivo_cambio_organizacion_id');
    }
}
