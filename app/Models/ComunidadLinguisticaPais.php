<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComunidadLinguisticaPais extends Model
{
    use HasFactory;

    protected $table = 'comunidad_linguistica_pais';

    protected $guarded = [];

    public function comunidadLinguistica()
    {
        return $this->belongsTo(ComunidadLinguistica::class, 'comunidad_linguistica_id');
    }
}
