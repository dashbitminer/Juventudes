<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocioImplementadorUser extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    public $table = 'socio_implementador_user';

    protected $guarded = [];

    public function socioImplementador()
    {
        return $this->belongsTo(SocioImplementador::class, 'socio_implementador_id');
    }

}
