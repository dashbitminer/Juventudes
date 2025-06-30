<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DineroSuficienteTabla extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;


    protected $table = 'dinero_suficiente_tablas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dinero_suficiente_pregunta_id',
        'dinero_suficiente_opcion_id',
        'socioeconomico_id',
    ];

    public function dineroSuficienteOpcion()
    {
        return $this->belongsTo(DineroSuficienteOpcion::class, 'dinero_suficiente_opcion_id');
    }

    public function dineroSuficientePregunta()
    {
        return $this->belongsTo(DineroSuficientePregunta::class, 'dinero_suficiente_pregunta_id');
    }

    public function socioeconomico()
    {
        return $this->belongsTo(Socioeconomico::class, 'socioeconomico_id');
    }
}
