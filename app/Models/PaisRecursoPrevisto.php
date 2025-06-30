<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisRecursoPrevisto extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'pais_recurso_previstos';

    protected $guarded = [];

    public function recursoPrevisto()
    {
        return $this->belongsTo(RecursoPrevisto::class);
    }
}
