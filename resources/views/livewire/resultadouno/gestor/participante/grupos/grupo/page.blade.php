<x-slot:header>
    <h2 class="flex gap-2 text-xl font-semibold leading-tight text-gray-800">
        Resultado 1:
        <a wire:navigate href="{{ route('participantes.grupos', [$pais->slug, $proyecto->slug, $cohorte->slug]) }}">
            {{ __('Grupos') }}
        </a>
        <div aria-hidden="true" class="select-none text-slate-500">/</div>
        <span class="text-slate-500">{{ $grupo->nombre }}</span>
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
</x-slot>

<div>
    <div class="px-6 py-6 mb-4 bg-white rounded sm:rounded-lg sm:shadow">
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-4">
                <li>
                    <div class="flex">
                        <a wire:click.prevent="accessSession()" href="#" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                            <svg class="size-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z" clip-rule="evenodd" />
                            </svg>
                            <span class="sr-only">Actividades</span>
                        </a>
                    </div>
                </li>

                @if ($actividad)
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                        <a wire:click.prevent="accessSession({{ $actividad }})" href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Subactividades
                        </a>
                    </div>
                </li>
                @endif

                @if ($subactividad && !empty($modulos))
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                        <a wire:click.prevent="accessSession({{ $actividad }}, {{ $subactividad }})" href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Modulos
                        </a>
                    </div>
                </li>
                @endif

                @if ($modulo && !empty($submodulos))
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                        <a wire:click.prevent="accessSession({{ $actividad }}, {{ $subactividad }}, {{ $modulo }})" href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                            Submodulos
                        </a>
                    </div>
                </li>
                @endif
            </ol>
        </nav>
    </div>

    <div class="px-6 py-6 mb-4 bg-white rounded sm:rounded-lg sm:shadow">
        <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
            <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
                <div class="ml-4 mt-4">
                    <h3 class="text-base font-semibold text-gray-900">
                        @if ($submodulo)
                            {{ $submodulo->nombre }}
                        @elseif ($modulo)
                            {{ $modulo->nombre }}
                        @elseif ($subactividad)
                            {{ $subactividad->nombre }}
                        @elseif ($actividad)
                            {{ $actividad->nombre }}
                        @else
                            Actividades
                        @endif
                    </h3>
                </div>
                <div class="ml-4 mt-4 shrink-0">
                    @if ($submodulo)
                        <x-sesiones.open-form />
                    @elseif ($modulo && !isset($submodulos))
                        <x-sesiones.open-form />
                    @elseif ($subactividad && !isset($modulos))
                        <x-sesiones.open-form />
                    @elseif ($actividad && !isset($subactividades))
                        <x-sesiones.open-form />
                    @endif
                </div>
            </div>
        </div>

        @if ($submodulo)
            <livewire:resultadouno.gestor.participante.grupos.sesiones.create :$cohortePaisProyecto :$grupo :$actividad :$subactividad :$modulo :$submodulo />
            <livewire:resultadouno.gestor.participante.grupos.sesiones.page :$cohortePaisProyecto :$grupo :$actividad :$subactividad :$modulo :$submodulo />
        @elseif ($modulo)

            @if (isset($submodulos))
                <ul role="list" class="divide-y divide-gray-100 my-4">
                    @foreach ($submodulos as $submodulo)
                    <li wire:key="{{ $submodulo->id }}"
                        class="relative flex justify-between px-4 py-5 gap-x-6 hover:bg-gray-50 sm:px-6 lg:px-8">
                        <div class="flex min-w-0 gap-x-4">
                            <a href="#" wire:click.prevent="accessSession({{ $actividad }}, {{ $subactividad }}, {{ $modulo }}, {{ $submodulo }})">
                                <span class="absolute inset-x-0 bottom-0 -top-px"></span>
                                {{ $submodulo->nombre }}
                            </a>
                        </div>
                        <div class="flex items-center shrink-0 gap-x-4">
                            <svg class="flex-none w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <livewire:resultadouno.gestor.participante.grupos.sesiones.create :$cohortePaisProyecto :$grupo :$actividad :$subactividad :$modulo :$submodulo />
                <livewire:resultadouno.gestor.participante.grupos.sesiones.page :$cohortePaisProyecto :$grupo :$actividad :$subactividad :$modulo :$submodulo />
            @endif

        @elseif ($subactividad)

            @if (isset($modulos))
                <ul role="list" class="divide-y divide-gray-100 my-4">
                    @foreach ($modulos as $modulo)
                    <li wire:key="{{ $modulo->id }}"
                        class="relative flex justify-between px-4 py-5 gap-x-6 hover:bg-gray-50 sm:px-6 lg:px-8">
                        <div class="flex min-w-0 gap-x-4">
                            <a href="#" wire:click.prevent="accessSession({{ $actividad }}, {{ $subactividad }}, {{ $modulo }})">
                                <span class="absolute inset-x-0 bottom-0 -top-px"></span>
                                {{ $modulo->nombre }}
                            </a>
                        </div>
                        <div class="flex items-center shrink-0 gap-x-4">
                            <svg class="flex-none w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <livewire:resultadouno.gestor.participante.grupos.sesiones.create :$cohortePaisProyecto :$grupo :$actividad :$subactividad :$modulo :$submodulo />
                <livewire:resultadouno.gestor.participante.grupos.sesiones.page :$cohortePaisProyecto :$grupo :$actividad :$subactividad :$modulo :$submodulo />
            @endif

        @elseif ($actividad)

            @if (isset($subactividades))
                <ul role="list" class="divide-y divide-gray-100 my-4">
                    @foreach ($subactividades as $subactividad)
                    <li wire:key="{{ $subactividad->id }}"
                        class="relative flex justify-between px-4 py-5 gap-x-6 hover:bg-gray-50 sm:px-6 lg:px-8">
                        <div class="flex min-w-0 gap-x-4">
                            <a href="#" wire:click.prevent="accessSession({{ $actividad }}, {{ $subactividad }})">
                                <span class="absolute inset-x-0 bottom-0 -top-px"></span>
                                {{ $subactividad->nombre }}
                            </a>
                        </div>
                        <div class="flex items-center shrink-0 gap-x-4">
                            <svg class="flex-none w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <livewire:resultadouno.gestor.participante.grupos.sesiones.create :$cohortePaisProyecto :$grupo :$actividad :$subactividad :$modulo :$submodulo />
                <livewire:resultadouno.gestor.participante.grupos.sesiones.page :$cohortePaisProyecto :$grupo :$actividad :$subactividad :$modulo :$submodulo />
            @endif

        @else
            @if (isset($actividades))
                <ul role="list" class="divide-y divide-gray-100 my-4">
                    @foreach ($actividades as $actividad)
                    <li wire:key="{{ $actividad->id }}"
                        class="relative flex justify-between px-4 py-5 gap-x-6 hover:bg-gray-50 sm:px-6 lg:px-8">
                        <div class="flex min-w-0 gap-x-4">
                            <a href="#" wire:click.prevent="accessSession({{ $actividad }})">
                                <span class="absolute inset-x-0 bottom-0 -top-px"></span>
                                {{ $actividad->nombre }}
                            </a>
                        </div>
                        <div class="flex items-center shrink-0 gap-x-4">
                            <svg class="flex-none w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="py-5 text-center text-red-700">No se ha asignado ninguna Subactividad a este grupo.</p>
            @endif
        @endif
    </div>

    <div class="px-6 py-6 mb-4 bg-white rounded sm:rounded-lg sm:shadow">
        <livewire:resultadouno.gestor.participante.grupos.grupo.table :$pais :$proyecto :$cohorte :$cohortePaisProyecto :$grupo />
    </div>
</div>
