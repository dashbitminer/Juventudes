@props(['cohortePaisProyecto', 'proyecto'])

<x-menu>
    <x-menu.button class="p-2 rounded hover:bg-gray-100">
        <x-icon.ellipsis-vertical />
    </x-menu.button>

    <x-menu.items>
        <x-menu.close>
            <x-menu.link
            wire:click="$dispatch('openEdit', { cohortePaisProyectoID: {{ $cohortePaisProyecto->id }} })"
            >
                Editar
            </x-menu.link>
        </x-menu.close>
        <x-menu.close>
            <x-menu.link
            wire:click="$dispatch('openPerfiles', { cohortePaisProyectoID: {{ $cohortePaisProyecto->id }} })"
            >
                Perfiles
            </x-menu.link>
        </x-menu.close>
        <x-menu.close>
            <x-menu.link
            wire:click="$dispatch('openRangoEdades', { cohortePaisProyectoID: {{ $cohortePaisProyecto->id }} })"
            >
                Rango de Edades
            </x-menu.link>
        </x-menu.close>
        <x-menu.close>
            <x-menu.link
                href="{{ route('admin.admin.proyecto.cohortes.usuarios', [$proyecto, $cohortePaisProyecto]) }}"
                wire:navigate
            >
                Gestión de Usuarios
            </x-menu.link>
        </x-menu.close>
        <x-menu.close>
            <x-menu.link
                href="{{ route('admin.admin.proyecto.cohortes.participantes', [$proyecto, $cohortePaisProyecto]) }}"
                wire:navigate
            >
                Gestión de Participantes
            </x-menu.link>
        </x-menu.close>

        {{--<x-menu.close>
            <x-menu.item
                wire:click="delete('{{ $cohorte->id }}')"
                wire:confirm="¿Esta seguro que desea eliminar la cohorte del proyecto?"
                class="hover:!bg-red-200 text-red-600"
            >
                Eliminar
            </x-menu.item>
        </x-menu.close>--}}

    </x-menu.items>
</x-menu>
