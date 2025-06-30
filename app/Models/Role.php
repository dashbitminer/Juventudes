<?php

namespace App\Models;

use Carbon\Carbon;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpatieRole
{
    use HasFactory;
    use Userstamps;

    public $guarded = [];


    public function dateForHumans() {

            //$fecha = Carbon::createFromFormat( 'Y-m-d H:i:s',$this->created_at ,'UTC');

            // $fecha->setTimezone('America/Guatemala');

            //return Carbon::parse( $fecha ,'America/Guatemala')->format( 'M d, Y, g:i A' );
            //return Carbon::parse( $fecha ,'America/Guatemala')->format( 'M d, Y, g:i A' );
            return Carbon::parse( $this->created_at)->format( 'M d, Y, g:i A' );
    }
}
