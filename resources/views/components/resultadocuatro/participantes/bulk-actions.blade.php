<div class="flex flex-col gap-2 sm:flex-row sm:justify-end">
    <div class="flex flex-row-reverse justify-end gap-2 sm:justify-start sm:flex-row" x-show="$wire.selectedParticipanteIds.length > 0" x-cloak>
        <div class="flex items-center gap-1 text-sm text-gray-600">
            <span x-text="$wire.selectedParticipanteIds.length"></span>

            <span x-text="$wire.selectedParticipanteIds.length == 1 ? 'seleccionado' : 'seleccionados'"></span>
        </div>

        <div class="flex items-center px-3">
            <div class="h-[75%] w-[1px] bg-gray-300"></div>
        </div>

        @can('Eliminar fichas R4')


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

        @endcan

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
