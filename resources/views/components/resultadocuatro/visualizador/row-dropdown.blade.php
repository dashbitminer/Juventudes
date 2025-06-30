@props(['formulario', 'route', 'pais', 'proyecto', 'routeName', 'routeModel'])

<x-menu>
    <x-menu.button class="p-2 rounded hover:bg-gray-100">
        <x-icon.ellipsis-vertical />
    </x-menu.button>

    <x-menu.items>
        @if(auth()->user()->can('Ver visualizador'))
            @php
                $cohorte = $routeName === 'servicioComunitario'
                    ? $formulario->cohortePaisProyecto->cohorte
                    : $formulario->cohorteParticipanteProyecto->cohortePaisProyecto->cohorte;

                $params = [
                    'pais' => $pais,
                    'proyecto' => $proyecto,
                    'cohorte' => $cohorte,
                    $routeModel ? $routeName : 'id' => $routeModel ? $formulario : $formulario->id,
                ];

                if ($routeName !== 'servicioComunitario') {
                    $params['participante'] = $formulario->cohorteParticipanteProyecto->participante;
                }
            @endphp
            <x-menu.close>
                <x-menu.link
                    href="{{ route($route, $params) }}"
                    wire:navigate
                >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                    <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                    </svg>
                    Revisar
                </x-menu.link>
            </x-menu.close>
        @endif

        @if(
            ((
                isset($formulario->lastEstado->estado_registro) && $formulario->lastEstado->estado_registro->nombre != 'Validado' ||
                isset($formulario->estado) && $formulario->estado != 4 ) ||
            (!isset($formulario->lastEstado->estado_registro) && !isset($formulario->estado))
            ) && auth()->user()->can('Validar R4'))
            <x-menu.close>
                <x-menu.link wire:confirm="¿Está seguro de que desea validar este registro?"
                    wire:click="validar({{ $formulario->id }})">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                      </svg>
                    Validar
                </x-menu.link>
            </x-menu.close>
        @endif
    </x-menu.items>
</x-menu>
