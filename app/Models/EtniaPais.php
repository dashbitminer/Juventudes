<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EtniaPais extends Model
{
    use HasFactory;

    protected $table = 'etnia_pais';

    protected $guarded = [];

    public function etnia()
    {
        return $this->belongsTo(Etnia::class, 'etnia_id');
    }
}
