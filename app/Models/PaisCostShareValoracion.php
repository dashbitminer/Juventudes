<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisCostShareValoracion  extends Model
{
    protected $table = 'pais_costshare_valoraciones'; // Nombre de la tabla

    public function costshareValoracion()
    {
        return $this->belongsTo(CostShareValoracion::class, 'costshare_valoracion_id');
    }

}
