<?php

use App\Livewire\Actions\Logout;
use function Livewire\Volt\{state};

state('cohorte');
state('pais');
state('proyecto');
state('alianza');
state('directorio');
state('ficha');
state('resultadocuatro');
state('resultadouno');
state('resultadotres');
state('financiero');

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/', navigate: true);
};

?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        {{--
                        <x-application-logo class="block w-auto h-9 text-gray-800 fill-current" /> --}}
                        <img src="{{ asset('images/glasswing-butterfly.png') }}" class="h-12 text-gray-500 fill-current"
                            alt="Glasswing Logo">
                    </a>
                </div>




                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(auth()->user()->hasRole("MECLA") && $cohorte && $pais && $proyecto)
                    <x-nav-link :href="route('estipendios.mecla.index', [$pais->slug, $proyecto->slug, $cohorte->slug])" :active="request()->routeIs('estipendios.mecla.index')" wire:navigate>
                        {{ __('Estipendios') }}
                    </x-nav-link>
                    @endif

                    @if($financiero)
                    <x-nav-link :href="route('financiero.admin.participantes.index')"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['financiero.admin.participantes.index']))"
                        wire:navigate>
                        {{ __('Bancarización') }}
                    </x-nav-link>
                    <x-nav-link :href="route('financiero.cuentas')"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['financiero.cuentas']))"
                        wire:navigate>
                        {{ __('Cuentas Bancarias') }}
                    </x-nav-link>
                    <x-nav-link :href="route('financiero.estipendios')"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['financiero.estipendios']))"
                        wire:navigate>
                        {{ __('Estipendios') }}
                    </x-nav-link>
                    @endif



                    @if ($resultadouno && $cohorte && $pais && $proyecto)
                    <x-nav-link :href="route('participantes', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['participantes', 'participantes.create', 'participantes.edit', 'participantes.socioeconomico']))"
                        wire:navigate>
                        {{ __('Participantes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('participantes.grupos', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['participantes.grupos', 'participantes.grupo.show', 'participantes.r1.estados']))"
                        wire:navigate>
                        {{ __('Grupos') }}
                    </x-nav-link>
                    @endif

                    {{-- @dd($proyecto); --}}


                    @if($resultadotres)
                        @can('Listado Pre Alianza')
                            <x-nav-link :href="route('pre.alianzas.index', [$pais->slug, $proyecto->slug])"
                                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['pre.alianzas.index', 'pre.alianza.create', 'pre.alianza.edit']))"
                                wire:navigate>
                                {{ __('Prealianzas') }}
                            </x-nav-link>
                        @endcan

                        @can('Listado Alianza')
                            <x-nav-link :href="route('alianzas.index', [$pais->slug, $proyecto->slug])"
                                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['alianzas.index', 'alianza.create', 'alianza.edit']))"
                                wire:navigate>
                                {{ __('Alianzas') }}
                            </x-nav-link>
                        @endcan

                        @can('Listado Apalancamiento')
                            <x-nav-link :href="route('apalancamientos.index', [$pais->slug, $proyecto->slug])"
                                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['apalancamientos.index', 'apalancamientos.create', 'apalancamientos.edit']))"
                                wire:navigate>
                                {{ __('Apalancamientos') }}
                            </x-nav-link>
                        @endcan

                        @can('Listado Costo Compartido')
                            <x-nav-link :href="route('cost-share.index', [$pais->slug, $proyecto->slug])"
                                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['cost-share.index', 'cost-share.create', 'cost-share.edit']))"
                                wire:navigate>
                                {{ __('Costo Compartido') }}
                            </x-nav-link>
                        @endcan

                        @can('Listar Visualizador R3')
                            <x-nav-link :href="route('visualizador.resultadotres.index', [$pais, $proyecto])"
                                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['visualizador.resultadotres.index']))"
                                wire:navigate>
                                {{ __('Visualizador') }}
                            </x-nav-link>
                        @endcan

                    @endif


                    @if ($resultadocuatro)


                    @can('Ver visualizador')
                    <x-nav-link :href="route('visualizador.resultadocuatro.index', [$pais, $proyecto])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['visualizador.resultadocuatro.index']))"
                        wire:navigate>
                        {{ __('Visualizador') }}
                    </x-nav-link>
                    @endcan


                    @can('Listado directorio')
                        @if($cohorte)
                            <x-nav-link :href="route('directorio.cohorte.index', [$pais, $proyecto, $cohorte])"
                                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['directorio.cohorte.index', 'directorio.cohorte.create', 'directorio.cohorte.edit']))"
                                wire:navigate>
                                {{ __('Directorios') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('directorio.index', [$pais, $proyecto])"
                                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['directorio.index', 'directorio.create', 'directorio.edit']))"
                                wire:navigate>
                                {{ __('Directorios') }}
                            </x-nav-link>
                        @endif
                    @endcan

                    @can('Listado participantes R4')
                        @if($cohorte)
                            <x-nav-link :href="route('fichas.index', [$pais, $proyecto, $cohorte])"
                                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['fichas.index', 'ficha.voluntariado.create', 'practicas.empleabilidad.create', 'empleo.create', 'empleo.edit', 'empleo.index', 'ficha.formacion.create', 'ficha.formacion.edit', 'ficha.emprendimiento.create', 'ficha.emprendimiento.edit', 'ficha.aprendizaje.servicio.create', 'fichas.show', 'participantes.r4.estados']))"
                                wire:navigate>
                                {{ __('Participantes') }}
                            </x-nav-link>
                        @endif
                    @endcan

                    @can('Listado servicios comunitarios')
                        @if($cohorte)
                            <x-nav-link
                                :href="route('servicio-comunitario.index', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['servicio-comunitario.index', 'servicio-comunitario.create', 'servicio-comunitario.edit']))"
                                wire:navigate>
                                {{ __('Proyecto de servicio comunitario') }}
                            </x-nav-link>
                        @endif
                    @endcan

                    @endif

                    {{-- Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/participantes',
                    PageParticipante::class)->name('participantes'); --}}
                    {{-- <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Grupos') }}
                    </x-nav-link> --}}

                    {{-- <x-nav-link :href="route('participantes')"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['participantes', 'participantes.create', 'participantes.edit']))"
                        wire:navigate>
                        {{ __('Participantes') }}
                    </x-nav-link> --}}
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 bg-white rounded-md border border-transparent transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Perfil') }}
                        </x-dropdown-link> --}}

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Salir') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md transition duration-150 ease-in-out hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        @if ($resultadouno && $cohorte && $pais && $proyecto)
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('participantes', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['participantes', 'participantes.create', 'participantes.edit']))"
                wire:navigate>
                {{ __('Participantes') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('participantes.grupos', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['participantes.grupos', 'participantes.r1.estados']))"
                wire:navigate>
                {{ __('Grupos') }}
            </x-responsive-nav-link>
        </div>
        @endif


        @if($resultadotres)
            @can('Listado Pre Alianza')
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('pre.alianzas.index', [$pais, $proyecto, $cohorte])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['pre.alianzas.index', 'pre.alianza.create', 'pre.alianza.edit']))"
                        wire:navigate>
                        {{ __('Prealianzas') }}
                    </x-responsive-nav-link>
                </div>
            @endcan
            @can('Listado Alianza')
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('alianzas.index', [$pais, $proyecto, $cohorte])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['alianzas.index', 'alianza.create', 'alianza.edit']))"
                        wire:navigate>
                        {{ __('Alianzas') }}
                    </x-responsive-nav-link>
                </div>
            @endcan

            @can('Listado Apalancamiento')
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('apalancamientos.index', [$pais, $proyecto, $cohorte])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['apalancamientos.index', 'apalancamientos.create', 'apalancamientos.edit']))"
                        wire:navigate>
                        {{ __('Apalancamientos') }}
                    </x-responsive-nav-link>
                </div>
            @endcan

            @can('Listado Costo Compartido')
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('cost-share.index', [$pais, $proyecto, $cohorte])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['cost-share.index', 'cost-share.create', 'cost-share.edit']))"
                        wire:navigate>
                        {{ __('Costo compartido') }}
                    </x-responsive-nav-link>
                </div>
            @endcan

            @can('Listar Visualizador R3')
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('visualizador.resultadotres.index', [$pais, $proyecto])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['visualizador.resultadotres.index']))"
                        wire:navigate>
                        {{ __('Visualizador') }}
                    </x-responsive-nav-link>
                </div>
            @endcan

        @endif


        @if ($resultadocuatro)

        @can('Ver visualizador')
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('visualizador.resultadocuatro.index', [$pais, $proyecto])"
                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['visualizador.resultadocuatro.index']))"
                wire:navigate>
                {{ __('Visualizador') }}
            </x-responsive-nav-link>
        </div>
        @endcan

        @can('Listado directorio')
        <div class="pt-2 pb-3 space-y-1">
            @if($cohorte)
            <x-responsive-nav-link :href="route('directorio.cohorte.index', [$pais, $proyecto,$cohorte->slug])"
                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['directorio.cohorte.index', 'directorio.cohorte.create', 'directorio.cohorte.edit']))"
                wire:navigate>
                {{ __('Directorios') }}
            </x-responsive-nav-link>
            @else
            <x-responsive-nav-link :href="route('directorio.index', [$pais, $proyecto])"
                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['directorio.index', 'directorio.create', 'directorio.edit']))"
                wire:navigate>
                {{ __('Directorios') }}
            </x-responsive-nav-link>
            @endif
        </div>
        @endcan

        @can('Listado participantes R4')
            @if($cohorte)
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link
                        :href="route('fichas.index', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['fichas.index', 'ficha.voluntariado.create', 'practicas.empleabilidad.create', 'empleo.create', 'empleo.edit', 'empleo.index', 'ficha.formacion.create', 'ficha.formacion.edit', 'ficha.emprendimiento.create', 'ficha.emprendimiento.edit', 'ficha.aprendizaje.servicio.create', 'fichas.show', 'participantes.r4.estados']))"
                        wire:navigate>
                        {{ __('Participantes') }}
                    </x-responsive-nav-link>
                </div>
            @endif
        @endcan

        @can('Listado servicios comunitarios')
            @if($cohorte)
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link
                        :href="route('servicio-comunitario.index', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['servicio-comunitario.index', 'servicio-comunitario.create', 'servicio-comunitario.edit']))"
                        wire:navigate>
                        {{ __('Proyecto de servicio comunitario') }}
                    </x-responsive-nav-link>
                </div>
            @endif
        @endcan



        @endif

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800"
                    x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                    x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                {{-- <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Perfil') }}
                </x-responsive-nav-link> --}}

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Salir') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
