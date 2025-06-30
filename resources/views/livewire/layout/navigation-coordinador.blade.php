<?php

use App\Livewire\Actions\Logout;
use function Livewire\Volt\{state};

state('cohorte');
state('pais');
state('proyecto');

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
                        <img src="{{ asset('images/glasswing-butterfly.png') }}" class="h-12 text-gray-500 fill-current" alt="Glasswing Logo">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('coordinador.dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if ($pais && $proyecto && $cohorte)
                    <x-nav-link :href="route('participantes', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['participantes', 'participantes.create', 'participantes.edit', 'coordinador.participantes', 'participante.view']))"
                        wire:navigate>
                        {{ __('Participantes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('bancarizacion.coordinador.index', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['bancarizacion.coordinador.index']))"
                        wire:navigate>
                        {{ __('Bancarización') }}
                    </x-nav-link>
                    {{-- <x-nav-link :href="route('estipendios.coordinador.index', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                        :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['estipendios.coordinador.index']))"
                        wire:navigate>
                        {{ __('Estipendios') }}
                    </x-nav-link> --}}
                    @endif

                    {{-- <x-nav-link :href="route('coordinador.participantes')" :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['coordinador.participantes']))" wire:navigate>
                        {{ __('Participantes') }}
                    </x-nav-link> --}}
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Perfil') }}
                        </x-dropdown-link>

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
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('coordinador.dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if ($pais && $proyecto && $cohorte)
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('participantes', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['participantes', 'participantes.create', 'participantes.edit', 'coordinador.participantes', 'participante.view']))"
                wire:navigate>
                {{ __('Participantes') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('bancarizacion.coordinador.index', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['bancarizacion.coordinador.index']))"
                wire:navigate>
                {{ __('Bancarización') }}
            </x-responsive-nav-link>

            {{-- <x-responsive-nav-link :href="route('estipendios.coordinador.index', [$pais->slug, $proyecto->slug, $cohorte->slug])"
                :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['estipendios.coordinador.index']))"
                wire:navigate>
                {{ __('Estipendios') }}
            </x-responsive-nav-link> --}}
        </div>
        @endif
            {{-- <x-responsive-nav-link :href="route('participantes')" :active="in_array(true, array_map(fn($route) => request()->routeIs($route), ['participantes']))" wire:navigate>
                {{ __('Participantes') }}
            </x-responsive-nav-link> --}}
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

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
