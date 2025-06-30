<div>
    <!-- Expand button -->
    <div class="flex justify-end mb-4">
        <button @click="isFullWidth = !isFullWidth"
            class="inline-flex items-center px-3 py-2 mt-4 mr-4 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <template x-if="!isFullWidth">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5">
                    </path>
                </svg>
            </template>
            <template x-if="isFullWidth">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25">
                    </path>
                </svg>
            </template>
            <span class="ml-2" x-text="isFullWidth ? 'Reducir' : 'Expandir'"></span>
        </button>
    </div>

    <!-- Main container with dynamic width -->
    <div>
        <x-slot:header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Bancarización: {{ __('Estipendios') }}
            </h2>
            <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
            </x-slot>

            <div>

                <div class="grid hidden grid-cols-1 gap-4 sm:grid-cols-4">
                    <div class="col-span-1">
                        <label for="pais" class="block text-sm font-medium text-gray-700">Socio:</label>

                        <flux:select variant="listbox" placeholder="Seleccione un pais" searchable clear="close"
                            wire:model.live='filters.paisSelected'>
                            @foreach ($socios as $socio)
                            <flux:option value="{{ $socio->id }}">
                                {{ $socio->nombre }}
                            </flux:option>
                            @endforeach
                        </flux:select>

                    </div>
                    <div class="col-span-1">
                        <label for="departamento" class="block text-sm font-medium text-gray-700">Pais:</label>

                        <flux:select variant="listbox" placeholder="Seleccione un departamento" searchable clear="close"
                            wire:model.live='filters.departamentoSelected'>
                            {{-- @foreach ($departamentos as $departamento)
                            <flux:option value="{{ $departamento->fkCodeState }}">
                                {{ $departamento->name }}
                            </flux:option>
                            @endforeach --}}
                        </flux:select>

                    </div>
                    <div class="col-span-1">
                        <label for="municipio" class="block text-sm font-medium text-gray-700">Sede:</label>

                        <flux:select variant="listbox" placeholder="Seleccione un municipio" searchable clear="close"
                            wire:model.live='filters.municipioSelected'>
                            {{-- @foreach ($municipios as $municipio)
                            <flux:option value="{{ $municipio->fkCodeMunicipality }}">
                                {{ $municipio->name }}
                            </flux:option>
                            @endforeach --}}
                        </flux:select>

                    </div>
                    <div class="col-span-1">
                        <label for="sede" class="block text-sm font-medium text-gray-700">Perfil:</label>

                        <flux:select variant="listbox" placeholder="Seleccione las opciones" searchable multiple
                            clear="close" wire:model.live='filters.escuelaSelected'>
                            {{-- @foreach ($escuelas as $escuela)
                            <flux:option value="{{ $escuela->school_id }}">
                                {{ $escuela->name }}
                            </flux:option>
                            @endforeach --}}
                        </flux:select>


                    </div>
                </div>

                <form wire:submit="generar">
                    <div class="flex items-center mt-4">
                        <div class="mr-4">
                            <label for="month" class="block text-sm font-medium text-gray-700">Mes:</label>
                            <select id="month" name="month"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                wire:model='form.selectedMes'>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            <x-input-error :messages="$errors->get('form.selectedMes')" class="mt-2" />
                        </div>
                        <div class="mr-4">
                            <label for="year" class="block text-sm font-medium text-gray-700">Año:</label>
                            <select id="year" name="year"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                wire:model='form.selectedAnio'>
                                @for ($i = now()->year; $i >= 2025; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <x-input-error :messages="$errors->get('form.selectedAnio')" class="mt-2" />
                        </div>
                        <div class="mr-4">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de Inicio:</label>
                            <input type="date" id="start_date" name="start_date"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                wire:model='form.fechaInicio'>
                            <x-input-error :messages="$errors->get('form.fechaInicio')" class="mt-2" />
                        </div>
                        <div class="mr-4">
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha de Fin:</label>
                            <input type="date" id="end_date" name="end_date"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                wire:model='form.fechaFin'>
                            <x-input-error :messages="$errors->get('form.fechaFin')" class="mt-2" />
                        </div>
                        <div class="mt-6">

                            <flux:button type="submit" variant="primary">
                                Generar
                            </flux:button>

                            {{-- <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Generar
                            </button> --}}
                        </div>
                    </div>



                </form>


                <div class="mt-6">
                    <livewire:financiero.mecla.estipendios.index.table :$cohortePaisProyecto :$pais :$proyecto :$cohorte :$form/>
                    {{--
                    <livewire:financiero.coordinador.estipendios.index.table :$filters /> --}}
                </div>
            </div>
    </div>
</div>
