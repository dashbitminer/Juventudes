<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisVinculadoDebido extends Model
{
    use HasFactory;

    protected $table = 'pais_vinculado_debido';

    protected $guaded = [];

    public function vinculadoDebido()
    {
        return $this->belongsTo(VinculadoDebido::class);
    }
}
