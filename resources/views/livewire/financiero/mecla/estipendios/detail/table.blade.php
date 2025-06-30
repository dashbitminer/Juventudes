<div>

@php
    $isFirefox = str_contains(request()->header('User-Agent'), 'Firefox');
@endphp

    <div class="flow-root mt-8">

        <div class="flex flex-wrap mb-4 space-x-2">
            @foreach ($agrupaciones as $agrupacion)
            <div class="flex items-center px-2 py-1 mb-2 space-x-1 text-white rounded-full"
                style="background-color: {{ $agrupacion['color'] }}">
                <span class="w-32 truncate cursor-pointer"
                    wire:click='editarAgrupamiento({{ $agrupacion["id"] }})'>{{
                    Str::limit($agrupacion["nombre"], 20) }}</span>
                <button class="focus:outline-none"
                    wire:click="eliminarAgrupacion({{ $agrupacion['id'] }})"
                    wire:confirm="Esta seguro que desea eliminar la agrupacion?">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            @endforeach

            <button
                class="px-2 py-1 text-lg text-blue-500 rounded-full border border-blue-500 border-dotted focus:outline-none"
                x-on:click="$wire.openDrawerView = true">+</button>
        </div>

        <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">
            <x-participante.index.search />

            <x-estipendios.bulk-actions />

        </div>

        {{-- <div class="overflow-x-auto -mx-4 -my-2 sm:-mx-6 lg:-mx-8"> --}}
            {{-- <div class="overflow-x-auto -mx-4 -my-2 lg:overflow-visible sm:-mx-6 lg:-mx-8">
                <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8"> --}}
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <div class="overflow-y-auto max-h-[calc(100vh-220px)]">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="sticky top-0 z-20 bg-gray-50">
                                    <tr>
                                        <th class="p-3 text-sm font-semibold text-left text-gray-900">
                                            <div class="flex items-center">
                                                <x-participante.index.check-all />
                                            </div>
                                        </th>

                                        <th scope="col"
                                            class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-0 sticky left-0 z-20 bg-gray-50" >
                                            <x-participante.index.sortable column="nombres" :$sortCol :$sortAsc>
                                                <div class="whitespace-nowrap px-2">Participante</div>
                                            </x-participante.index.sortable>
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            Socio
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            Perfil
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            Estado
                                        </th>

                                        @foreach ($agrupaciones as $agrupacion)
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-white text-nowrap"
                                            style="background-color: {{ $agrupacion['color'] }}">
                                            {{ $agrupacion["nombre"] }}
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-white text-nowrap"
                                            style="background-color: {{ $agrupacion['color'] }}">
                                            % {{ $agrupacion["nombre"] }}
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-white"
                                            style="background-color: {{ $agrupacion['color'] }}">
                                            Alerta
                                        </th>
                                        @endforeach

                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            <div class="whitespace-nowrap">Promedio de cumplimiento</div>
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            <div class="whitespace-nowrap">Alerta general</div>
                                        </th>
                                        {{-- <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            <div class="whitespace-nowrap">Porcentaje</div>
                                        </th> --}}
                                        {{-- <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            <div class="whitespace-nowrap">Observaciones</div>
                                        </th>
                                        <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                                            <span class="sr-only">Acciones</span>
                                        </th> --}}
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($participantes as $participante)
                                    <tr wire:key='rand-{{ $participante->id }}'
                                        x-data="{ isSelected: $wire.selectedParticipanteIds.includes('{{ $participante->id }}') }"
                                        :class="{ 'bg-gray-50': isSelected }" x-init="$watch('$wire.selectedParticipanteIds', () => {
                                        isSelected = $wire.selectedParticipanteIds.includes('{{ $participante->id }}')
                                        {{-- console.log($wire.selectedRecordIds) --}}
                                    })">
                                        <td class="p-3 text-sm whitespace-nowrap"
                                            :class="{ 'border-l-4 border-l-indigo-500': isSelected }">
                                            <div class="flex items-center">
                                                <input wire:model="selectedParticipanteIds" value="{{ $participante->id }}"
                                                    type="checkbox" class="rounded border-gray-300 shadow">
                                            </div>
                                        </td>
                                        <td class=" text-sm whitespace-nowrap sm:pl-0 sticky left-0 z-10 p-0 bg-white" :class="isSelected ? 'bg-gray-50': 'bg-white'">
                                            <div  style="{{ $isFirefox ? 'display:none;' : '' }}" class="absolute top-0 left-0 w-full border-t {{ $loop->first ? 'border-gray-300' : 'border-gray-200'}}"></div>
                                            <div class="w-full flex items-center px-2 py-5 pr-3 pl-4 ">
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900">{{ $participante->full_name }}</div>
                                                    <div class="mt-1 text-gray-500">{{ $participante->sexo == 1 ? 'Mujer' : 'Hombre' }} - {{ $participante->edad }} años</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500">
                                            <div class="min-w-[150px] max-w-[300px]">
                                                <div class="w-auto">
                                                    {{ $participante->gestor->socioImplementador->nombre ?? "" }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $estipendio->perfilParticipante->nombre ?? ""  }}
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            @if ($participante->grupoactivo)
                                            <div role="button"
                                                class="rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $participante->grupoactivo->lastEstadoParticipante->estado->color }}-600 text-xs bg-{{ $participante->grupoactivo->lastEstadoParticipante->estado->color }}-100">
                                                <div>{{ $participante->grupoactivo->lastEstadoParticipante->estado->nombre ?? "registrado" }}</div>
                                                <x-dynamic-component :component="$participante->grupoactivo->lastEstadoParticipante->estado->icon" />
                                            </div>
                                            @else
                                            <div class="">
                                                No tiene estado asignado aún
                                            </div>
                                            @endif
                                        </td>


                                        @foreach ($agrupaciones as $agrupacion)
                                            @isset($agrupacion['participantes'][$participante->id])
                                                <td class="px-6 py-4 whitespace-nowrap" style="background-color: {{ $agrupacion['color'] }}">
                                                    {{ $agrupacion['participantes'][$participante->id]["suma"] }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap" style="background-color: {{ $agrupacion['color'] }}">
                                                    {{ $agrupacion['participantes'][$participante->id]["porcentaje"] }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap" style="background-color: {{ $agrupacion['color'] }}">
                                                    <x-estipendios.alerts-icon :alert="$agrupacion['participantes'][$participante->id]['alerta']" />
                                                </td>
                                            @else
                                                {{-- Registro para personas desertadas --}}
                                                <td class="px-6 py-4 whitespace-nowrap"
                                                    style="background-color: {{ $agrupacion['color'] }}">0.0</td>
                                                <td class="px-6 py-4 whitespace-nowrap"
                                                    style="background-color: {{ $agrupacion['color'] }}">0.0</td>
                                                <td class="px-6 py-4 whitespace-nowrap"
                                                    style="background-color: {{ $agrupacion['color'] }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 font-bold text-red-500 border-double">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                                                    </svg>
                                                </td>
                                            @endisset
                                        @endforeach


                                        <td class="px-6 py-4 whitespace-nowrap">{{ $participante->porcentaje ?? '0.0' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-estipendios.alerts-icon :alert="$participante->alerta" />
                                        </td>

                                        {{-- <td class="px-6 py-4 whitespace-nowrap">90%</td> --}}
                                        {{-- <td class="px-6 py-4 whitespace-nowrap">
                                            {{ Str::limit($participante->observacion, 20) }}
                                        </td>
                                        <td>
                                            <x-estipendios.row-dropdown :$participante :nombre="$participante->full_name"
                                                wire:key='row-participante-{{ $participante->id}}' />
                                        </td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div wire:loading
                            wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                            class="absolute inset-0 bg-white opacity-50"></div>

                        <div wire:loading.flex
                            wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                            class="flex absolute inset-0 justify-center items-center">
                            <x-icon.spinner size="8" class="text-gray-500" />
                        </div>
                    </div>

                {{-- </div>
            </div> --}}
            {{-- Pagination... --}}
            <div class="flex justify-between items-center pt-4">
                <div class="text-sm text-gray-700">
                    @php
                    $start = ($participantes->currentPage() - 1) * $participantes->perPage() + 1;
                    $end = min($participantes->currentPage() * $participantes->perPage(), $participantes->total());
                    @endphp
                    Mostrando {{ $start }} a {{ $end }} de un total de {{
                    \Illuminate\Support\Number::format($participantes->total()) }} registros
                </div>

                <div class="text-sm text-gray-700">
                    Página actual: {{ $participantes->currentPage() }} de {{ $participantes->lastPage() }}
                </div>

                {{ $participantes->links('livewire.resultadouno.gestor.participante.index.pagination') }}
            </div>

            <x-estipendios.drawer-ver-grupo :$actividades :$subactividades :$modulos :$submodulos />
            <x-estipendios.drawer-editar-grupo :$actividades :$subactividades :$modulos :$submodulos />

            <x-estipendios.drawer-revisar />

        </div>
