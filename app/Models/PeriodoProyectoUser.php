<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodoProyectoUser extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'periodo_proyecto_user';

    protected $guarded = [];

    // public function cohortePaisProyecto()
    // {
    //     return $this->belongsTo(CohortePaisProyecto::class);
    // }
}
