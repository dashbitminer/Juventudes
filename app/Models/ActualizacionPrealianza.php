<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActualizacionPrealianza extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'actualizacion_prealianzas';

    protected $guarded = [];
}
