<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class EstadoRegistroParticipante extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'estado_registro_participante';

    protected $guarded = [];


    /**
     * Get the user that owns the EstadoParticipante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado_registro(): BelongsTo
    {
        return $this->belongsTo(EstadoRegistro::class, 'estado_registro_id');
    }

    /**
     * Get the user by created_by column
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coordinador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function creadoPor(): string
    {
        return Carbon::parse($this->created_at)
            ->format( 'M d, Y, g:i A' );
    }
}
