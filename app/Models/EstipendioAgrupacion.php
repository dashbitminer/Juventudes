<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstipendioAgrupacion extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'estipendio_agrupaciones';

    protected $guarded = [];

    public function agrupacionParticipantes(): HasMany
    {
        return $this->hasMany(EstipendioAgrupacionParticipante::class);
    }
}
