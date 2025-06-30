<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PaisProyecto extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'pais_proyecto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pais_id',
        'proyecto_id',
        'active_at',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    /**
     * The roles that belong to the PaisProyecto
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function socioImplementador(): BelongsToMany
    {
        return $this->belongsToMany(SocioImplementador::class, 'pais_proyecto_socios', 'pais_proyecto_id', 'socio_implementador_id');
    }

    /**
     * Get the pais that owns the PaisProyecto
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }
    /**
     * Get the proyecto that owns the PaisProyecto
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }


}
