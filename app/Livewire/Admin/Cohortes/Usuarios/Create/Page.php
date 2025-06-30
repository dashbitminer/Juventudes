<?php

namespace App\Livewire\Admin\Cohortes\Usuarios\Create;

use App\Models\CohorteProyectoUser;
use App\Models\Pais;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;
use App\Models\SocioImplementador;
use Illuminate\Support\Facades\Hash;
use App\Models\CohortePaisProyecto;
use App\Models\CoordinadorGestor;

class Page extends Component
{
    const COORDINADOR = 3;
    const GESTOR = 2;

    public $openDrawer = false;

    public $showSuccessIndicator = false;

    public CohortePaisProyecto $cohortePaisProyecto;

    public $search;

    public $roles = [];

    public $users = [];

    public $coordinadores = [];

    public $role;

    public $usuarios = [];

    public $coordinador;

    public function mount($cohortePaisProyecto){

        $this->cohortePaisProyecto = $cohortePaisProyecto;

        $this->roles = Role::orderBy('id', 'asc')->pluck('name', 'id')->toArray();
        
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.admin.cohortes.usuarios.create.page');
    }

    #[On('openCreate')]
    public function openCreate(){
        $this->openDrawer = true;
    }

    public function save()
    {
        $this->validate([
            'usuarios' => 'required|array',
            'coordinador' => 'required_if:role,'.self::GESTOR,
        ]);

        $cohorteProyectouserCoordinador = CohorteProyectoUser::where('user_id', $this->coordinador)
                    ->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id)
                    ->first();

        foreach ($this->usuarios as $usuario) {
            /// Asignar el usuario a CohorteProyectoUser
            // cohortePaisProyecto
            $cohorteProyectoUser = new CohorteProyectoUser([
                'user_id' => $usuario,
                'cohorte_pais_proyecto_id' => $this->cohortePaisProyecto->id,
                'active_at' => now(),
                'created_at' => now(),
                'rol' => $this->getRol(),
            ]);

            $cohorteProyectoUser->save();

            /// Si es Gestor, se asigna el coordinador
            if($this->role == self::GESTOR && $this->coordinador){
                CoordinadorGestor::updateOrCreate([
                    'coordinador_id' => $cohorteProyectouserCoordinador->id,
                    'gestor_id' => $cohorteProyectoUser->id,
                    'cohorte_pais_proyecto_id' => $this->cohortePaisProyecto->id,
                ]);
            }
        }

        $this->showSuccessIndicator = true;
        $this->openDrawer = false;
        $this->reset(['role', 'usuarios', 'coordinador']);
        $this->dispatch('refresh-usuarios');
    }

    private function getUsuarios($isCoordinador = false, $value = '')
    {

        return User::with('roles', 'socioImplementador.pais:id,nombre')
            ->whereHas('roles', function ($q) use ($isCoordinador) {
                $roleIds = $isCoordinador ? [self::COORDINADOR] : [$this->role];
                $q->whereIn('roles.id', $roleIds);
            })
            ->when($isCoordinador, function ($query) {
                $query->whereHas('cohorteProyectoUser', function ($q) {
                    $q->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
                });
            }, function ($query) {
                $query->whereDoesntHave('cohorteProyectoUser', function ($q) {
                    $q->where('cohorte_pais_proyecto_id', $this->cohortePaisProyecto->id);
                });
            })
            /*->whereHas('socioImplementador', function ($q) {
                $q->whereIn('pais_id', [$this->cohortePaisProyecto->paisProyecto->pais_id]);
            })*/
            ->whereNotNull('active_at')
            ->when($value, function ($query) use ($value) {
                $query->where(function ($q) use ($value) {
                    $q->where('username', 'like', "%{$value}%")
                        ->orWhere('email', 'like', "%{$value}%");
                });
            })
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->pluck('username', 'id')->toArray();
    }

    private function getRol ()
    {
        $roles = [
            1 => 'Administrador',
            2 => 'Gestor',
            3 => 'Coordinador',
            4 => 'MECLA',
            5 => 'Staff',
            6 => 'Registro R3',
            7 => 'Validación R3',
            8 => 'Registro R4',
            9 => 'Validación R4',
        ];

        return $roles[$this->role] ?? 'Usuario';
    }

    public function updatedRole($value)
    {
        $this->users = $this->getUsuarios(false);
        /// Gestor id = 2
        $this->coordinadores = $value == self::GESTOR ? $this->getUsuarios(true) : [];

        $this->usuarios = [];
    }

    public function updatedSearch($value)
    {
        $this->users = $this->getUsuarios(false, $value);
        $this->usuarios = [];
    }

    protected $messages = [
        'usuarios.required' => 'Debe seleccionar al menos un usuario.',
        'coordinador.required_if' => 'Debe seleccionar un coordinador cuando los usuarios que desea agregar son Gestor.',
    ];
}
