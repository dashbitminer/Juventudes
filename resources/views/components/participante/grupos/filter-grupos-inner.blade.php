@props(['filters'])

{{-- @dd($filters); --}}

<x-popover>
    <x-popover.button class="flex items-center gap-2 py-1 pl-3 pr-2 text-sm text-gray-600 border rounded-lg">
        <div>Estados</div>

        <x-icon.chevron-down />
    </x-popover.button>

    <x-popover.panel class="z-10 w-64 overflow-hidden border border-gray-100 shadow-xl">
        <div class="flex flex-col divide-y divide-gray-100">
            @foreach ($filters->estadosParticipante() as $estado)
                <label class="flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100">
                    <input value="{{ $estado->id }}"
                    wire:model.live="filters.selectedEstadosParticipanteIds"
                    type="checkbox" class="border-gray-300 rounded"
                    >
                    <div class="text-sm text-gray-800">{{ $estado->nombre }} ({{ $estado->total }})</div>
                </label>
            @endforeach
        </div>
    </x-popover.panel>
</x-popover>


{{-- <x-popover>
    <x-popover.button class="flex items-center gap-2 py-1 pl-3 pr-2 text-sm text-gray-600 border rounded-lg">
        <div>Grupos</div>

        <x-icon.chevron-down />
    </x-popover.button>

    <x-popover.panel class="z-10 w-64 overflow-hidden border border-gray-100 shadow-xl">
        <div class="flex flex-col divide-y divide-gray-100">
            <label class="flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100">
                <input value="0"
                wire:model.live="filters.selectedEstadosIds"
                type="checkbox" class="border-gray-300 rounded">
                <div class="text-sm text-gray-800">Sin Grupo ({{ $filters->singrupo }})</div>
            </label>
            @foreach ($filters->grupos() as $grupo)
                <label class="flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100">
                    <input value="{{ $grupo->id }}"
                    wire:model.live="filters.selectedEstadosIds"
                    type="checkbox" class="border-gray-300 rounded">
                    <div class="text-sm text-gray-800">{{ $grupo->nombre }} ({{ $grupo->total }})</div>
                </label>
            @endforeach
        </div>
    </x-popover.panel>
</x-popover> --}}
