<?php

namespace App\Models;

use Carbon\Carbon;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstadoRegistroFichaEmpleo extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    const DOCUMENTACION_PENDIENTE = 1;

    const PENDIENTE_REVISION = 2;

    const OBSERVADO = 3;

    const VALIDADO = 4;

    const RECHAZADO = 5;

    protected $table = 'estado_registro_ficha_empleo';

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
