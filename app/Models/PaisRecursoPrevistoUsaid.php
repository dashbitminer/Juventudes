<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisRecursoPrevistoUsaid extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'pais_usaid_recurso_previstos';

    protected $guarded = [];

    public function recursoPrevistoUsaid()
    {
        return $this->belongsTo(RecursoPrevistoUsaid::class, 'usaid_recurso_previsto_id');
    }
}
