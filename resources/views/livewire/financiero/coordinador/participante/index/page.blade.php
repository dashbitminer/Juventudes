<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Bancarización: {{ __('Coordinador') }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
    </x-slot>

    <div>

        <div class="flex flex-col gap-4 mb-4 sm:flex-row">
            <div class="w-full sm:w-1/6">
                <label for="pais" class="block text-sm font-medium text-gray-700">País</label>
                <select id="pais" name="pais" disabled
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    wire:model.live='selectedPais'>
                    {{-- <option value="">Seleccione un país</option> --}}
                    @foreach($paises as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <label for="proyecto" class="block text-sm font-medium text-gray-700">Proyecto</label>
                <select id="proyecto" name="proyecto" disabled
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    wire:model.live='selectedPaisProyecto'>
                    {{-- <option value="">Seleccione un proyecto</option> --}}
                    @foreach($proyectos as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <label for="cohorte" class="block text-sm font-medium text-gray-700">Cohorte</label>
                <select id="cohorte" name="cohorte" disabled
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    wire:model.live='selectedCohortePaisProyecto'>
                    <option value="">Seleccione una cohorte</option>
                    @foreach($cohortes as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="flex gap-2 mt-6">
                <button wire:click='resetFilters'
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-transparent border border-gray-300 rounded-md hover:bg-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 9.293l4.646-4.647a.5.5 0 01.708.708L10.707 10l4.647 4.646a.5.5 0 01-.708.708L10 10.707l-4.646 4.647a.5.5 0 01-.708-.708L9.293 10 4.646 5.354a.5.5 0 01.708-.708L10 9.293z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div> --}}
        </div>


        @if($selectedCohortePaisProyecto && $selectedPaisProyecto)
        <livewire:financiero.coordinador.participante.index.grupos :cohortePaisProyecto="$selectedCohortePaisProyecto"
            :paisProyecto="$selectedPaisProyecto" :$selectedPais />


        <div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">Participantes</h1>
                        @if($selectedCohortePaisProyecto)
                        <p class="mt-2 text-sm text-gray-700">
                            Listado de participantes para el proyecto
                            <span class="font-bold">{{ $paisProyecto->proyecto->nombre ?? '' }}</span> en
                            <span class="font-bold">{{ $paisProyecto->pais->nombre ?? '' }}</span> para la cohorte:
                            <span class="font-bold">{{ $cohortePaisProyecto->cohorte->nombre ?? '' }}</span>
                        </p>
                        <p class="text-sm text-gray-700 ">
                            <span class="font-bold underline">{{ auth()->user()->socioImplementador->nombre }} </span>
                        </p>
                        @endif
                    </div>
                </div>

                {{-- @if($selectedCohortePaisProyecto && $selectedPaisProyecto) --}}
                <div
                    class="flex flex-col items-start justify-start gap-4 mt-4 sm:flex-row sm:justify-between sm:items-center">
                    <div class="flex flex-col gap-1"></div>
                    <div class="flex gap-2">

                        {{--
                        <x-participante.index.filter-participantes :$filters /> --}}
                        {{--
                        <x-bancarizacion.filter-perfiles :$filters /> --}}

                        <x-participante.index.filter-range :$filters />

                    </div>
                </div>


                <div class="my-2 ">

                    <div class="flex flex-col items-start justify-start w-full gap-4 sm:w-3/4 sm:flex-row sm:gap-2">
                        <div class="w-full sm:w-1/3">
                            <label for="dropdown1" class="block text-sm font-medium text-gray-700">Departamento</label>
                            <flux:select variant="listbox" multiple placeholder="Seleccione las opciones..."
                                indicator="checkbox" wire:model.live="filters.selectedDepartamentosIds">
                                <flux:option value="-1">Seleccionar Todo</flux:option>
                                @foreach ($filters->departamentos() as $departamento)
                                <flux:option value="{{ $departamento['departamento_id'] }}">
                                    {{ $departamento["nombre"]}}
                                    {{-- ({{ $departamento["count"] }}) --}}
                                </flux:option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div class="w-full sm:w-1/3">
                            <label for="dropdown2" class="block text-sm font-medium text-gray-700">Municipio</label>
                            <flux:select variant="listbox" multiple placeholder="Seleccione las opciones..."
                                indicator="checkbox" wire:model.live="filters.selectedMunicipiosIds" :filter="false">
                                <flux:option value="-1">Seleccionar Todo</flux:option>
                                @foreach ($filters->listOfMunicipios as $municipio)
                                <flux:option value="{{ $municipio['ciudad_id'] }}">
                                    {{ $municipio["nombre"]}}
                                    {{-- ({{ $municipio["count"] }}) --}}
                                </flux:option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div class="w-full sm:w-1/3">
                            <label for="dropdown3" class="block text-sm font-medium text-gray-700">Gestor</label>
                            <flux:select variant="listbox" multiple placeholder="Seleccione las opciones..."
                                indicator="checkbox" wire:model.live="filters.selectedGestoresIds">
                                <flux:option value="-1">Seleccionar Todo</flux:option>
                                @foreach ($filters->gestores() as $gestor)
                                <flux:option value="{{ $gestor['gestor_id'] }}">{{ $gestor["gestor"]}}
                                    {{-- ({{ $gestor["count"] }}) --}}
                                </flux:option>
                                @endforeach
                            </flux:select>
                        </div>
                    </div>

                    <div
                        class="flex flex-col items-start justify-start w-full gap-4 mt-6 sm:w-3/4 sm:flex-row sm:gap-2">
                        <div class="w-full sm:w-1/3">
                            <label for="dropdown1" class="block text-sm font-medium text-gray-700">Grupo</label>
                            <flux:select variant="listbox" multiple placeholder="Seleccione las opciones..."
                                indicator="checkbox" wire:model.live="filters.selectedGruposIds">
                                <flux:option value="-1">Seleccionar Todo</flux:option>
                                @foreach ($filters->grupos() as $grupo)
                                <flux:option value="{{ $grupo['grupo_id'] }}">{{ $grupo["nombre"]}}
                                     {{-- ({{ $grupo["count"]}}) --}}
                                </flux:option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div class="w-full sm:w-1/3">
                            <label for="dropdown2" class="block text-sm font-medium text-gray-700">Perfil</label>
                            <flux:select variant="listbox" multiple placeholder="Seleccione las opciones..."
                                indicator="checkbox" wire:model.live="filters.selectedPerfilesIds">
                                <flux:option value="-1">Seleccionar Todo</flux:option>
                                @foreach ($filters->perfiles() as $perfil)
                                <flux:option value="{{ $perfil['perfil_id'] }}">{{ $perfil["nombre"]}}
                                    {{-- ({{ $perfil["count"] }}) --}}
                                </flux:option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div class="w-full sm:w-1/3">
                            <label for="dropdown3" class="block text-sm font-medium text-gray-700">Sexo</label>
                            <flux:select variant="listbox" multiple placeholder="Seleccione las opciones..."
                                indicator="checkbox" wire:model.live="filters.selectedSexosIds">
                                <flux:option value="-1">Seleccionar Todo</flux:option>
                                @foreach ($filters->sexos() as $sexo)
                                <flux:option value="{{ $sexo['sexo_id'] }}">{{ $sexo["sexo"]}}
                                </flux:option>
                                @endforeach
                            </flux:select>
                        </div>
                    </div>

                </div>


                <livewire:financiero.coordinador.participante.index.table :$filters
                    :cohortePaisProyecto="$selectedCohortePaisProyecto" :paisProyecto="$selectedPaisProyecto" />


            </div>
        </div>


        @endif


    </div>
