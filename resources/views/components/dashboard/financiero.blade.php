<div class="hidden overflow-hidden shadow-sm sm:rounded-lg mt-11">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 ">
        @foreach($proyectos as $proyecto)
        <div class="p-4 bg-white rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">
                <a wire:navigate
                    href="financiero/admin/participantes?pais={{ $proyecto->cohortePaisProyecto->pais_proyecto_id }}&proyecto={{ $proyecto->cohortePaisProyecto->paisProyecto->id }}&cohorte={{ $proyecto->cohortePaisProyecto->id }}">
                    {{ $proyecto->cohortePaisProyecto->paisProyecto->proyecto->nombre ?? '' }}
                </a>
            </h2>
            <div class="flex items-center gap-2 text-sm font-medium text-green-500">
                Activo
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            {{-- <p class="text-gray-600">{{ $proyecto->pais_nombre }}</p> --}}
            <p class="text-gray-600"> {{ $proyecto->cohortePaisProyecto->paisProyecto->pais->nombre ?? '' }}</p>
            <p class="text-gray-600"> {{ $proyecto->cohortePaisProyecto->cohorte->nombre ?? '' }}</p>
        </div>
        @endforeach
    </div>
</div>


<div class="overflow-hidden shadow-sm sm:rounded-lg mt-11">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 ">

        <div class="p-4 bg-white rounded-lg shadow-md">
            <h2 class="flex items-center gap-2 text-xl font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5V6.75A2.25 2.25 0 015.25 4.5h13.5A2.25 2.25 0 0121 6.75v3.75M3 10.5h18M3 10.5v7.5A2.25 2.25 0 005.25 20.25h13.5A2.25 2.25 0 0021 18V10.5M3 10.5h18" />
                </svg>
                <a wire:navigate
                    href="financiero/admin/participantes">
                    Bancarización
                </a>
            </h2>
            <div class="flex items-center gap-2 text-sm font-medium text-green-500">
                Activo
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-md">
            <h2 class="flex items-center gap-2 text-xl font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18M3 7.5h18M3 12h18M3 16.5h18M3 21h18M3 3v18M7.5 3v18M12 3v18M16.5 3v18M21 3v18" />
                </svg>
                <a wire:navigate
                    href="financiero/cuentas">
                    Cuentas Bancarias
                </a>
            </h2>
            <div class="flex items-center gap-2 text-sm font-medium text-green-500">
                Activo
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-md">
            <h2 class="flex items-center gap-2 text-xl font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v7.5m0 0l3-3m-3 3l-3-3m6-6.75h-6a2.25 2.25 0 00-2.25 2.25v9A2.25 2.25 0 006 20.25h12a2.25 2.25 0 002.25-2.25v-9A2.25 2.25 0 0018 8.25h-6z" />
                </svg>
                <a wire:navigate
                    href="financiero/estipendios">
                    Estipendio
                </a>
            </h2>
            <div class="flex items-center gap-2 text-sm font-medium text-green-500">
                Activo
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

    </div>
</div>
