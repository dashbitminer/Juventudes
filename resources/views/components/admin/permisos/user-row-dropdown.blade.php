@props(['permiso'])

<x-menu>
    <x-menu.button class="p-2 rounded hover:bg-gray-100">
        <x-icon.ellipsis-vertical />
    </x-menu.button>

    <x-menu.items>
        <x-menu.close>
            <x-menu.link
            wire:click="$dispatch('openEdit', { id: {{ $permiso->id }} })"
            >
                Editar
            </x-menu.link>
        </x-menu.close>
        <x-menu.close>
            <x-menu.item
                wire:click="delete('{{ $permiso->id }}')"
                wire:confirm="¿Esta seguro que desea eliminar el permiso?"
                class="hover:!bg-red-200 text-red-600"
            >
                Eliminar
            </x-menu.item>
        </x-menu.close>

    </x-menu.items>
</x-menu>
