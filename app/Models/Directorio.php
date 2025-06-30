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
use Wildside\Userstamps\Userstamps;

class Directorio extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Userstamps;
    use SluggableScopeHelpers;
    use Sluggable;

    protected $table = 'directorios';

    protected $fillable = [
        'nombre',
        'slug',
        'pais_id',
        'descripcion',
        'telefono',
        'tipo_institucion_id',
        'tipo_institucion_otros',
        'area_intervencion_id',
        'area_intervencion_otros',
        'departamento_id',
        'ciudad_id',
        'direccion',
        'ref_nombre',
        'ref_cargo',
        'ref_celular',
        'ref_email',
        'comentario',
        'active_at',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nombre',
            ],
        ];
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('active_at');
    }

    public function tipoInstitucion(): BelongsTo
    {
        return $this->belongsTo(TipoInstitucion::class, 'tipo_institucion_id');
    }

    public function areaIntervencion(): BelongsTo
    {
        return $this->belongsTo(AreaIntervencion::class, 'area_intervencion_id');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function tipoApoyo(): BelongsToMany
    {
        return $this->belongsToMany(
            TipoApoyo::class,
            'directorio_tipo_apoyos',
            'directorio_id',
            'tipo_apoyo_id'
        );
    }

}
