<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScPoblacionBeneficiariaDirecta extends Model
{

    protected $table = 'sc_poblacion_directas';

    protected $fillable = [
        'pais_poblacion_beneficiada_id', 
        'servicio_comunitario_id',
    ];



    public function servicioComunitario()
    {
        return $this->belongsTo(ServicioComunitario::class, 'servicio_comunitario_id');
    }

    public function paisPoblacionBeneficiada()
    {
        return $this->belongsTo(PaisPoblacionBeneficiada::class, 'pais_poblacion_beneficiada_id');
    }


}
