<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalidadEstrategiaAlianzaPais extends Model
{
    use HasFactory;

    protected $table = 'modalidad_estrategia_alianza_pais';

    protected $guarded = [];

    public function modalidadEstrategiaAlianza()
    {
        return $this->belongsTo(ModalidadEstrategiaAlianza::class, 'modalidad_estrategia_alianza_id');
    }
}
