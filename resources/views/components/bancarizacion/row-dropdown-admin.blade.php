@props(['participante'])

<x-menu>
    <x-menu.button class="p-2 rounded hover:bg-gray-100">
        <x-icon.ellipsis-vertical />
    </x-menu.button>

    <x-menu.items>

            <x-menu.close>
                <x-menu.link
                    href="#"
                    wire:navigate
                >
                    Editar
                </x-menu.link>
            </x-menu.close>
            {{-- <x-menu.close>
                <x-menu.link
                    href="#"
                    wire:navigate
                >
                    Eliminar
                </x-menu.link>
            </x-menu.close> --}}

    </x-menu.items>
</x-menu>
