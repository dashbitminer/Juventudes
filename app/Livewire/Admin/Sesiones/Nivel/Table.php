<?php

namespace App\Livewire\Admin\Sesiones\Nivel;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use App\Models\Actividad;
use App\Models\Subactividad;
use App\Models\Modulo;
use App\Models\Submodulo;

class Table extends Component
{
    use WithPagination, Searchable, CreateAction, EditAction, DeleteAction;

    public $perPage = 10;

    public $selectedIds = [];

    public $openDrawer = false;

    public $openDrawerEdit = false;

    public $showSuccessIndicator = false;

    public $tableIdsOnPage = [];


    public Actividad | Subactividad | Modulo | Submodulo $model;

    public $niveles;


    #[Validate(rule: 'required', message: 'Seleccione un tipo de nivel')]
    public $nivel;

    #[Validate(rule: 'required', message: 'El nombre del titulo es requerido')]
    public $nombre;

    public $comentario;


    public function mount()
    {
        $this->niveles = ['Actividad', 'Subactividad', 'Módulo', 'Submódulo'];
    }

    #[On('refresh-sesiones-nivel')]
    public function render()
    {
        $query = DB::table('actividades')
            ->select('id', 'nombre', 'comentario', 'created_at', 'updated_at', DB::raw('1 as nivel'))
            ->whereNull('deleted_at')
            ->unionAll(
                DB::table('subactividades')
                ->select('id', 'nombre', 'comentario', 'created_at', 'updated_at', DB::raw('2 as nivel'))
                ->whereNull('deleted_at')
            )
            ->unionAll(
                DB::table('modulos')
                ->select('id', 'nombre', 'comentario', 'created_at', 'updated_at', DB::raw('3 as nivel'))
                ->whereNull('deleted_at')
            )
            ->unionAll(
                DB::table('submodulos')
                ->select('id', 'nombre', 'comentario', 'created_at', 'updated_at', DB::raw('4 as nivel'))
                ->whereNull('deleted_at')
            )
            ->orderBy('created_at', 'desc');

        $query = $this->applySearch($query);

        $niveles = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $niveles->map(fn ($model) => (string) $model->id)->toArray();

        return view('livewire.admin.sesiones.nivel.table', [
            'results' => $niveles,
        ])
        ->layout('layouts.app', ['title' => 'Sesiones', 'breadcrumb' => 'Sesiones', 'admin' => true]);
    }

    public function resetFields()
    {
        $this->reset([
            'nombre',
            'comentario',
        ]);
    }
}
