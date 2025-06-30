<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DireccionHonduras extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;


    protected $table = 'direcciones_honduras';

    protected $guarded = [];

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }
}
