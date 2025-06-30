<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Wildside\Userstamps\Userstamps;

class ServicioComunitario extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'servicio_comunitarios';

    protected $guarded = [];

    protected $casts = [
        'fecha_entrega' => 'date',
        'fecha_elaboracion' => 'date',
        'fecha_valida' => 'date',
    ];


    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function cohortePaisProyecto(): BelongsTo
    {
        return $this->belongsTo(CohortePaisProyecto::class, 'cohorte_pais_proyecto_id');
    }

    public function socioImplementador(): BelongsTo
    {
        return $this->belongsTo(SocioImplementador::class, 'socio_implementador_id');
    }

    public function paisRecursoPrevisto(): BelongsTo
    {
        return $this->belongsTo(PaisRecursoPrevisto::class, 'pais_recurso_previsto_id');
    }

    public function paisRecursoPrevistoLeverage(): BelongsTo
    {
        return $this->belongsTo(PaisRecursoPrevistoLeverage::class, 'pais_lev_recurso_previsto_id');
    }

    public function paisRecursoPrevistoUsaid(): BelongsTo
    {
        return $this->belongsTo(PaisRecursoPrevistoUsaid::class, 'pais_usaid_recurso_previsto_id');
    }

    public function paisRecursoPrevistoCostShare(): BelongsTo
    {
        return $this->belongsTo(PaisRecursoPrevistoCostShare::class, 'pais_cs_recurso_previsto_id');
    }

    public function paisPcjSostenibilidad(): BelongsTo
    {
        return $this->belongsTo(PaisPcjSostenibilidad::class, 'pais_pcj_sostenibilidad_id');
    }

    public function paisPcjAlcance(): BelongsTo
    {
        return $this->belongsTo(PaisPcjAlcance::class, 'pais_pcj_alcance_id');
    }

    public function paisPcjFortaleceArea(): BelongsTo
    {
        return $this->belongsTo(PaisPcjFortaleceArea::class, 'pais_pcj_fortalece_area_id');
    }

    public function scParticipantes(): HasMany
    {
        return $this->hasMany(ScParticipante::class, 'servicio_comunitario_id');
    }

    public function poblacionBeneficiadaDirecta(): BelongsToMany
    {
        return $this->belongsToMany(PaisPoblacionBeneficiadaDirecta::class, 'sc_poblacion_directas', 'servicio_comunitario_id', 'pais_poblacion_beneficiada_id');
    }

    public function poblacionesBeneficiadasDirecta()
    {
        return $this->hasMany(ScPoblacionBeneficiariaDirecta::class, 'servicio_comunitario_id');
    }

    public function poblacionBeneficiadaIndirecta(): BelongsToMany
    {
        return $this->belongsToMany(PaisPoblacionBeneficiadaIndirecta::class, 'sc_poblacion_indirectas', 'servicio_comunitario_id', 'pais_poblacion_beneficiada_id');
    }

    public function poblacionesBeneficiadasIndirecta()
    {
        return $this->hasMany(ScPoblacionBeneficiariaIndirecta::class, 'servicio_comunitario_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
