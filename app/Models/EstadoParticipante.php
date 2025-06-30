<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class EstadoParticipante extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'estado_participante';

    protected $guarded = [];

    public function dateForHumans() {
        if ($this->fecha) {
            return Carbon::parse( $this->fecha)->format( 'M d, Y' );
        }
        else {
            return "";
        }
    }

    /**
     * Get the user that owns the EstadoParticipante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function razon(): BelongsTo
    {
        return $this->belongsTo(Razon::class, 'razon_id');
    }
}
