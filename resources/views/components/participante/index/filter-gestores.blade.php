@props(['filters'])
<x-popover>
    <x-popover.button class="flex items-center gap-2 py-1 pl-3 pr-2 text-sm text-gray-600 border rounded-lg">
        <div>Gestores</div>

        <x-icon.chevron-down />
    </x-popover.button>

    <x-popover.panel class="z-10 w-64 overflow-hidden border border-gray-100 shadow-xl">
        <div class="flex flex-col divide-y divide-gray-100">
            <label class="flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100">
                <input id="check-all"
                checked type="checkbox" class="border-gray-300 rounded"
                wire:model.live='selectedGestoresAll'>
                <div class="text-sm text-gray-800">Todos</div>
            </label>
            @foreach ($filters->gestores() as $gestor)
                <label class="flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100">
                    <input value="{{ $gestor->id }}"
                    wire:model.live="filters.selectedGestoresIds"
                    type="checkbox" class="border-gray-300 rounded">

                    <div class="text-sm text-gray-800">{{ $gestor->name }} ({{ $gestor->total }})</div>
                </label>
            @endforeach
        </div>
    </x-popover.panel>
</x-popover>
