<x-radio-group class="hidden grid-cols-6 gap-1 sm:grid" wire:model.live="filters.status">
    <x-radio-group.option
        value="0"
        class="flex flex-col px-3 py-2 text-gray-700 border cursor-pointer rounded-xl hover:border-blue-400"
        class-checked="text-blue-600 border-2 border-blue-400"
        class-not-checked="text-gray-700"
    >
        <div class="text-sm font-normal">
            <span>Todos</span>
        </div>

        <div class="text-lg font-semibold">{{ $filters->estados()->sum('total') }}</div>
    </x-radio-group.option>

    @foreach ($filters->estados() as $status)
        <x-radio-group.option
            :value="$status['id']"
            class="flex flex-col px-3 py-2 text-gray-700 border cursor-pointer rounded-xl hover:border-{{ $status['color'] }}-400"
            class-checked="text-{{ $status['color'] }}-600 border-2 border-{{ $status['color'] }}-400"
            class-not-checked="text-gray-700"
        >
            <div class="text-sm font-normal">
                <span>{{ $status['nombre'] }}</span>
            </div>

            <div class="text-lg font-semibold">{{ $status['total'] }}</div>
        </x-radio-group.option>
    @endforeach
</x-radio-group>
