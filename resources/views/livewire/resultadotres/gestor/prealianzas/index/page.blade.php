<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 3: {{ __('Pre-alianzas') }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }}</small>
</x-slot>

<div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">PRE ALIANZAS</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Lista de todas las alianzas en su cuenta incluyendo su nombre, ciudad, DNI, estado y
                    fecha de registro.</p>
            </div>
            
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                @if(auth()->user()->can('Registrar Pre Alianza'))
                    <a href="{{ route('pre.alianza.create', [$pais, $proyecto]) }}"
                        role="button"
                        class="block px-3 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        wire:navigate>
                        Registrar Pre Alianza
                    </a>
                @endif
            </div>
        </div>

        {{-- <div
            class="flex flex-col items-start justify-start gap-4 mt-4 sm:flex-row sm:justify-between sm:items-center">
            <div class="flex flex-col gap-1"></div>
            <div class="flex gap-2">
                <x-participante.index.filter-participantes :$filters />

                <x-participante.index.filter-range :$filters />
            </div>
        </div>

        <div class="my-2">
            <x-participante.index.filter-status :$filters />
        </div> --}}



        @if(auth()->user()->can('Listado Pre Alianza'))
            <livewire:resultadotres.gestor.prealianzas.index.table :$pais :$proyecto />
        @endif
    </div>
</div>
