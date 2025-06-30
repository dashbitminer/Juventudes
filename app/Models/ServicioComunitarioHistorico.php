<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use App\Livewire\Resultadocuatro\Gestor\ServicioComunitario\Enum\Estados;

class ServicioComunitarioHistorico extends Model
{
    use HasFactory;
    use Userstamps;

    protected $table = 'sc_historiales';

    protected $fillable = [
        'servicio_comunitario_id',
        'estado',
        'comentario'
    ];


    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function dateForHumans() {
        return Carbon::parse( $this->created_at)->format( 'M d, Y, g:i A' );

    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
