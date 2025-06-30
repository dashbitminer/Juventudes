<?php

namespace App\Models;

use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VinculadoDebido extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    use SluggableScopeHelpers;
    use Sluggable;

    const OTRO = 3;

    protected $table = 'vinculado_debido';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'slug',
        'comentario',
        'active_at',
    ];

    public $cast = [
        'active_at' => 'datetime',
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

    public function pais()
    {
        return $this->belongsToMany(Pais::class, 'pais_vinculado_debido', 'vinculado_debido_id', 'pais_id');
    }
}
