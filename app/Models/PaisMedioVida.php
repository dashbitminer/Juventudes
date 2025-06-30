<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisMedioVida extends Model
{
    use HasFactory;

    protected $table = 'pais_medio_vidas';

    protected $guarded = [];


    public function medioVida()
    {
        return $this->belongsTo(MedioVida::class, 'medio_vida_id');
    }
}
