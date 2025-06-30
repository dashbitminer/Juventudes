<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisRecursoPrevistoCostShare extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'pais_cs_recurso_previstos';

    protected $guarded = [];

    public function recursoPrevistoCostShare()
    {
        return $this->belongsTo(RecursoPrevistoCostShare::class, 'cs_recurso_previsto_id');
    }
}
