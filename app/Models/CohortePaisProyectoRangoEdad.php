<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CohortePaisProyectoRangoEdad extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'cohorte_pais_proyecto_rango_edad';

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }
}
