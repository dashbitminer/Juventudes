@props(['proyectos'])

<div x-data="{ activeTab: 0 }">
    <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 lg:grid-cols-4" >
        @if(!auth()->user()->hasAnyRole(['Validación R4']))
        <div x-on:click="activeTab = 0"
            class="block max-w-xs p-6 mx-auto space-y-3 rounded-lg shadow-lg cursor-pointer group ring-1 ring-slate-900/5 hover:bg-sky-500 hover:ring-sky-500"
            :class="{'hover:bg-white-500 hover:ring-white-500 bg-sky-500 ring-sky-500': activeTab === 0, 'bg-white hover:bg-sky-500 hover:ring-sky-500': !(activeTab === 0 )}"
        >
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg
                    class="w-6 h-6 stroke-sky-500 group-hover:stroke-white"
                    :class="{'stroke-white': activeTab === 0, 'group-hover:stroke-white': !(activeTab === 0 )}"
                    fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19H6.931A1.922 1.922 0 015 17.087V8h12.069C18.135 8 19 8.857 19 9.913V11"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 7.64L13.042 6c-.36-.616-1.053-1-1.806-1H7.057C5.921 5 5 5.86 5 6.92V11M17 15v4M19 17h-4">
                        </path>
                    </svg>
                    <h3 class="text-sm font-semibold text-slate-900 group-hover:text-white"
                    :class="{'text-white': activeTab === 0, 'text-slate-900': !(activeTab === 0 )}"
                    >Resultado 1</h3>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-blue-500 group-hover:stroke-white"
                    :class="{'text-white': activeTab === 0, 'text-blue-500': !(activeTab === 0 )}"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
            <p class="text-sm text-slate-500 group-hover:text-white"
            :class="{'text-white': activeTab === 0, 'text-slate-500': !(activeTab === 0 )}"
            >Resultado 1: Registro de participantes, estudio socioeconómico, etc.</p>
        </div>
        @endif

        <div x-on:click="activeTab = 1"
            class="hidden block max-w-xs p-6 mx-auto space-y-3 rounded-lg shadow-lg cursor-pointer group ring-1 ring-slate-900/5 hover:bg-red-500 hover:ring-red-500"
             :class="{'hover:bg-white-500 hover:ring-white-500 bg-red-500 ring-red-500': activeTab === 1, 'hover:bg-red-500 bg-white hover:ring-red-500': !(activeTab === 1 )}"
            >
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-6 h-6 stroke-red-500 group-hover:stroke-white"
                     :class="{'stroke-white': activeTab === 1, 'group-hover:stroke-white': !(activeTab === 1 )}"
                    fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19H6.931A1.922 1.922 0 015 17.087V8h12.069C18.135 8 19 8.857 19 9.913V11"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 7.64L13.042 6c-.36-.616-1.053-1-1.806-1H7.057C5.921 5 5 5.86 5 6.92V11M17 15v4M19 17h-4">
                        </path>
                    </svg>
                    <h3 class="text-sm font-semibold text-slate-900 group-hover:text-white"
                    :class="{'text-white': activeTab === 1, 'text-slate-900': !(activeTab === 1 )}"
                    >Resultado 2</h3>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-red-500 group-hover:stroke-white"
                    :class="{'text-white': activeTab === 1, 'text-red-500': !(activeTab === 1 )}"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
            <p class="text-sm text-slate-500 group-hover:text-white"
             :class="{'text-white': activeTab === 1, 'text-slate-500': !(activeTab === 1 )}"
            >Create a new project from a variety of starting
                templates.</p>
        </div>
        @if(auth()->user()->can('Ver Resultado R3') || auth()->user()->can('Ver Visualizador R3'))

            <div x-on:click="activeTab = 2"
                class="block max-w-xs p-6 mx-auto space-y-3 rounded-lg shadow-lg cursor-pointer group ring-1 ring-slate-900/5 hover:bg-green-500 hover:ring-green-500"
                :class="{'hover:bg-white-500 hover:ring-white-500 bg-green-500 ring-green-500': activeTab === 2, 'hover:bg-green-500 bg-white hover:ring-green-500': !(activeTab === 2 )}"
                >
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 stroke-green-500 group-hover:stroke-white"
                        :class="{'stroke-white': activeTab === 2, 'group-hover:stroke-white': !(activeTab === 2 )}"
                        fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 19H6.931A1.922 1.922 0 015 17.087V8h12.069C18.135 8 19 8.857 19 9.913V11"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 7.64L13.042 6c-.36-.616-1.053-1-1.806-1H7.057C5.921 5 5 5.86 5 6.92V11M17 15v4M19 17h-4">
                            </path>
                        </svg>
                        <h3 class="text-sm font-semibold text-slate-900 group-hover:text-white"
                        :class="{'text-white': activeTab === 2, 'text-slate-900': !(activeTab === 2 )}"
                        >Resultado 3</h3>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-green-500 group-hover:stroke-white"
                        :class="{'text-white': activeTab === 2, 'text-green-500': !(activeTab === 2 )}"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                @can('Ver Resultado R3')
                    <p class="text-sm text-slate-500 group-hover:text-white"
                    :class="{'text-white': activeTab === 2, 'text-slate-500': !(activeTab === 2 )}"
                    >Resultado 3: Pre alianzas, alianzas, apalancamiento, costo compartido, etc.</p>
                @endcan

                @can('Ver Visualizador R3')
                    <p class="text-sm text-slate-500 group-hover:text-white"
                    :class="{'text-white': activeTab === 2, 'text-slate-500': !(activeTab === 2 )}"
                    >Resultado 3: Visualizador - Validador.</p>
                @endcan
            </div>
        @endif


        <div x-on:click="activeTab = 3"
            class="block max-w-xs p-6 mx-auto space-y-3 rounded-lg shadow-lg cursor-pointer group ring-1 ring-slate-900/5 hover:bg-orange-500 hover:ring-orange-500"
             :class="{'hover:bg-white-500 hover:ring-white-500 bg-orange-500 ring-orange-500': activeTab === 3, 'hover:bg-orange-500 bg-white hover:ring-orange-500': !(activeTab === 3 )}"
            >
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-6 h-6 stroke-orange-500 group-hover:stroke-white"
                     :class="{'stroke-white': activeTab === 3, 'group-hover:stroke-white': !(activeTab === 3 )}"
                    fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 19H6.931A1.922 1.922 0 015 17.087V8h12.069C18.135 8 19 8.857 19 9.913V11"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 7.64L13.042 6c-.36-.616-1.053-1-1.806-1H7.057C5.921 5 5 5.86 5 6.92V11M17 15v4M19 17h-4">
                        </path>
                    </svg>
                    <h3 class="text-sm font-semibold text-slate-900 group-hover:text-white"
                    :class="{'text-white': activeTab === 3, 'text-slate-900': !(activeTab === 3 )}"
                    >Resultado 4</h3>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-orange-500 group-hover:stroke-white"
                    :class="{'text-white': activeTab === 3, 'text-orange-500': !(activeTab === 3 )}"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
            <p class="text-sm text-slate-500 group-hover:text-white"
             :class="{'text-white': activeTab === 3, 'text-slate-500': !(activeTab === 3 )}"
            >Resultado 4: Formulario de aprendizaje de servicio, ficha de emprendimiento, emprendimiento, empleabilidad, etc.</p>
        </div>



    </div>
    @if(!auth()->user()->hasAnyRole(['Validación R4']))
    <div class="mt-4">
        <div x-show="activeTab == 0" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
            x-show.transition.in.opacity.duration.600="activeTab === 0">
                @if(auth()->user()->can('Ver mis participantes R4'))
                    @foreach($proyectos as $proyecto)
                    <div class="p-4 bg-white rounded-lg shadow-lg">
                        <h2 class="text-xl font-semibold">
                            <a wire:navigate
                                href="/pais/{{ $proyecto->pais_slug }}/proyecto/{{ $proyecto->proyecto_slug }}/cohorte/{{ $proyecto->cohorte_slug }}/participantes">
                                {{-- href="/pais/{{ $proyecto->pais_slug }}/proyecto/{{ $proyecto->proyecto_slug }}/cohorte/{{ $proyecto->cohorte_slug }}/formularios"> --}}
                                {{ $proyecto->proyecto_nombre }} - {{ $proyecto->cohorte_nombre }}
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
                        <p class="text-gray-600">{{ $proyecto->pais_nombre }}</p>
                        <p class="text-gray-600">Número de Grupos: {{ $proyecto->grupo_count }}</p>
                    </div>
                    @endforeach
                @endif
                {{-- </div> --}}
            {{-- </div> --}}
        </div>
    </div>
    @endif

    <div class="mt-4" x-cloak>
        <div x-show="activeTab == 1" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
            x-show.transition.in.opacity.duration.600="activeTab === 1">
            <div class="p-4 bg-white rounded-lg shadow-md">
                <h2 class="text-xl font-semibold">Resultado 2 - Item 1</h2>
                <p class="text-gray-600">Description for Resultado 3 - Item 1</p>
            </div>
        </div>
    </div>

    <div class="mt-4" x-cloak>
        <div x-show="activeTab == 2" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
            x-show.transition.in.opacity.duration.600="activeTab === 2">

            @if(auth()->user()->can('Ver Resultado R3') )
                @foreach($periodo_proyectos as $proyecto)
                    <div class="p-4 bg-white rounded-lg shadow-lg">
                        <h2 class="text-xl font-semibold">
                            <a wire:navigate
                                href="/pais/{{ $proyecto->pais_slug }}/proyecto/{{ $proyecto->proyecto_slug }}/prealianzas">
                                {{ $proyecto->proyecto_nombre }}
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
                        <p class="text-gray-600">{{ $proyecto->pais_nombre }}</p>
                    </div>
                @endforeach
            @endif

            @can('Ver Visualizador R3')
                @foreach($periodo_proyectos as $proyecto)
                    <div class="p-4 bg-white rounded-lg shadow-lg">
                        <h2 class="text-xl font-semibold">
                            <a wire:navigate
                                href="/pais/{{ $proyecto->pais_slug }}/proyecto/{{ $proyecto->proyecto_slug }}/visualizador/resultadotres/formularios">
                                {{ $proyecto->proyecto_nombre }}
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
                        <p class="text-gray-600">{{ $proyecto->pais_nombre }}</p>
                    </div>
                @endforeach
            @endcan
        </div>
    </div>

    <div class="mt-4" x-cloak>
        <div x-show="activeTab == 3" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
            x-show.transition.in.opacity.duration.600="activeTab === 3">

                @foreach($proyectos as $proyecto)
                <div class="p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold">
                        <a wire:navigate
                        href="/pais/{{ $proyecto->pais_slug }}/proyecto/{{ $proyecto->proyecto_slug }}/visualizador/formularios">
                        <h2 class="text-xl font-semibold">{{ $proyecto->proyecto_nombre }} - {{ $proyecto->cohorte_nombre }}</h2>
                    </a>
                    </h2>
                    <div class="flex items-center gap-2 text-sm font-medium text-green-500">
                        Active
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        Agregar ficha de enlace a empleo, educativa, emprendimiento, etc. a Participantes dd
                    </p>
                </div>
                @endforeach

        </div>
    </div>


</div>
