@props(['titulos', 'actividades', 'subactividades', 'modulos', 'submodulos', 'paises', 'proyectos', 'cohortes', 'perfiles'])
<div @keydown.window.escape="$wire.openDrawerEdit = false" x-cloak x-show="$wire.openDrawerEdit" class="relative z-10"
    aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">

    <div x-description="Background backdrop, show/hide based on slide-over state." class="fixed inset-0"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10 pointer-events-none sm:pl-16">

                <div x-show="$wire.openDrawerEdit"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                    class="w-screen max-w-2xl pointer-events-auto "
                    x-description="Slide-over panel, show/hide based on slide-over state."
                    @click.away="$wire.openDrawerEdit = false">
                    <form class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl" wire:submit='editPermiso'>
                        <div class="flex-1 h-0 overflow-y-auto">
                            <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-base font-semibold text-white" id="slide-over-title">Editar Sesion
                                    </h2>
                                    <div class="flex items-center ml-3 h-7">
                                        <button type="button"
                                            @click="$wire.openDrawerEdit = false"
                                            class="relative text-indigo-200 bg-indigo-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                            <span class="absolute -inset-2.5"></span>
                                            <span class="sr-only">Close panel</span>
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <p class="text-sm text-indigo-300">Get started by filling in the information below
                                        to create your new project.</p>
                                </div>
                            </div>


                            <div class="flex flex-col justify-between flex-1">
                                <div class="px-4 divide-y divide-gray-200 sm:px-6">
                                    <div class="pt-6 pb-5 space-y-6">
                                        <div>
                                            <x-input-label for="pais_id">
                                                {{ __('Pais') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-forms.single-select name="pais_id"
                                                    wire:model.live='pais_id'
                                                    id="pais_id" :options="$paises"
                                                    selected="Seleccione un pais"
                                                    @class([
                                                    'block w-full mt-1','border-2 border-red-500' =>
                                                    $errors->has('pais_id')])
                                                    />
                                                <x-input-error
                                                    :messages="$errors->get('pais_id')"
                                                    class="mt-2" aria-live="assertive" />
                                            </div>
                                        </div>

                                        @if ($proyectos)
                                        <div>
                                            <x-input-label for="proyecto_id">
                                                {{ __('Proyecto') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-forms.single-select name="proyecto_id"
                                                    wire:model.live='proyecto_id'
                                                    id="proyecto_id" :options="$proyectos"
                                                    selected="Seleccione un proyecto"
                                                    @class([
                                                    'block w-full mt-1','border-2 border-red-500' =>
                                                    $errors->has('proyecto_id')])
                                                    />
                                                <x-input-error
                                                    :messages="$errors->get('proyecto_id')"
                                                    class="mt-2" aria-live="assertive" />
                                            </div>
                                        </div>
                                        @endif

                                        @if ($cohortes)
                                        <div>
                                            <x-input-label for="cohorte_id">
                                                {{ __('Cohorte') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-forms.single-select name="cohorte_id"
                                                    wire:model.live='cohorte_id'
                                                    id="cohorte_id" :options="$cohortes"
                                                    selected="Seleccione una cohorte"
                                                    @class([
                                                    'block w-full mt-1','border-2 border-red-500' =>
                                                    $errors->has('cohorte_id')])
                                                    />
                                                <x-input-error
                                                    :messages="$errors->get('cohorte_id')"
                                                    class="mt-2" aria-live="assertive" />
                                            </div>
                                        </div>
                                        @endif

                                        @if ($perfiles)
                                        <div>
                                            <x-input-label for="perfil_id">
                                                {{ __('Perfil') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-forms.single-select name="perfil_id"
                                                    wire:model.live='perfil_id'
                                                    id="perfil_id" :options="$perfiles"
                                                    selected="Seleccione un perfil"
                                                    @class([
                                                    'block w-full mt-1','border-2 border-red-500' =>
                                                    $errors->has('perfil_id')])
                                                    />
                                                <x-input-error
                                                    :messages="$errors->get('perfil_id')"
                                                    class="mt-2" aria-live="assertive" />
                                            </div>
                                        </div>
                                        @endif

                                        <div>
                                            <x-input-label for="actividad_id">
                                                {{ __('Actividades') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-forms.single-select name="actividad_id"
                                                    wire:model='actividad_id'
                                                    id="actividad_id" :options="$actividades"
                                                    selected="Seleccione una actividad"
                                                    @class([
                                                    'block w-full mt-1','border-2 border-red-500' =>
                                                    $errors->has('actividad_id')])
                                                    />
                                                <x-input-error
                                                    :messages="$errors->get('actividad_id')"
                                                    class="mt-2" aria-live="assertive" />
                                            </div>
                                        </div>
                                        <div>
                                            <x-input-label for="subactividad_id">
                                                {{ __('Subactividades') }}
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-forms.single-select name="subactividad_id"
                                                    wire:model='subactividad_id'
                                                    id="subactividad_id" :options="$subactividades"
                                                    selected="Seleccione una subactividad"
                                                    @class([
                                                    'block w-full mt-1','border-2 border-red-500' =>
                                                    $errors->has('subactividad_id')])
                                                    />
                                            </div>
                                        </div>
                                        <div>
                                            <x-input-label for="modulo_id">
                                                {{ __('Modulos') }}
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-forms.single-select name="modulo_id"
                                                    wire:model='modulo_id'
                                                    id="modulo_id" :options="$modulos"
                                                    selected="Seleccione un modulo"
                                                    @class([
                                                    'block w-full mt-1','border-2 border-red-500' =>
                                                    $errors->has('modulo_id')])
                                                    />
                                            </div>
                                        </div>
                                        <div>
                                            <x-input-label for="submodulo_id">
                                                {{ __('Submodulos') }}
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-forms.single-select name="submodulo_id"
                                                    wire:model='submodulo_id'
                                                    id="submodulo_id" :options="$submodulos"
                                                    selected="Seleccione un submodulo"
                                                    @class([
                                                    'block w-full mt-1','border-2 border-red-500' =>
                                                    $errors->has('submodulo_id')])
                                                    />
                                            </div>
                                        </div>


                                        <div>
                                            <x-input-label for="tipo_sesion">
                                                {{ __('Tipo de Sesion') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <select wire:model="tipo_sesion" id="tipo_sesion"
                                                class="block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                                    <option>Seleccione un tipo de sesion</option>
                                                    <option value="0">Por Asistencia</option>
                                                    <option value="1">Por horas Participante</option>
                                                </select>
                                                <x-input-error
                                                    :messages="$errors->get('tipo_sesion')"
                                                    class="mt-2" aria-live="assertive" />
                                            </div>
                                        </div>

                                        <div>
                                            <x-input-label for="tipo_titulo">
                                                {{ __('Tipo de Titulo') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <select wire:model="tipo_titulo" id="tipo_titulo"
                                                class="block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                                    <option>Seleccione un tipo de titulo</option>
                                                    <option value="1">Abierto</option>
                                                    <option value="0">Cerrado</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div x-cloak x-show="$wire.tipo_titulo == 0">
                                            <x-input-label for="titulo_id">
                                                {{ __('Titulo') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                <x-forms.single-select name="titulo_id"
                                                    wire:model='titulo_id'
                                                    id="titulo_id" :options="$titulos"
                                                    selected="Seleccione un titulo"
                                                    @class([
                                                    'block w-full mt-1','border-2 border-red-500' =>
                                                    $errors->has('titulo_id')])
                                                    />
                                                <x-input-error
                                                    :messages="$errors->get('titulo_id')"
                                                    class="mt-2" aria-live="assertive" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end flex-shrink-0 px-4 py-4">
                            <button type="button"
                                @click="$wire.openDrawerEdit = false"
                                class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancelar</button>
                            <button type="submit"
                                class="inline-flex justify-center px-3 py-2 ml-4 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
