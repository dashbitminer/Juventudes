<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use App\Models\ServiciosDesarrollar;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pais extends Model
{
    use HasFactory;
    use SluggableScopeHelpers;
    use SoftDeletes;
    use Userstamps;
    use Sluggable;

    protected $table = 'paises';

    const GUATEMALA = 1;
    const EL_SALVADOR = 2;
    const HONDURAS = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'slug',
        'active_at',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nombre',
            ],
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }


    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'pais_proyecto', 'pais_id', 'proyecto_id')
            ->withPivot('active_at')
            ->withTimestamps();
           // ->withSoftDeletes()
            //->withUserstamps();
    }

    /**
     * Get all of the comments for the Pais
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departamentos(): HasMany
    {
        return $this->hasMany(Departamento::class, 'pais_id');
    }

    public function tipoSector(): BelongsToMany
    {
        return $this->belongsToMany(TipoSector::class, 'pais_tipo_sector', 'pais_id', 'tipo_sector_id');
    }

    public function tipoSectorPublico(): BelongsToMany
    {
        return $this->belongsToMany(TipoSectorPublico::class, 'pais_tipo_sector_publico', 'pais_id', 'tipo_sector_publico_id');
    }
    public function tipoSectorPrivado(): BelongsToMany
    {
        return $this->belongsToMany(TipoSectorPrivado::class, 'pais_tipo_sector_privado', 'pais_id', 'tipo_sector_privado_id');
    }

    public function tamanoEmpresaPrivada(): BelongsToMany
    {
        return $this->belongsToMany(TamanoEmpresaPrivada::class, 'pais_tamano_empresa_privada', 'pais_id', 'tamano_empresa_privada_id');
    }

    public function origenEmpresaPrivada(): BelongsToMany
    {
        return $this->belongsToMany(OrigenEmpresaPrivada::class, 'pais_origen_empresa_privada', 'pais_id', 'origen_empresa_privada_id');
    }

    public function tipoSectorComunitaria(): BelongsToMany
    {
        return $this->belongsToMany(TipoSectorComunitaria::class, 'pais_tipo_sector_comunitaria', 'pais_id', 'tipo_sector_comunitaria_id');
    }

    public function tipoSectorAcademica(): BelongsToMany
    {
        return $this->belongsToMany(TipoSectorAcademica::class, 'pais_tipo_sector_academica', 'pais_id', 'tipo_sector_academica_id');
    }

    public function tipoAlianza(): BelongsToMany
    {
        return $this->belongsToMany(TipoAlianza::class, 'pais_tipo_alianza', 'pais_id', 'tipo_alianza_id');
    }

    public function propositoAlianza(): BelongsToMany
    {
        return $this->belongsToMany(PropositoAlianza::class, 'pais_proposito_alianza', 'pais_id', 'proposito_alianza_id');
    }

    public function modalidadEstrategiaAlianza(): BelongsToMany
    {
        return $this->belongsToMany(ModalidadEstrategiaAlianza::class, 'modalidad_estrategia_alianza_pais', 'pais_id', 'modalidad_estrategia_alianza_id');
    }

    public function objetivoAsistenciaAlianza(): BelongsToMany
    {
        return $this->belongsToMany(ObjetivoAsistenciaAlianza::class, 'objetivo_asistencia_alianza_pais', 'pais_id', 'objetivo_asistencia_alianza_id');
    }

    public function coberturaGeografica(): BelongsToMany
    {
        return $this->belongsToMany(CoberturaGeografica::class, 'pais_cobertura_geografica', 'pais_id', 'cobertura_geografica_id');
    }

    public function comunidadesLinguisticas(): BelongsToMany
    {
        return $this->belongsToMany(ComunidadLinguistica::class, 'comunidad_linguistica_pais', 'pais_id', 'comunidad_linguistica_id');
    }

    public function etnias(): BelongsToMany
    {
        return $this->belongsToMany(Etnia::class, 'etnia_pais', 'pais_id', 'etnia_id');
    }

    public function grupoPertenecientes(): BelongsToMany
    {
        return $this->belongsToMany(GrupoPerteneciente::class, 'grupo_perteneciente_pais', 'pais_id', 'grupo_perteneciente_id');
    }

    public function tipoInstituciones(): BelongsToMany
    {
        return $this->belongsToMany(TipoInstitucion::class, 'pais_tipo_instituciones', 'pais_id', 'tipo_institucion_id');
    }

    public function areaIntervenciones(): BelongsToMany
    {
        return $this->belongsToMany(AreaIntervencion::class, 'pais_area_intervenciones', 'pais_id', 'area_intervencion_id');
    }

    public function tipoApoyo(): BelongsToMany
    {
        return $this->belongsToMany(TipoApoyo::class, 'pais_tipo_apoyos', 'pais_id', 'tipo_apoyo_id');
    }

    public function recursoPrevisto(): BelongsToMany
    {
        return $this->belongsToMany(RecursoPrevisto::class, 'pais_recurso_previstos', 'pais_id', 'recurso_previsto_id');
    }

    public function recursoPrevistoUsaid(): BelongsToMany
    {
        return $this->belongsToMany(RecursoPrevistoUsaid::class, 'pais_usaid_recurso_previstos', 'pais_id', 'usaid_recurso_previsto_id');
    }

    public function recursoPrevistoCostShare(): BelongsToMany
    {
        return $this->belongsToMany(RecursoPrevistoCostShare::class, 'pais_cs_recurso_previstos', 'pais_id', 'cs_recurso_previsto_id');
    }

    public function recursoPrevistoLeverage(): BelongsToMany
    {
        return $this->belongsToMany(RecursoPrevistoLeverage::class, 'pais_lev_recurso_previstos', 'pais_id', 'lev_recurso_previsto_id');
    }

    public function pcjSostenibilidad(): BelongsToMany
    {
        return $this->belongsToMany(PcjSostenibilidad::class, 'pais_pcj_sostenibilidades', 'pais_id', 'pcj_sostenibilidad_id');
    }

    public function pcjAlcance(): BelongsToMany
    {
        return $this->belongsToMany(PcjAlcance::class, 'pais_pcj_alcances', 'pais_id', 'pcj_alcance_id');
    }

    public function pcjFortaleceArea(): BelongsToMany
    {
        return $this->belongsToMany(PcjFortaleceArea::class, 'pais_pcj_fortalece_areas', 'pais_id', 'pcj_fortalece_area_id');
    }

    public function poblacionBeneficiada(): BelongsToMany
    {
        return $this->belongsToMany(PoblacionBeneficiada::class, 'pais_poblacion_beneficiadas', 'pais_id', 'poblacion_beneficiada_id');
    }

    public function mediosVida(): BelongsToMany
    {
        return $this->belongsToMany(MedioVida::class, 'pais_medio_vidas', 'pais_id', 'medio_vida_id');
    }

    public function sectorEmpresaOrganizacion(): BelongsToMany
    {
        return $this->belongsToMany(SectorEmpresaOrganizacion::class, 'pais_sector_empresa_organizaciones', 'pais_id', 'sector_empresa_organizacion_id');
    }

    public function tipoEmpleo(): BelongsToMany
    {
        return $this->belongsToMany(TipoEmpleo::class, 'pais_tipo_empleos', 'pais_id', 'tipo_empleo_id');
    }

    public function salario(): BelongsToMany
    {
        return $this->belongsToMany(Salario::class, 'pais_salarios', 'pais_id', 'salario_id');
    }

    public function medioVerificacion(): BelongsToMany
    {
        return $this->belongsToMany(MedioVerificacion::class, 'pais_medio_verificaciones', 'pais_id', 'medio_verificacion_id');
    }

    public function vinculado(): BelongsToMany
    {
        return $this->belongsToMany(VinculadoDebido::class, 'pais_vinculado_debido', 'pais_id', 'vinculado_debido_id');
    }

    public function serviciosDesarrollar(): BelongsToMany
    {
        return $this->belongsToMany(ServiciosDesarrollar::class, 'pais_servicio_desarrollar', 'pais_id', 'servicio_desarrollar_id');
    }

    public function mediosVerificacionVoluntario(): BelongsToMany
    {
        return $this->belongsToMany(MedioVerificacionVoluntario::class, 'pais_medio_verificacion_voluntario', 'pais_id', 'medio_verificacion_voluntario_id');
    }

    public function motivosCambio(): BelongsToMany
    {
        return $this->belongsToMany(MotivosCambioOrganizacion::class, 'pais_motivo_cambio_organizacion', 'pais_id', 'motivo_cambio_organizacion_id');
    }

    public function habilidades(): BelongsToMany
    {
        return $this->belongsToMany(HabilidadesAdquirir::class, 'pais_habilidad_adquirir', 'pais_id', 'habilidad_adquirir_id');
    }

    public function tipoEstudios(): BelongsToMany
    {
        return $this->belongsToMany(TipoEstudio::class, 'pais_tipo_estudio', 'pais_id', 'tipo_estudio_id');
    }

    public function areaFormaciones(): BelongsToMany
    {
        return $this->belongsToMany(AreaFormacion::class, 'pais_area_formaciones', 'pais_id', 'area_formacion_id');
    }

    public function nivelEducativoFormaciones(): BelongsToMany
    {
        return $this->belongsToMany(NivelEducativoFormacion::class, 'pais_nivel_educativo_formaciones', 'pais_id', 'nivel_educativo_formacion_id');
    }

    public function medioVerificacionFormaciones(): BelongsToMany
    {
        return $this->belongsToMany(MedioVerificacionFormacion::class, 'pais_medio_verificacion_formaciones', 'pais_id', 'medio_verificacion_formacion_id');
    }

    public function rubroEmprendimiento(): BelongsToMany
    {
        return $this->belongsToMany(RubroEmprendimiento::class, 'pais_rubro_emprendimientos', 'pais_id', 'rubro_emprendimiento_id');
    }

    public function etapaEmprendimiento(): BelongsToMany
    {
        return $this->belongsToMany(EtapaEmprendimiento::class, 'pais_etapa_emprendimientos', 'pais_id', 'etapa_emprendimiento_id');
    }

    public function capitalSemilla(): BelongsToMany
    {
        return $this->belongsToMany(CapitalSemilla::class, 'pais_capital_semillas', 'pais_id', 'capital_semilla_id');
    }

    public function medioVerificacionEmprendimiento(): BelongsToMany
    {
        return $this->belongsToMany(MedioVerificacionEmprendimiento::class, 'pais_medio_verificacion_emprendimientos', 'pais_id', 'medio_verificacion_emprendimiento_id');
    }

    public function ingresosPromedio(): BelongsToMany
    {
        return $this->belongsToMany(IngresosPromedio::class, 'pais_ingresos_promedios', 'pais_id', 'ingresos_promedio_id');
    }

    public function costShareCategoria(): BelongsToMany
    {
        return $this->belongsToMany(CostShareCategoria::class, 'pais_costshare_categorias', 'pais_id', 'costshare_categoria_id');
    }
    public function costShareActividad(): BelongsToMany
    {
        return $this->belongsToMany(CostShareActividad::class, 'pais_costshare_actividades', 'pais_id', 'costshare_actividad_id');
    }

    public function costShareResultado(): BelongsToMany
    {
        return $this->belongsToMany(CostShareResultado::class, 'pais_costshare_resultados', 'pais_id', 'costshare_resultado_id');
    }

    public function costShareValoracion(): BelongsToMany
    {
        return $this->belongsToMany(CostShareValoracion::class, 'pais_costshare_valoraciones', 'pais_id', 'costshare_valoracion_id');
    }

    public function impactoPotencial(): BelongsToMany
    {
        return $this->belongsToMany(ImpactoPotencial::class, 'pais_impacto_potenciales', 'pais_id', 'impacto_potencial_id');
    }

    public function sectorProductivo(): BelongsToMany
    {
        return $this->belongsToMany(SectorProductivo::class, 'pais_sector_productivos', 'pais_id', 'sector_productivo_id');
    }

    public function grupoEtnico(): BelongsToMany
    {
        return $this->belongsToMany(GrupoEtnico::class, 'grupo_etnico_pais', 'pais_id', 'grupo_etnico_id')
            ->withTimestamps();
    }

    public function factorEconomico(): BelongsToMany
    {
        return $this->belongsToMany(FactorEconomico::class, 'pais_factores_economicos', 'pais_id', 'factores_economico_id');
    }

    public function factorSalud(): BelongsToMany
    {
        return $this->belongsToMany(FactorSalud::class, 'pais_factores_saludes', 'pais_id', 'factores_salud_id');
    }

    public function factorPersonalSocial(): BelongsToMany
    {
        return $this->belongsToMany(FactorPersonalSocial::class, 'pais_factores_persoces', 'pais_id', 'factores_persoc_id');
    }

    public function inclusionSocialTema(): BelongsToMany
    {
        return $this->belongsToMany(InclusionSocialTema::class, 'pais_inclusion_social_temas', 'pais_id', 'inclusion_social_tema_id');
    }

    public function medioambienteTema(): BelongsToMany
    {
        return $this->belongsToMany(MedioAmbienteTema::class, 'pais_medioambiente_temas', 'pais_id', 'medioambiente_tema_id');
    }

    public function culturaTema(): BelongsToMany
    {
        return $this->belongsToMany(CulturaTema::class, 'pais_cultura_temas', 'pais_id', 'cultura_tema_id');
    }
}
