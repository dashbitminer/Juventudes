<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisPropositoAlianza extends Model
{
    use HasFactory;

    protected $table = 'pais_proposito_alianza';

    protected $guarded = [];

    public function propositoAlianza()
    {
        return $this->belongsTo(PropositoAlianza::class, 'proposito_alianza_id');
    }
}
