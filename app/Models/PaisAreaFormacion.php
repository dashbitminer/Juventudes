<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisAreaFormacion extends Model
{
    use HasFactory;

    protected $table = 'pais_area_formaciones';

    protected $guarded = [];

    public function areaFormacion()
    {
        return $this->belongsTo(AreaFormacion::class, 'area_formacion_id');
    }
}
