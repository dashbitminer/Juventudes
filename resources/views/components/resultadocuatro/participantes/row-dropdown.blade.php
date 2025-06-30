@props(['participante', 'proyecto', 'cohorte', 'pais', 'nombre'])

<x-menu>
    <x-menu.button class="p-2 rounded hover:bg-gray-100">
        <x-icon.ellipsis-vertical />
    </x-menu.button>

    <x-menu.items>

        @if(auth()->user()->can('Crear fichas R4'))

            <x-menu.close>
                <x-menu.link
                    href="{{ route('ficha.voluntariado.create', [$pais, $proyecto, $cohorte, $participante]) }}"
                    wire:navigate
                >
                    Ficha de voluntariado
                </x-menu.link>
            </x-menu.close>

            <x-menu.close>
                <x-menu.link
                    href="{{ route('practicas.empleabilidad.create', [$pais, $proyecto, $cohorte, $participante]) }}"
                    wire:navigate
                >
                    Práctica para empleabilidad
                </x-menu.link>
            </x-menu.close>

            <x-menu.close>
                <x-menu.link
                    href="{{ route('empleo.create', [$pais, $proyecto, $cohorte, $participante]) }}"
                    wire:navigate
                >
                    Ficha de Empleo
                </x-menu.link>
            </x-menu.close>

            <x-menu.close>
                <x-menu.link
                    href="{{ route('ficha.formacion.create', [$pais, $proyecto, $cohorte, $participante]) }}"
                    wire:navigate
                >
                    Ficha de Formación
                </x-menu.link>
            </x-menu.close>

            <x-menu.close>
                <x-menu.link
                    href="{{ route('ficha.emprendimiento.create', [$pais, $proyecto, $cohorte, $participante]) }}"
                    wire:navigate
                >
                    Ficha de Emprendimiento
                </x-menu.link>
            </x-menu.close>

            <x-menu.close>
                <x-menu.link
                    href="{{ route('ficha.aprendizaje.servicio.create', [$pais, $proyecto, $cohorte, $participante]) }}"
                    wire:navigate
                >
                    Aprendizaje de servicio
                </x-menu.link>
            </x-menu.close>

        @endif
        @if(auth()->user()->can('Cambiar estado R4'))
            <x-menu.close>
                <x-menu.item
                    wire:click="selectParticipanteCambioEstado('{{ $participante->id }}')"
                    wire:navigate
                >
                    Cambiar estado
                </x-menu.item>
            </x-menu.close>
            <x-menu.close>
                <x-menu.item
                    href="{{ route('participantes.r4.estados', [$pais, $proyecto, $cohorte, $participante]) }}"
                    wire:navigate
                >
                    Ves estados
                </x-menu.item>
            </x-menu.close>
        @endif
    </x-menu.items>
</x-menu>
