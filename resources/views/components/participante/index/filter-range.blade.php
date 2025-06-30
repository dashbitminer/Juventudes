@props(['filters'])

<div>
    <x-popover>
        <x-popover.button class="flex items-center gap-2 py-1 pl-3 pr-2 text-sm text-gray-600 border rounded-lg">
            <div>
                {{ $filters->range->label($filters->start, $filters->end) }}
            </div>

            <x-icon.chevron-down />
        </x-popover.button>

        <x-popover.panel class="z-10 border border-gray-100 shadow-xl" position="bottom-end">
            <div class="flex flex-col divide-y divide-gray-100 min-w-64">
                @foreach (\App\Livewire\Resultadouno\Gestor\Participante\Index\Range::cases() as $range)
                    @if ($range === \App\Livewire\Resultadouno\Gestor\Participante\Index\Range::Custom)

                        <div x-data="{ showCustomRangePanel: $wire.filters.range === '{{ \App\Livewire\Resultadouno\Gestor\Participante\Index\Range::Custom }}' ? true : false }">
                            <button x-on:click="showCustomRangePanel = ! showCustomRangePanel" class="flex items-center justify-between w-full gap-2 px-3 py-2 text-gray-800 cursor-pointer hover:bg-gray-100">
                                <div class="text-sm">Rango Personalizado</div>

                                <x-icon.chevron-down x-show="! showCustomRangePanel" />
                                <x-icon.chevron-up x-show="showCustomRangePanel" />
                            </button>

                            <form
                                x-show="showCustomRangePanel"
                                x-collapse class="flex flex-col gap-4 px-3 pt-3 pb-2"
                                wire:submit="$set('filters.range', '{{ \App\Livewire\Resultadouno\Gestor\Participante\Index\Range::Custom }}')"
                                x-on:submit="$popover.close()"
                            >
                                <div class="flex items-center justify-between gap-2">
                                    <input wire:model="filters.start" type="date" class="px-2 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded" required>

                                    <span class="text-sm text-gray-700">y</span>

                                    <input wire:model="filters.end" type="date" class="px-2 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded" required>
                                </div>

                                <div class="flex">
                                    <button type="submit" class="w-full flex justify-center items-center gap-2 rounded-lg border border-blue-600 px-3 py-1.5 bg-blue-500 font-medium text-sm text-white hover:bg-blue-600">
                                        Aplicar
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <x-popover.close>
                            <button wire:click="$set('filters.range', '{{ $range }}')" class="flex items-center justify-between w-full gap-2 px-3 py-2 text-gray-800 cursor-pointer hover:bg-gray-100">
                                <div class="text-sm">{{ $range->label() }}</div>
                                @if ($range === $filters->range)
                                    <x-icon.check />
                                @endif
                            </button>
                        </x-popover.close>
                    @endif
                @endforeach
            </div>
        </x-popover.panel>
    </x-popover>
</div>
