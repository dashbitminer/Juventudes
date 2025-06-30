<div class="flex flex-col col-span-5 gap-2 sm:flex-row sm:justify-end">
    <div class="flex flex-row-reverse gap-2 justify-end sm:justify-start sm:flex-row" x-show="$wire.selectedParticipanteIds.length > 0" x-cloak>
        <div class="flex gap-1 items-center text-sm text-gray-600">
            <span x-text="$wire.selectedParticipanteIds.length"></span>

            <span x-text="$wire.selectedParticipanteIds.length == 1 ? 'seleccionado' : 'seleccionados'"></span>
        </div>

        <div class="flex items-center px-3">
            <div class="h-[75%] w-[1px] bg-gray-300"></div>
        </div>

        {{-- <form wire:submit="archiveSelected">
            <button type="submit" class="flex gap-2 items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-white rounded-lg border hover:bg-gray-200 disabled:cursor-not-allowed disabled:opacity-75">
                <x-icon.archive-box wire:loading.remove wire:target="archiveSelected" />

                <x-icon.spinner wire:loading wire:target="archiveSelected" class="text-gray-700" />

                Revisar
            </button>
        </form> --}}

        {{-- <form wire:submit="deleteSelected"
            wire:confirm="¿Esta segura(o) que desea eliminar los registros seleccionados? (Solamente serán eliminados los registros con estado documentación pendiente)"
        >
            <button type="submit"
            class="flex gap-2 items-center px-3 py-1.5 text-sm font-medium text-white bg-red-500 rounded-lg border border-red-600 hover:bg-red-600 disabled:cursor-not-allowed disabled:opacity-75"
            >
                <x-icon.receipt-refund wire:loading.remove wire:target="deleteSelected" />

                <x-icon.spinner wire:loading wire:target="deleteSelected" class="text-white" />

                Eliminar
            </button>
        </form> --}}
    </div>
    @if($estipendio->is_closed)
    <div class="hidden sm:flex">
         <form wire:submit="export">
            <button type="submit" class="flex gap-2 items-center px-3 py-1.5 text-sm font-medium text-white bg-green-600 rounded-lg border hover:bg-green-500">
                <x-icon.arrow-down-tray wire:loading.remove wire:target="export" />

                <x-icon.spinner wire:loading wire:target="export" class="text-white" />

                Exportar
            </button>
        </form> 
    </div>
    @endif
    <div class="hidden sm:flex">
        <select wire:model.change='perPage' class="flex items-center py-1.5 text-sm font-medium bg-white rounded-lg border">
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="150">150</option>
            <option value="200">200</option>
            <option value="300">300</option>
            <option value="400">400</option>
        </select>
    </div>
</div>
