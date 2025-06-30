<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisPcjFortaleceArea extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'pais_pcj_fortalece_areas';

    protected $guarded = [];

    public function pcjFortaleceArea()
    {
        return $this->belongsTo(PcjFortaleceArea::class, 'pcj_fortalece_area_id');
    }
}
