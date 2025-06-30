<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'socio_implementador_id',
        'active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * Get the user associated with the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function perfil(): HasOne
    {
        return $this->hasOne(Perfil::class, 'user_id');
    }


    /**
     * The roles that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cohorte(): BelongsToMany
    {
        //return $this->belongsToMany(Cohorte::class, 'cohorte_socio_users', 'user_id', 'cohorte_id')->withPivot(['rol', 'socios_implementador_id']);
        return $this->belongsToMany(CohortePaisProyecto::class, 'cohorte_proyecto_user', 'user_id', 'cohorte_pais_proyecto_id')
                ->withTimestamps()
                ->withPivot(['rol', 'active_at', 'id']);
    }

    /**
     * The grupos that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function grupos(): BelongsToMany
    {
        return $this->belongsToMany(Grupo::class, 'grupo_participante', 'user_id', 'grupo_id')
        //->as('grupo_participante')
        ->withPivot(['active_at', 'cohorte_participante_proyecto_id', 'id']);
    }

    /**
     * The sociosImplementadores that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sociosImplementadores(): BelongsToMany
    {
        return $this->belongsToMany(SocioImplementador::class, 'socio_implementador_user', 'user_id', 'socio_implementador_id');
    }


    public function lastestSocioImplementador(): HasOne
    {
        return $this->hasOne(SocioImplementadorUser::class, 'user_id')
                ->latestOfMany();
    }

    /**
     * The cohorteSocioImplementador that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cohorteSocioImplementador(): BelongsToMany
    {
        return $this->belongsToMany(Cohorte::class, 'cohorte_socio_users', 'user_id', 'cohorte_id')
            ->withPivot(['socios_implementador_id', 'rol', 'comentario']);
    }

    public function participantes(): HasMany
    {
        return $this->hasMany(Participante::class, 'gestor_id', 'id');
    }

    /**
     * Get the socio implementador that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function socioImplementador(): BelongsTo
    {
        return $this->belongsTo(SocioImplementador::class, 'socio_implementador_id');
    }

    public function dateForHumans() {

        //$fecha = Carbon::createFromFormat( 'Y-m-d H:i:s',$this->created_at ,'UTC');

        // $fecha->setTimezone('America/Guatemala');

        //return Carbon::parse( $fecha ,'America/Guatemala')->format( 'M d, Y, g:i A' );
        //return Carbon::parse( $fecha ,'America/Guatemala')->format( 'M d, Y, g:i A' );
        return Carbon::parse( $this->created_at)->format( 'M d, Y, g:i A' );

    }

    public function cohorteProyectoUser()
    {
        return $this->hasMany(CohorteProyectoUser::class, 'user_id');
    }
}
