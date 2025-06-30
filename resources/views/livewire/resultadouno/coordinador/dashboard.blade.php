<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div>
    <div class="hidden overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            {{ __("You're logged in!") }}
            <h1>Dashboard de gesto</h1>
            {{-- @dump(auth()->user()->getRoleNames()) --}}


            {{-- <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach(range(1,4) as $project)
                <div class="p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold">Proyecto nombre</h2>
                    <div class="flex items-center gap-2 text-sm font-medium text-green-500">
                        Active
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-600">Guatemala</p>
                    <p class="text-gray-600">Número de Grupos: 5</p>
                </div>
                @endforeach
            </div> --}}




        </div>
    </div>

    <div class="overflow-hidden shadow-sm sm:rounded-lg mt-11">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 ">
            @foreach($proyectos as $proyecto)
            <a wire:navigate
                href="/pais/{{ $proyecto->pais_slug }}/proyecto/{{ $proyecto->proyecto_slug }}/cohorte/{{ $proyecto->cohorte_slug }}/participantes">
                <div class="p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold">
                        {{-- pais/guatemala/proyecto/jovenes-con-proposito/cohorte/cohorte-1/participantes/create --}}
                        {{ $proyecto->proyecto_nombre }}
                    </h2>
                    <div class="flex items-center gap-2 text-sm font-medium text-green-500">
                        Activo
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-gray-600">{{ $proyecto->pais_nombre }}</p>
                    <p class="text-gray-600">{{ $proyecto->cohorte_nombre }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
