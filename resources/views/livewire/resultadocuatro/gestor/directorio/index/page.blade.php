<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 4: {{ __('Directorios') }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }}</small>
</x-slot>
<div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Directorio de organizaciones e instituciones</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Lista de directorios
                </p>
            </div>
            @can('Crear directorio')
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                @if($cohorte)
                    <a href="{{ route('directorio.cohorte.create', [$pais, $proyecto,$cohorte]) }}"
                        role="button"
                        class="block px-3 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        wire:navigate>
                        Registrar institución
                    </a>
                @else
                    <a href="{{ route('directorio.create', [$pais, $proyecto]) }}"
                        role="button"
                        class="block px-3 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        wire:navigate>
                        Registrar institución
                    </a>
                @endif

            </div>
            @endcan
        </div>
{{-- @dd($cohorte) --}}
        <livewire:resultadocuatro.gestor.directorio.index.table :$pais :$proyecto :$cohorte/>
    </div>
</div>
