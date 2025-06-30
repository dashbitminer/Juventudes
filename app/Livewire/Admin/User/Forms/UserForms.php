<?php
namespace App\Livewire\Admin\User\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Form;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Role;

class UserForms extends Form
{
    public User $user;

    public $readonly = false;

    public $showValidationErrorIndicator;

    public $nombre;

    public $username;

    public $email;

    public $password;

    public $password_confirmation;

    public $role;

    public $pais;

    public $isEdit = false;

    public $socio_implementador;

    public $is_active_at;

    public function boot()
    {
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $this->showValidationErrorIndicator = true;
            }
        });
    }

    protected function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($this->user->id ?? null),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user->id ?? null),
            ],
            'password' => $this->isEdit ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'password_confirmation' => $this->isEdit ? 'nullable|string|min:8' : 'required|string|min:8',
            'role'  => 'required',
            'socio_implementador' => 'required'
        ];
    }

    public function setUser($id){
        $this->user = User::find($id);
        $this->nombre = $this->user->name;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->socio_implementador = $this->user->socio_implementador_id;
        $this->role = $this->user->roles->pluck('id')->toArray();
        $this->is_active_at = $this->user->active_at ? true : null;
    }

    public function unsetUser(){
        unset($this->user);
    }

    public function clearFields(){
        $this->nombre = '';
        $this->username = '';
        $this->email = '';
        $this->socio_implementador = '';
        $this->role = [];
        $this->password = '';
        $this->password_confirmation = '';
        $this->is_active_at = null;
    }

    public function save()
    {
        $this->validate();

        $roles = [];

        if ($this->role) {
            $roles = Role::whereIn('id', $this->role)
                ->pluck('name')
                ->toArray();
        }

        if($this->isEdit){

            $this->user->name = $this->nombre;
            $this->user->username = $this->username;
            $this->user->email = $this->email;

            if (!empty($this->password)) {
                $this->user->password = Hash::make($this->password);
            }

            $this->user->socio_implementador_id = $this->socio_implementador;
            $this->user->save();

            if (!empty($roles)) {
                $this->user->syncRoles($roles);
            }

            $this->user->sociosImplementadores()->sync($this->socio_implementador);

        }else{

            $user = User::create([
                'name' => $this->nombre,
                'username' => $this->username,
                'email' => $this->email,
                'email_verified_at' => now(),
                'password' => Hash::make($this->password),
                'socio_implementador_id' => $this->socio_implementador,
                'remember_token' => Str::random(10),
                'active_at' => $this->is_active_at ? now() : null,
            ]);

            $user->forceFill([
                'email_verified_at' => now(), //    $usuario->markEmailAsVerified();
                'remember_token' => Str::random(10),
            ])->save();

            if (!empty($roles)) {
                $user->assignRole($roles);
            }

            $user->sociosImplementadores()->sync($this->socio_implementador);

        }
    }
}
