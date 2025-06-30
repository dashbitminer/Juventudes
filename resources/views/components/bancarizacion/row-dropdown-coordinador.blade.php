@props(['participante', 'proyecto', 'cohorte', 'pais', 'nombre'])

<x-menu>
    <x-menu.button class="p-2 rounded hover:bg-gray-100">
        <x-icon.ellipsis-vertical />
    </x-menu.button>

    <x-menu.items>


            <x-menu.close>
                <x-menu.item
                    wire:click="moverSingleAGrupo({{ $participante->id }})"
                >
                    Mover a grupo
                </x-menu.item>
            </x-menu.close>


    </x-menu.items>
</x-menu>
