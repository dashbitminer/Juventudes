<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisPcjAlcance extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'pais_pcj_alcances';

    protected $guarded = [];

    public function pcjAlcance()
    {
        return $this->belongsTo(PcjAlcance::class, 'pcj_alcance_id');
    }
}
