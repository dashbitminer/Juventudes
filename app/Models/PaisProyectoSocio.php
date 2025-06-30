<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisProyectoSocio extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    public $table = 'pais_proyecto_socios';

    protected $fillable = [
        'pais_proyecto_id',
        'socio_implementador_id',
        'modalidad_id'
    ];

    /**
     * Get the modalidad that owns the PaisProyectoSocio
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modalidad(): BelongsTo
    {
        return $this->belongsTo(Modalidad::class, 'modalidad_id');
    }

}
