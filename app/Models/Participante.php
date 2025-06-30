<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\EstadoParticipante;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Participante extends Model
{
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;
    use SoftDeletes;
    use Userstamps;

    protected $table = "participantes";


    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'tercer_nombre',
        'primer_apellido',
        'segundo_apellido',
        'tercer_apellido',
        'nombres',
        'apellidos',
        'slug',
        'fecha_nacimiento',
        'nacionalidad',
        'estado_civil_id',
        'pariente_participo_jovenes_proposito',
        'pariente_participo_jovenes_proposito_otro',
        'pariente_participo_otros',
        'ultimo_anio_estudio',
        'tiempo_atender_actividades',
        'continuidad_tres_meses',
        //'discapacidad_id',
        //'grupo_perteneciente_id',
        //'etnia_id',
        //'apoyo_hijo_id',
       // 'proyecto_vida_id',
        'nivel_academico_id',
        'seccion_grado_id',
        'turno_estudio_id',
        'nivel_educativo_id',
        'nivel_educativo_alcanzado',
        'parentesco_id',
        'parentesco_otro',
        'tipo_zona_residencia',
        'ciudad_id',
        'direccion',
        'sexo',
        'comunidad_linguistica',
        'proyecto_vida_descripcion',
        'tiene_hijos',
        'cantidad_hijos',
        'participo_actividades_glasswing',
        'rol_participo',
        'descripcion_participo',
        'documento_identidad',
        'email',
        'telefono',
        'departamento_nacimiento_id',
        'municipio_nacimiento_id',
        'departamento_nacimiento_extranjero',
        'pais_nacimiento_extranjero',
        'municipio_nacimiento_extranjero',
        'nombre_beneficiario',
        'copia_documento_identidad',
        'copia_constancia_estudios',
        'consentimientos_inscripcion_programa',
        'gestor_id',
        'estudia_actualmente',
        'colonia',
        'comentario_documento_identidad_upload',
        'comentario_copia_certificado_estudio_upload',
        'comentario_formulario_consentimiento_programa_upload',
        'cohorte_id',
        'active_at',
        'readonly_at',
        'readonly_by',
        'pdf',
        'primer_nombre_beneficiario',
        'segundo_nombre_beneficiario',
        'tercer_nombre_beneficiario',
        'primer_apellido_beneficiario',
        'segundo_apellido_beneficiario',
        'tercer_apellido_beneficiario',
        'comentario_compromiso_continuar_estudio',
        'comentario_formulario_consentimiento_programa_upload',

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
                'source' => 'full_name',
            ],
        ];
    }

    protected $casts = [
        'created_at' => 'date',
        'fecha_nacimiento' => 'date',
        'tiene_hijos' => 'boolean',
        'participo_actividades_glasswing' => 'boolean',
        'estudia_actualmente' => 'boolean',
    ];

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

    public function scopeMisRegistros($query)
    {
        return $query->where('gestor_id', auth()->id());
    }


    public function dateForHumans() {

        //$fecha = Carbon::createFromFormat( 'Y-m-d H:i:s',$this->created_at ,'UTC');

        // $fecha->setTimezone('America/Guatemala');

        //return Carbon::parse( $fecha ,'America/Guatemala')->format( 'M d, Y, g:i A' );
        //return Carbon::parse( $fecha ,'America/Guatemala')->format( 'M d, Y, g:i A' );
        return Carbon::parse( $this->created_at)->format( 'M d, Y, g:i A' );

    }

    /**
     * Get the ciudad that owns the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function municipioNacimiento() : BelongsTo {
        return $this->belongsTo(Ciudad::class, 'municipio_nacimiento_id');
    }

    /**
     * Set the user's email to lowercase.
     *
     * @return string
     */
    public function setEmailAttribute($valor)
    {
        $this->attributes["email"] = strtolower($valor);
    }

      /**
     * Interact with the user's first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function fullName(): Attribute
    {
        return new Attribute(
            get: fn ($value) => trim(preg_replace('/\s+/', ' ', "{$this->primer_nombre} {$this->segundo_nombre} {$this->tercer_nombre} {$this->primer_apellido} {$this->segundo_apellido} {$this->tercer_apellido}"))
        );
    }

    protected function beneficiarioFullName(): Attribute
    {
        return new Attribute(
            get: fn ($value) => trim(preg_replace('/\s+/', ' ', "{$this->primer_nombre_beneficiario} {$this->segundo_nombre_beneficiario} {$this->tercer_nombre_beneficiario} {$this->primer_apellido_beneficiario} {$this->segundo_apellido_beneficiario} {$this->tercer_apellido_beneficiario}"))
        );
    }





    /**
     * Get the user's full name.
     *
     * @return string
     */
    protected function nombreCompleto(): Attribute
    {
        return new Attribute(
            get: fn () => trim(preg_replace('/\s+/', ' ', "{$this->primer_nombre} {$this->segundo_nombre} {$this->tercer_nombre}"))
        );
    }

    protected function apellidoCompleto(): Attribute
    {
        return new Attribute(
            get: fn () => trim(preg_replace('/\s+/', ' ', "{$this->primer_apellido} {$this->segundo_apellido} {$this->tercer_apellido}"))
        );
    }

    /**
     * Get the name of the trabajoglasswing attribute.
     *
     * @return string
     */
    public function getFormattedParticipoGlasswingAttribute(): string
    {
        return ($this->participo_actividades_glasswing == 1) ? "Sí" : "No";
    }

    /**
     * Get the name of the trabajoglasswing attribute.
     *
     * @return string
     */
    public function getFormattedRolParticipoAttribute(): string
    {
        if($this->rol_participo == 1) {
            return "Voluntario/voluntaria";
        }

        if($this->rol_participo == 2) {
            return "Participante";
        }

        return "";
    }

    public function getFormattedEstudiaActualmenteAttribute(): string
    {
        return ($this->estudia_actualmente == 1) ? "Sí" : "No";
    }

    public function getFormattedTieneHijosAttribute(): string
    {
        return ($this->tiene_hijos == 1) ? "Sí" : "No";
    }

    public function getFormattedSexoAttribute(): string
    {
        return ($this->sexo == 1) ? "Mujer" : "Hombre";
    }

    public function getFormattedNacionalidadAttribute(): string
    {
        if($this->nacionalidad == 1){
            return "Nacional";
        }

        if ($this->nacionalidad == 2){
            return "Extranjera";
        }

        return "";
    }

    public function getFormattedTipoZonaResidenciaAttribute(): string
    {
        if($this->tipo_zona_residencia == 1){
           return  'Zona urbana (Ciudad, áreas metropolitanas)';
        }

        if ($this->tipo_zona_residencia == 2){
            return 'Zona rural (Pueblos, aldeas, áreas agrícolas)';
        }

        return "";
    }



    /**
     * The roles that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function estados_registros(): BelongsToMany
    {
        return $this->belongsToMany(EstadoRegistro::class, 'estado_registro_participante', 'participante_id', 'estado_registro_id')
                        ->withTimestamps()
                        ->withPivot(['comentario', 'created_at', 'created_by']);
    }


    /**
     * Get all of the estadosregistrosparticipantes for the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estadosregistrosparticipantes(): HasMany
    {
        return $this->hasMany(EstadoRegistroParticipante::class, 'participante_id');
    }


    /**
     * Get the latest estado associated with the Participante
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function lastEstado()
    {
        //return $this->estados()->orderBy('pivot_created_at', 'desc')->first();
        return $this->hasOne(EstadoRegistroParticipante::class, 'participante_id')->latestOfMany();
    }

    /**
     * Get the latest grupo_participante associated with the Participante for a specific cohorte and user.
     *
     * @param int $cohorteId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function lastGrupoParticipante(int $cohorteId)
    {
        return $this->hasOne(GrupoParticipante::class, 'participante_id')
                    ->where('user_id', auth()->id())
                    ->where('cohorte_id', $cohorteId)
                    ->latestOfMany();
    }


    /**
     * Get all of the cohorteParticipanteProyecto for the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cohorteParticipanteProyecto(): HasMany
    {
        return $this->hasMany(CohorteParticipanteProyecto::class, 'participante_id');
    }


    /**
     * The discapacidades that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function discapacidades(): BelongsToMany
    {
        return $this->belongsToMany(Discapacidad::class, 'discapacidad_participante', 'participante_id', 'discapacidad_id')->withTimestamps();
    }

    /**
     * The grupos pertenecientes that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function gruposPertenecientes(): BelongsToMany
    {
        return $this->belongsToMany(GrupoPertenecientePais::class, 'grupo_perteneciente_pais_participante', 'participante_id', 'grupo_perteneciente_pais_id')
            ->withTimestamps()
            ->withPivot('otro_grupo', 'id');
    }


    /**
     * Calculate and return the age based on the fecha_nacimiento field.
     * If fecha_nacimiento is empty, return an empty string.
     *
     * @return string
     */
    public function getEdadAttribute()
    {
        if ($this->fecha_nacimiento) {
            return $this->fecha_nacimiento->age;
        }

        return null;
    }


    /**
     * Get the age of the Participante based on the fecha_nacimiento and the Cohorte's comparar_fecha_nacimiento.
     *
     * @return int|null
     */
    public function getEdadComparacionFuturaAttribute(): ?int
    {
        if ($this->fecha_nacimiento && $this->cohorte) {
            $edad = $this->fecha_nacimiento->diffInYears($this->cohorte->comparar_fecha_nacimiento);
            return $edad;
        }

        return null;
    }





    /**
     * The roles that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comunidadesLinguisticas(): BelongsToMany
    {
        return $this->belongsToMany(ComunidadLinguisticaPais::class, 'comunidad_linguistica_pais_participante', 'participante_id', 'comunidad_linguistica_pais_id')->withTimestamps();
    }

    /**
     * The roles that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function responsabilidadHijos(): BelongsToMany
    {
        return $this->belongsToMany(ComparteResponsabilidadHijo::class, 'participante_responsabilidad_hijo', 'participante_id', 'comparte_responsabilidad_hijo_id')->withTimestamps();
    }

    /**
     * The roles that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function apoyohijos(): BelongsToMany
    {
        return $this->belongsToMany(ApoyoHijo::class, 'apoyo_hijo_participante', 'participante_id', 'apoyo_hijo_id')->withTimestamps();
    }


    /**
     * The etnias that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function etnias(): BelongsToMany
    {
        return $this->belongsToMany(EtniaPais::class, 'etnia_pais_participante', 'participante_id', 'etnia_pais_id')->withTimestamps();
    }

    /**
     * Get the etniasPais that owns the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function etniasPais(): BelongsTo
    {
        return $this->belongsTo(Etnia::class, 'etnia_pais_participante', 'participante_id', 'etnia_pais_id')->withTimestamps();
    }

    /**
     * Get the estadoCivil that owns the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadoCivil(): BelongsTo
    {
        return $this->belongsTo(EstadoCivil::class, 'estado_civil_id');
    }

    /**
     * Get the nivelAcademico that owns the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nivelAcademico(): BelongsTo
    {
        return $this->belongsTo(NivelAcademico::class, 'nivel_academico_id');
    }

    /**
     * Get the seccionGrado that owns the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seccionGrado(): BelongsTo
    {
        return $this->belongsTo(SeccionGrado::class, 'seccion_grado_id');
    }

    /**
     * Get the turnoEstudio that owns the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turnoEstudio(): BelongsTo
    {
        return $this->belongsTo(TurnoEstudio::class, 'turno_estudio_id');
    }

    /**
     * Get the nivelEducativo that owns the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nivelEducativo(): BelongsTo
    {
        return $this->belongsTo(NivelEducativo::class, 'nivel_educativo_id');
    }

    /**
     * Get the parentesco that owns the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentesco(): BelongsTo
    {
        return $this->belongsTo(Parentesco::class, 'parentesco_id');
    }

    /**
     * The cohorte that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cohorte(): BelongsToMany
    {
        return $this->belongsToMany(Cohorte::class, 'cohorte_participante', 'participante_id', 'cohorte_id')->withTimestamps();
    }

    /**
     * The roles that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function proyectoVida(): BelongsToMany
    {
        return $this->belongsToMany(ProyectoVida::class, 'participante_proyecto_vida', 'participante_id', 'proyecto_vida_id')->withPivot('comentario')->withTimestamps();
    }

    /**
     * Get the socioeconomico associated with the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function socioeconomico(): HasOne
    {
        return $this->hasOne(Socioeconomico::class, 'participante_id');
    }

    /**
     * The roles that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    // public function grupos(): BelongsToMany
    // {
    //     return $this->belongsToMany(Grupo::class, 'grupo_participante');
    // }

    /**
     * The roles that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    // public function grupoactivo(): BelongsToMany
    // {
    //     return $this->belongsToMany(Grupo::class, 'grupo_participante', 'participante_id', 'grupo_id')
    //         ->withPivot(['user_id', 'active_at', 'cohorte_id', 'pais_proyecto_id', 'id'])
    //         ->wherePivotNotNull('active_at')
    //         ->withPivot('active_at');

    // }


    // public function carOwner(): HasOneThrough
    // {
    //     return $this->hasOneThrough(GrupoParticipante::class, CohorteParticipanteProyecto::class);
    // }
    public function grupoactivo(): HasOneThrough
    {
        return $this->hasOneThrough(GrupoParticipante::class, CohorteParticipanteProyecto::class)->whereNotNull('grupo_participante.active_at');
    }

    public function grupos(): HasManyThrough
    {
        return $this->hasManyThrough(GrupoParticipante::class, CohorteParticipanteProyecto::class);
    }

    public function getGrupoActivo()
    {
        return $this->grupos()->whereNotNull('grupo_participante.active_at')->first();
    }


    public function getParticipanteGrupoActivo($cohortePaisProyecto)  {

        // $grupo = $this->grupos()->first(function ($grupo) use ($cohortePaisProyecto) {
        //     return $grupo->cohorte_participante_proyecto_id == $cohortePaisProyecto &&
        //            $grupo->active_at;
        // });

        //dd($cohortePaisProyecto);

        $grupo = $this->grupos()
          //  ->join('cohorte_participante_proyecto', 'grupo_participante.cohorte_participante_proyecto_id', '=', 'cohorte_participante_proyecto.id')
            ->where('cohorte_participante_proyecto.cohorte_pais_proyecto_id', $cohortePaisProyecto->id)
            ->whereNotNull('grupo_participante.active_at')
            ->first();

          //  dump($this->grupos()->whereNotNull('grupo_participante.active_at')->first());

        return $grupo ? $grupo->grupoParticipante->grupo_id : "Sin Grupo";
    }

    public function getParticipanteGrupoEstado2($grupoParticipanteId)  {

        // $grupo = $this->grupoactivo->first(function ($grupo) use ($cohorteId, $paisProyectoId) {
        //     return $grupo->pivot->cohorte_id == $cohorteId &&
        //            $grupo->pivot->pais_proyecto_id == $paisProyectoId &&
        //            $grupo->pivot->user_id == auth()->id();
        // });

        // return $grupo ? $grupo->id : null;
    }

    /**
     * Get all of the grupoParticipante for the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grupoParticipante(): HasOneThrough
    {
        //return $this->hasOne(GrupoParticipante::class, 'participante_id')->latestOfMany();
        return $this->hasOneThrough(GrupoParticipante::class, CohorteParticipanteProyecto::class);
    }


    /**
     * The grupos that belong to the Participante filtered by cohorte_id
     *
     * @param int $cohorteId
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    // public function gruposByCohorte($cohorteId, $paisProyectoId): BelongsToMany
    // {
    //     return $this->belongsToMany(Grupo::class, 'grupo_participante')
    //                 ->where('grupo.cohorte_id', $cohorteId)
    //                 ->where('grupo.pais_proyecto_id', $paisProyectoId)
    //                 ->wherePivotNotNull('active_at')
    //                 ->withPivot('active_at');
    // }


    public function gestor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gestor_id', 'id');
    }

    public function cohortePaisProyecto(): BelongsToMany
    {
        return $this->belongsToMany(CohortePaisProyecto::class, 'cohorte_participante_proyecto', 'participante_id', 'cohorte_pais_proyecto_id')
            ->withTimestamps()
            ->withPivot('active_at', 'cohorte_pais_proyecto_perfil_id', 'numero_cuenta', 'voz_e_imagen', 'compartir_por_gobierno', 'compartir_para_bancarizacion', 'compartir_para_investigaciones', 'recoleccion_uso_glasswing', 'participacion_voluntaria');
    }




    /**
     * Get the direccionGuatemala associated with the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function direccionGuatemala(): HasOne
    {
        return $this->hasOne(DireccionGuatemala::class, 'participante_id');
    }

    /**
     * Get the direccionHonduras associated with the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function direccionHonduras(): HasOne
    {
        return $this->hasOne(DireccionHonduras::class, 'participante_id');
    }

    /**
     * The grupo etnico pais that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function grupoEtnicoPais(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\GrupoEtnicoPais::class, 'grupo_etnico_pais_participante', 'participante_id', 'grupo_etnico_pais_id')
        ->withPivot('selected', 'id', 'active_at')
        ->withTimestamps();
    }

    /**
     * The comunidad etnica that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comunidadEtnica(): BelongsToMany
    {
        return $this->belongsToMany(ComunidadEtnica::class, 'comunidad_etnica_participantes', 'participante_id', 'comunidad_etnica_id')
        ->withPivot('id', 'active_at')
        ->withTimestamps();
    }

    /**
     * The bancarizacion grupos that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bancarizacionGrupos(): BelongsToMany
    {
        return $this->belongsToMany(BancarizacionGrupo::class, 'bancarizacion_grupo_participantes', 'participante_id', 'bancarizacion_grupo_id')
                ->withPivot('active_at', 'bancarizacion_grupo_id', 'participante_id', 'deleted_at', 'monto')
                ->withTimestamps();
    }

    /**
     * The perfiles that belong to the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cohortePaisProyectoPerfiles(): BelongsToMany
    {
        return $this->belongsToMany(CohortePaisProyectoPerfil::class, 'cohorte_participante_proyecto', 'participante_id', 'cohorte_pais_proyecto_perfil_id')
            ->withPivot('active_at')
            ->withTimestamps();
    }

    /**
     * Get all of the estipendioParticipantes for the Participante
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estipendioParticipantes(): HasMany
    {
        return $this->hasMany(EstipendioParticipante::class, 'participante_id');
    }



}
