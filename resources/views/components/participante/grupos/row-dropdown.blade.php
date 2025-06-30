@props(['participante', 'proyecto', 'cohorte', 'pais', 'nombre'])

<x-menu>
    <x-menu.button class="p-2 rounded hover:bg-gray-100">
        <x-icon.ellipsis-vertical />
    </x-menu.button>

    <x-menu.items>

        @if($participante->grupoactivo)


            <x-menu.close>
                <x-menu.item
                    wire:click="selectParticipanteMover('{{ $participante->id }}')"
                    wire:navigate
                >
                    Mover de grupo
                </x-menu.item>
            </x-menu.close>
            <x-menu.close>
                <x-menu.item
                    wire:click="selectParticipanteCambioEstado('{{ $participante->id }}')"
                    wire:navigate
                >
                    Cambiar estado
                </x-menu.item>
            </x-menu.close>

        @else

        <x-menu.close>
            <x-menu.item
                wire:click="selectParticipanteCambioEstado('{{ $participante->id }}')"
                wire:navigate
            >
                Mover estado
            </x-menu.item>
        </x-menu.close>

        @endif

        <x-menu.close>
            <x-menu.item
                href="{{ route('participantes.r1.estados', [$pais, $proyecto, $cohorte, $participante]) }}"
                wire:navigate
            >
                Ves estados
            </x-menu.item>
        </x-menu.close>
    </x-menu.items>
</x-menu>
