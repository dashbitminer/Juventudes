<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScParticipante extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'sc_participantes';

    protected $guarded = [];

}
