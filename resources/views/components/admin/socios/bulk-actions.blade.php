<div class="flex flex-col col-span-5 gap-2 sm:flex-row sm:justify-end">
    <div class="flex flex-row-reverse gap-2 justify-end sm:justify-start sm:flex-row" x-show="$wire.selectedIds.length > 0" x-cloak>
        <div class="flex gap-1 items-center text-sm text-gray-600">
            <span x-text="$wire.selectedIds.length"></span>

            <span x-text="$wire.selectedIds.length == 1 ? 'seleccionado' : 'seleccionados'"></span>
        </div>

        <div class="flex items-center px-3">
            <div class="h-[75%] w-[1px] bg-gray-300"></div>
        </div>

        <form wire:submit="deleteSelected"
            wire:confirm="¿Esta segura(o) que desea eliminar los registros seleccionados?"
        >
            <button type="submit"
                class="flex gap-2 items-center px-3 py-1.5 text-sm font-medium text-white bg-red-500 rounded-lg border border-red-600 hover:bg-red-600 disabled:cursor-not-allowed disabled:opacity-75"
            >
                <x-icon.receipt-refund wire:loading.remove wire:target="deleteSelected" />
                <x-icon.spinner wire:loading wire:target="deleteSelected" class="text-white" />
                Eliminar
            </button>
        </form>
    </div>

    <div class="hidden sm:flex"></div>
    <div class="hidden sm:flex">
        <select wire:model.change='perPage' class="flex items-center py-1.5 text-sm font-medium bg-white rounded-lg border">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="40">40</option>
            <option value="60">60</option>
        </select>
    </div>
</div>
