<?php

namespace App\Livewire\Resultadocuatro\Gestor\Directorio\Forms;

use Livewire\Form;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Livewire\WithFileUploads;
use App\Models\Pais;
use App\Models\Proyecto;
use App\Models\Directorio;
use App\Models\Ciudad;

class DirectorioForm extends Form
{
    use WithFileUploads;

    public $showValidationErrorIndicator = false;

    public $showSuccessIndicator = false;

    public $readonly= false;

    public $ciudades;


    public Pais $pais;

    public Proyecto $proyecto;

    public ?Directorio $directorio;

    public $nombre;

    public $descripcion;

    public $telefono;

    public $tipo_institucion_id;

    public $tipo_institucion_otros;

    public $area_intervencion_id;

    public $area_intervencion_otros;

    public $departamento_id;

    public $ciudad_id;

    public $direccion;

    public $ref_nombre;

    public $ref_cargo;

    public $ref_celular;

    public $ref_email;

    public $comentario;

    public $tipo_apoyo_id;


    public function setPais(Pais $pais) {
        $this->pais = $pais;
    }

    public function setProyecto(Proyecto $proyecto) {
        $this->proyecto = $proyecto;
    }

    public function setCiudades($departamento_id)
    {
        $this->ciudades = Ciudad::active()
            ->where('departamento_id', $departamento_id)
            ->pluck("nombre", "id");
    }

    public function setDirectorio(Directorio $directorio) {
        $this->directorio = $directorio;

        $this->nombre = $directorio->nombre;
        $this->descripcion = $directorio->descripcion;
        $this->telefono = $directorio->telefono;
        $this->tipo_institucion_id = $directorio->tipo_institucion_id;
        $this->tipo_institucion_otros = $directorio->tipo_institucion_otros;
        $this->area_intervencion_id = $directorio->area_intervencion_id;
        $this->area_intervencion_otros = $directorio->area_intervencion_otros;
        $this->departamento_id = $directorio->departamento_id;
        $this->ciudad_id = $directorio->ciudad_id;
        $this->direccion = $directorio->direccion;
        $this->ref_nombre = $directorio->ref_nombre;
        $this->ref_cargo = $directorio->ref_cargo;
        $this->ref_celular = $directorio->ref_celular;
        $this->ref_email = $directorio->ref_email;
        $this->comentario = $directorio->comentario;
    }

    public function customReset()
    {
        $this->nombre = null;
        $this->descripcion = null;
        $this->telefono = null;
        $this->tipo_institucion_id = null;
        $this->tipo_institucion_otros = null;
        $this->area_intervencion_id = null;
        $this->area_intervencion_otros = null;
        $this->departamento_id = null;
        $this->ciudad_id = null;
        $this->direccion = null;
        $this->ref_nombre = null;
        $this->ref_cargo = null;
        $this->ref_celular = null;
        $this->ref_email = null;
        $this->comentario = null;
    }

    public function init()
    {
        $this->ciudades = [];
        $this->tipo_apoyo_id = [];
    }


