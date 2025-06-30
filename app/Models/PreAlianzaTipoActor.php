<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreAlianzaTipoActor  extends Model
{
    use HasFactory;

    protected $table = 'pre_alianza_tipo_actores';

    protected $guarded = [];

    public function preAlianza()
    {
        return $this->belongsTo(PreAlianza::class, 'pre_alianza_id');
    }
}
