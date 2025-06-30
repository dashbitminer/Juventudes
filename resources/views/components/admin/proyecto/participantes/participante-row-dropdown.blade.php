@props(['cohorteProyectoPartipante'])

<x-menu>
    <x-menu.button class="p-2 rounded hover:bg-gray-100">
        <x-icon.ellipsis-vertical />
    </x-menu.button>

    <x-menu.items>
        
        <x-menu.close>
            <x-menu.link
            wire:click="$dispatch('openParticipantes', { participanteID: {{ $cohorteProyectoPartipante->participante->id }} })"
            >
                Reasignar Gestor
            </x-menu.link>
        </x-menu.close>
    </x-menu.items>
</x-menu>
