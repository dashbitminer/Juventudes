@props(['estado', 'historial'])
<x-menu>
    <x-menu.button class="p-2 rounded hover:bg-gray-100">
        <x-icon.ellipsis-vertical />
    </x-menu.button>

    <x-menu.items>
        <x-menu.close>
            <x-menu.item
                wire:click="$dispatch('openEdit', { id: {{ $estado->id }} })"
            >
                Editar
            </x-menu.item>
        </x-menu.close>

        @if ($historial->total() > 1)
            <x-menu.close>
                <x-menu.item
                    wire:click="delete('{{ $estado->id }}')"
                    wire:confirm="¿Esta seguro que desea eliminar el estado?"
                    class="hover:!bg-red-200 text-red-600"
                >
                    Eliminar
                </x-menu.item>
            </x-menu.close>
        @endif
    </x-menu.items>
</x-menu>
