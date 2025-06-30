<?php

namespace App\Models;

use Carbon\Carbon;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{

    use HasFactory;
    use Userstamps;

    public $guarded = [];

    const CATEGORIAS = [
        'Usuarios',
        'Roles',
        'Permisos',
        'Configuración',
        'Proyectos',
        'Cohortes',
        'Participantes',
        'Paises',
    ];


    public function dateForHumans()
    {

        //$fecha = Carbon::createFromFormat( 'Y-m-d H:i:s',$this->created_at ,'UTC');

        // $fecha->setTimezone('America/Guatemala');

        //return Carbon::parse( $fecha ,'America/Guatemala')->format( 'M d, Y, g:i A' );
        //return Carbon::parse( $fecha ,'America/Guatemala')->format( 'M d, Y, g:i A' );
        return Carbon::parse($this->created_at)->format('M d, Y, g:i A');
    }

    public function rolesasociados()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }
}
