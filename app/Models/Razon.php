<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Razon extends Model
{
    use HasFactory;
    use SluggableScopeHelpers;
    use Sluggable;
    use SoftDeletes;
    use Userstamps;


    protected $table = 'razones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'comentario',
        'categoria_razon_id',
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

    public function dateForHumans() {

        //$fecha = Carbon::createFromFormat( 'Y-m-d H:i:s',$this->created_at ,'UTC');

        // $fecha->setTimezone('America/Guatemala');

        //return Carbon::parse( $fecha ,'America/Guatemala')->format( 'M d, Y, g:i A' );
        //return Carbon::parse( $fecha ,'America/Guatemala')->format( 'M d, Y, g:i A' );
        return \Carbon\Carbon::parse( $this->created_at)->format( 'M d, Y, g:i A' );

    }

    public function categoriaRazon()
    {
        return $this->belongsTo(CategoriaRazon::class, 'categoria_razon_id');
    }

}
