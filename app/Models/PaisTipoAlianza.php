<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisTipoAlianza extends Model
{
    use HasFactory;

    protected $table = 'pais_tipo_alianza';

    protected $guarded = [];

    public function tipoAlianza()
    {
        return $this->belongsTo(TipoAlianza::class, 'tipo_alianza_id');
    }
}
