<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisPcjSostenibilidad extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'pais_pcj_sostenibilidades';

    protected $guarded = [];

    public function pcjSostenibilidad()
    {
        return $this->belongsTo(PcjSostenibilidad::class, 'pcj_sostenibilidad_id');
    }
}
