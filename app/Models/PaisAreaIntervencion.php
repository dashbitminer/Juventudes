<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisAreaIntervencion extends Model
{
    use HasFactory;

    protected $table = 'pais_area_intervenciones';

    public function areaIntervencion()
    {
        return $this->belongsTo(AreaIntervencion::class);
    }
}
