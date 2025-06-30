@props(['filters'])
<x-popover>
    <x-popover.button class="flex items-center gap-2 py-1 pl-3 pr-2 text-sm text-gray-600 border rounded-lg">
        <div>Grupos</div>

        <x-icon.chevron-down />
    </x-popover.button>

    <x-popover.panel class="z-10 w-64 overflow-hidden border border-gray-100 shadow-xl">
        <div x-data="filtersGrupos" class="flex flex-col divide-y divide-gray-100">
            {{-- <label class="flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100">
                <input id="check-all"
                checked type="checkbox" class="border-gray-300 rounded"
                @click="toggleToAll">

                <div class="text-sm text-gray-800">Todos</div>
            </label> --}}
            <label class="flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100">
                <input value="0"
                wire:model.live="filters.selectedGruposIds"
                type="checkbox" class="border-gray-300 rounded">
                <div class="text-sm text-gray-800">Sin Grupo ({{ $filters->estados()->sum('total') - $filters->grupos()->sum('total') }})</div>
            </label>
            @foreach ($filters->grupos() as $grupo)
                <label class="flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100">
                    <input value="{{ $grupo->id }}"
                    wire:model.live="filters.selectedGruposIds"
                    type="checkbox" class="border-gray-300 rounded">
                    <div class="text-sm text-gray-800">{{ $grupo->nombre }} ({{ $grupo->total }})</div>
                </label>
            @endforeach
        </div>
    </x-popover.panel>
</x-popover>

@script
    <script>
        Alpine.data('filtersGrupos', () => ({
            toggleToAll: () => {
                const checkAll = $el.querySelector('#check-all');
                const checkboxes = $el.querySelectorAll('[x-ref="participante-grupo"]');
                const event = new Event('change');

                if (checkboxes && checkAll.checked) {
                    [...checkboxes].map(element => {
                        if (element.checked) {
                            element.checked = false;
                            element.dispatchEvent(event);
                        }
                    });
                }
            },
            toggleToFilter: () => {
                const checkAll = $el.querySelector('#check-all');

                if (checkAll.checked) {
                    checkAll.checked = false;
                }
            },
        }));
    </script>
@endscript