    public function boot()
    {
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
            }
        });
    }

    public function rules(): array
    {
        $esEdicion = $this->directorio && $this->directorio->exists;
        $nombreOriginal = $esEdicion ? $this->directorio->nombre : null;
        $nombreNuevo = $this->nombre;
        $paisId = $this->pais->id;

        $nombreRule = ['required'];

        $uniqueRule = Rule::unique('directorios')
            ->where(fn($query) => $query->where('pais_id', $paisId));

        if ($esEdicion && $nombreNuevo === $nombreOriginal) {
            $uniqueRule->ignore($this->directorio->id);
        }

        $nombreRule[] = $uniqueRule;

        return [
            'nombre' => $nombreRule,
            'descripcion' => [
                'required',
                'min:3',
            ],
            'telefono' => [
                'required',
                'numeric',
                'min_digits:8',
            ],
            'tipo_institucion_id' => [
                'required',
            ],
            'tipo_institucion_otros' => [
                Rule::requiredIf(function () {
                    return $this->pais->tipoInstituciones()
                        ->whereNotNull('tipo_instituciones.active_at')
                        ->where('tipo_instituciones.id', $this->tipo_institucion_id)
                        ->where('tipo_instituciones.slug', 'otra')
                        ->count();
                })
            ],
            'area_intervencion_id' => [
                'required',
            ],
            'area_intervencion_otros' => [
                Rule::requiredIf(function () {
                    return $this->pais->areaIntervenciones()
                        ->whereNotNull('area_intervenciones.active_at')
                        ->where('area_intervenciones.id', $this->area_intervencion_id)
                        ->where('area_intervenciones.slug', 'otra')
                        ->count();
                })
            ],
            'departamento_id' => [
                'required',
            ],
            'ciudad_id' => [
                'required',
            ],
            'direccion' => [
                'required',
                'min:5',
            ],
            'ref_nombre' => [
                'required',
            ],
            'ref_cargo' => [
                'required',
            ],
            'ref_celular' => [
                'required',
                'numeric',
                'min_digits:8',
            ],
            /*'ref_email' => [
                'required',
                'email',
            ],*/
            'tipo_apoyo_id' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.unique' => 'El nombre ya existe para el país seleccionado.',
            'descripcion.required' => 'El campo descripción es obligatorio.',
            'descripcion.min' => 'El campo descripción debe tener al menos 3 caracteres.',
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.numeric' => 'El campo teléfono solo acepta números sin guiones o espacios.',
            'telefono.min_digits' => 'El campo teléfono debe tener al menos 8 dígitos.',
            'tipo_institucion_id.required' => 'El campo tipo de institución es obligatorio.',
            'tipo_institucion_otros.required' => 'El campo otros tipos de institución es obligatorio.',
            'area_intervencion_id.required' => 'El campo área de intervención es obligatorio.',
            'area_intervencion_otros.required' => 'El campo otras áreas de intervención es obligatorio.',
            'departamento_id.required' => 'El campo departamento es obligatorio.',
            'ciudad_id.required' => 'El campo ciudad es obligatorio.',
            'direccion.required' => 'El campo dirección es obligatorio.',
            'direccion.min' => 'El campo dirección debe tener al menos 5 caracteres.',
            'ref_nombre.required' => 'El campo nombre de referencia es obligatorio.',
            'ref_cargo.required' => 'El campo cargo de referencia es obligatorio.',
            'ref_celular.required' => 'El campo celular de referencia es obligatorio.',
            'ref_celular.numeric' => 'El campo celular solo acepta números sin guiones o espacios.',
            'ref_celular.min_digits' => 'El campo celular debe tener al menos 8 dígitos.',
            'ref_email.required' => 'El campo email de referencia es obligatorio.',
            'ref_email.email' => 'El campo email debe ser una dirección de correo válida.',
            'tipo_apoyo_id.required' => 'El campo tipo de apoyo es obligatorio.',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->directorio->nombre = $this->nombre;
        $this->directorio->descripcion = $this->descripcion;
        $this->directorio->telefono = $this->telefono;
        $this->directorio->tipo_institucion_id = $this->tipo_institucion_id;
        $this->directorio->tipo_institucion_otros = $this->tipo_institucion_otros;
        $this->directorio->area_intervencion_id = $this->area_intervencion_id;
        $this->directorio->area_intervencion_otros = $this->area_intervencion_otros;
        $this->directorio->departamento_id = $this->departamento_id;
        $this->directorio->ciudad_id = $this->ciudad_id;
        $this->directorio->direccion = $this->direccion;
        $this->directorio->ref_nombre = $this->ref_nombre;
        $this->directorio->ref_cargo = $this->ref_cargo;
        $this->directorio->ref_celular = $this->ref_celular;
        $this->directorio->ref_email = $this->ref_email;
        $this->directorio->comentario = $this->comentario;
        $this->directorio->pais_id = $this->pais->id;
        $this->directorio->active_at = now();

        // if (empty($this->directorio->id)) {
        //     $this->directorio->active_at = now();
        //     $this->directorio->created_by = auth()->user()->id;
        // } else {
        //     $this->directorio->updated_by = auth()->user()->id;
        // }

        $this->directorio->save();

        $this->directorio->tipoApoyo()->sync($this->tipo_apoyo_id);
    }
}
