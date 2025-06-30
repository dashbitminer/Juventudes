<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formulario extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;


    protected $table = 'formularios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function pais()
    {
        return $this->belongsToMany(Pais::class, 'formulario_pais', 'formulario_id', 'pais_id')
                    ->withPivot('active_at')
                    ->withTimestamps();
    }
}
