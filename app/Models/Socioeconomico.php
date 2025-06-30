<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Socioeconomico extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = "socioeconomicos";

    protected $fillable = [
        'participante_id',
        'miembros_familia_vives',
        'cuartos_en_hogar',
        'cuartos_como_dormitorios',
        'focos_electricos_hogar',
        'participante_migrado_retornado',
        'participante_miembro_hogar_migrado',
        'hogar_personas_condiciones_trabajar',
        'trabajan_con_ingresos_fijos',
        'contratadas_permanentemente',
        'contratadas_temporalmente',
        'sentido_inseguro_en_comunidad',
        'victima_violencia',
        'conocido_violencia_genero',
        'espacios_seguros_para_victimas',
        'participas_proyecto_recibir_bonos',
        'proyecto_ong_bonos',
        'familiar_participa_proyecto_recibir_bonos',
        'familiar_proyecto_ong_bonos',
        'informacion_relevante',
        'readonly_at',
        'readonly_by',
        'pdf',
        'factor_persoc_otro'
    ];


    public function personaVive(): BelongsToMany
    {
        return $this->belongsToMany(PersonaVive::class, 'socioeconomico_persona_vive', 'socioeconomico_id', 'persona_vive_id')
            ->withPivot('otro');
    }

    public function fuenteIngreso(): BelongsToMany
    {
        return $this->belongsToMany(FuenteIngreso::class, 'fuente_ingreso_socioeconomico', 'socioeconomico_id', 'fuente_ingreso_id')
            ->withPivot('otro');
    }

    public function casaDispositivo(): BelongsToMany
    {
        return $this->belongsToMany(CasaDispositivo::class, 'casa_dispositivo_socioeconomico', 'socioeconomico_id', 'casa_dispositivo_id');
    }

    public function dineroSuficienteTabla()
    {
        return $this->hasMany(DineroSuficienteTabla::class, 'socioeconomico_id');
    }

    public function factorEconomico(): BelongsToMany
    {
        return $this->belongsToMany(PaisSocioeconomicoFactorEconomico::class, 'socioeconomico_factores_economicos', 'socioeconomico_id', 'pais_factores_economico_id');
    }

    public function factorSalud(): BelongsToMany
    {
        return $this->belongsToMany(PaisSocioeconomicoFactorSalud::class, 'socioeconomico_factores_saludes', 'socioeconomico_id', 'pais_factores_salud_id');
    }

    public function factorPersoc(): BelongsToMany
    {
        return $this->belongsToMany(PaisSocioeconomicoFactorPersoc::class, 'socioeconomico_factores_persocs', 'socioeconomico_id', 'pais_factores_persoc_id');
    }

    public function updatedDateForHumans() {

        $fecha = Carbon::createFromFormat( 'Y-m-d H:i:s',$this->updated_at ,'UTC');
        return Carbon::parse( $fecha ,'America/Guatemala')->format( 'M d, Y, g:i A' );
    }

}
