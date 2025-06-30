<?php

namespace App\Models;

use App\Enums\RolCohorte;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CohorteSocioUser extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;

    protected $table = 'cohorte_socio_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cohorte_id',
        'user_id',
        'rol',
        'socio_implementador_id',
        'comentario',
        'active_at',
    ];

    protected $casts = [
        'rol' => RolCohorte::class,
    ];


    /**
     * Get the socio that owns the CohorteSocioUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function socio(): BelongsTo
    {
        return $this->belongsTo(SocioImplementador::class, 'socio_implementador_id');
    }
}
