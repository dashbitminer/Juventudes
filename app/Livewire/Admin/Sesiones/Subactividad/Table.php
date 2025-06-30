<?php

namespace App\Livewire\Admin\Sesiones\Subactividad;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use App\Models\Subactividad;

class Table extends Component
{
    use WithPagination, Searchable, CreateAction, EditAction, DeleteAction;

    public $perPage = 10;

    public $selectedIds = [];

    public $openDrawer = false;

    public $openDrawerEdit = false;

    public $showSuccessIndicator = false;

    public $tableIdsOnPage = [];


    public ?Subactividad $model;


    #[Validate(rule: 'required', message: 'El nombre es requerido')]
    public $nombre;

    public $comentario;

    #[On('refresh-sesiones-titulos')]
    public function render()
    {
        $query = Subactividad::orderBy('created_at', 'desc');

        $query = $this->applySearch($query);

        $results = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $results->map(fn ($model) => (string) $model->id)->toArray();

        return view('livewire.admin.sesiones.subactividad.table', [
            'results' => $results,
        ])
        ->layout('layouts.app', ['title' => 'Sesiones', 'breadcrumb' => 'Sesiones', 'admin' => true]);
    }

    public function resetFields()
    {
        $this->reset([
            'nombre',
            'comentario',
        ]);

        $this->model = null;
    }
}
