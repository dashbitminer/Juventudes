<div class="flex flex-col col-span-5 gap-2 sm:flex-row sm:justify-end">
    <div class="flex flex-row-reverse justify-end gap-2 sm:justify-start sm:flex-row" x-show="$wire.selectedParticipanteIds.length > 0" x-cloak>
        <div class="flex items-center gap-1 text-sm text-gray-600">
            <span x-text="$wire.selectedParticipanteIds.length"></span>

            <span x-text="$wire.selectedParticipanteIds.length == 1 ? 'seleccionado' : 'seleccionados'"></span>
        </div>

        <div class="flex items-center px-3">
            <div class="h-[75%] w-[1px] bg-gray-300"></div>
        </div>

        {{-- <form wire:submit="archiveSelected">
            <button type="submit" class="flex items-center gap-2 rounded-lg border px-3 py-1.5 bg-white font-medium text-sm text-gray-700 hover:bg-gray-200 disabled:cursor-not-allowed disabled:opacity-75">
                <x-icon.archive-box wire:loading.remove wire:target="archiveSelected" />

                <x-icon.spinner wire:loading wire:target="archiveSelected" class="text-gray-700" />

                Archivar
            </button>
        </form> --}}

        <form wire:submit="deleteSelected"
            wire:confirm="¿Esta segura(o) que desea eliminar los registros seleccionados? (Solamente serán eliminados los registros con estado documentación pendiente)"
        >
            <button type="submit"
            class="flex items-center gap-2 rounded-lg border border-red-600 px-3 py-1.5 bg-red-500 font-medium text-sm text-white hover:bg-red-600 disabled:cursor-not-allowed disabled:opacity-75"
            >
                <x-icon.receipt-refund wire:loading.remove wire:target="deleteSelected" />

                <x-icon.spinner wire:loading wire:target="deleteSelected" class="text-white" />

                Eliminar
            </button>
        </form>

        <form wire:submit="validarSelected"
                wire:confirm="¿Esta segura(o) que desea validar los registros seleccionados?"
            >
            <button type="submit"
            class="flex items-center gap-2 rounded-lg border border-sky-600 px-3 py-1.5 bg-sky-500 font-medium text-sm text-white hover:bg-sky-600 disabled:cursor-not-allowed disabled:opacity-75"
            >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
            </svg>

                <x-icon.spinner wire:loading wire:target="procesarSelected" class="text-white" />

                Validar
            </button>
        </form>
    </div>

    <div class="hidden sm:flex">
        <form wire:submit="export">
            <button type="submit" class="flex items-center gap-2 rounded-lg border px-3 py-1.5 bg-green-600 font-medium text-sm text-white hover:bg-green-500">
                <x-icon.arrow-down-tray wire:loading.remove wire:target="export" />

                <x-icon.spinner wire:loading wire:target="export" class="text-white" />

                Exportar
            </button>
        </form>
    </div>
    <div class="hidden sm:flex">
        <select wire:model.change='perPage' class="flex items-center rounded-lg border py-1.5 bg-white font-medium text-sm">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="40">40</option>
            <option value="60">60</option>
        </select>
    </div>
</div>
