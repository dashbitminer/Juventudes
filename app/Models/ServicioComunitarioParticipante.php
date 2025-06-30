<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ServicioComunitarioParticipante extends Model
{
    use HasFactory;
    use Userstamps;

    protected $table = 'sc_participantes';

    protected $fillable = [
        'participante_id',
        'grupo_participante_id',
        'servicio_comunitario_id',
    ];


    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

}
