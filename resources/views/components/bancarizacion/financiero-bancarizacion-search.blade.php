<div class="relative col-span-3 text-sm text-gray-800">
    <div class="absolute top-0 bottom-0 left-0 flex items-center pl-2 text-gray-500 pointer-events-none">
        <x-icon.magnifying-glass />
    </div>

    <input wire:model.live.debounce.250ms='search' type="text"placeholder="Buscar por nombre de grupo" class="block w-full rounded-lg border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
</div>
