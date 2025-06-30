<?php

namespace App\Livewire\Admin\Sesiones\Titulo;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use App\Models\Titulo;

class Table extends Component
{
    use WithPagination, Searchable, CreateAction, EditAction, DeleteAction;

    public $perPage = 10;

    public $selectedIds = [];

    public $openDrawer = false;

    public $openDrawerEdit = false;

    public $showSuccessIndicator = false;

    public $tableIdsOnPage = [];


    public ?Titulo $titulo;


    #[Validate(rule: 'required', message: 'El nombre del titulo es requerido')]
    public $nombre;

    public $comentario;

    #[On('refresh-sesiones-titulos')]
    public function render()
    {
        $query = Titulo::orderBy('created_at', 'desc');

        $query = $this->applySearch($query);

        $titulos = $query->paginate($this->perPage);

        $this->tableIdsOnPage = $titulos->map(fn ($model) => (string) $model->id)->toArray();

        return view('livewire.admin.sesiones.titulo.table', [
            'titulos' => $titulos,
        ])
        ->layout('layouts.app', ['title' => 'Sesiones', 'breadcrumb' => 'Sesiones', 'admin' => true]);
    }

    public function resetFields()
    {
        $this->reset([
            'nombre',
            'comentario',
        ]);

        $this->titulo = null;
    }
}
