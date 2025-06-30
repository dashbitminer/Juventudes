<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaisOrganizacionAlianza extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'pais_organizacion_alianza';

    protected $guarded = [];

    public function organizacionAlianza()
    {
        return $this->belongsTo(OrganizacionAlianza::class, 'organizacion_alianza_id');
    }

}
