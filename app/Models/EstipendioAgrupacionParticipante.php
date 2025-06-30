<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstipendioAgrupacionParticipante extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'estipendios_agrupaciones_participantes';

    protected $guarded = [];

    public function estipendioAgrupacion(): BelongsTo
    {
        return $this->belongsTo(EstipendioAgrupacion::class, 'estipendio_agrupacion_id');
    }
}
