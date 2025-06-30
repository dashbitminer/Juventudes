<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GrupoParticipante extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'grupo_participante';

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function estado()
    {
        return $this->belongsToMany(Estado::class, 'estado_participante', 'grupo_participante_id', 'estado_id')
            ->withPivot('comentario', 'active_at', 'razon_id', 'fecha')
            ->withTimestamps()
            ->wherePivotNull('deleted_at')
            ->orderBy('estado_participante.created_at', 'desc');
    }

    /**
     * Get the user that owns the GrupoParticipante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grupo(): BelongsTo
    {
        return $this->belongsTo(Grupo::class);
    }

    /**
     * Get the user that owns the GrupoParticipante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lastEstadoParticipante(): HasOne
    {
        return $this->hasOne(EstadoParticipante::class, 'grupo_participante_id')->latestOfMany();
    }

    public function estadosParticipantes(): HasMany
    {
        return $this->hasMany(EstadoParticipante::class);
    }

    /**
     * Get the cohorte participante proyecto that owns the GrupoParticipante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cohorteParticipanteProyecto(): BelongsTo
    {
        return $this->belongsTo(CohorteParticipanteProyecto::class);
    }

    /**
     * Get the user that owns the GrupoParticipante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
