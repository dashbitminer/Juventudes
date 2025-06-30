<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisRecursoPrevistoLeverage extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'pais_lev_recurso_previstos';

    protected $guarded = [];

    public function recursoPrevistoLeverage()
    {
        return $this->belongsTo(RecursoPrevistoLeverage::class, 'lev_recurso_previsto_id');
    }
}
