@props(['participante'])

<x-menu>
    <x-menu.button class="p-2 rounded hover:bg-gray-100">
        <x-icon.ellipsis-vertical />
    </x-menu.button>

    <x-menu.items>

        {{-- <x-menu.close>
            <x-menu.link
                wire:click.prevent="$dispatch('open-revisar', { estipendioParticipante: {{ $participante->estipendio_participante_id }} })"
            >
                Revisar
            </x-menu.link>
        </x-menu.close> --}}

        <x-menu.close>
            <x-menu.item
                wire:click="delete('{{ $participante->slug }}')"
                class="text-red-600"
                wire:confirm="¿Esta seguro que desea eliminar a {{ $participante->full_name }} ?"
            >
                Eliminar
            </x-menu.item>
        </x-menu.close>

    </x-menu.items>
</x-menu>
