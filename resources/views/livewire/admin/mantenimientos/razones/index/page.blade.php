<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Razones') }}
    </h2>
</x-slot>

<div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Razones</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Lista de todas las razones en su cuenta incluyendo su nombre y fecha de creación.</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a href="#"
                    role="button"
                    class="block px-3 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    x-on:click="$wire.openDrawer = true">
                    Crear razon
                </a>
            </div>
        </div>

        <div class="flex flex-col items-start justify-start gap-4 mt-4 sm:flex-row sm:justify-between sm:items-center">
            <div class="flex flex-col gap-1"></div>
            <div class="flex gap-2">
                {{-- Add any filters here if needed --}}
            </div>
        </div>

        <div class="my-2">
            {{-- Add any status filters here if needed --}}
        </div>

        <livewire:admin.mantenimientos.razones.index.table>

    </div>

    <x-admin.razones.drawer />

</div>
