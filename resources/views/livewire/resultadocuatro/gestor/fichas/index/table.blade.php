<div class="flow-root mt-8">

    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">
        <x-participante.index.search />
        <div class="flex col-span-5 gap-2 sm:justify-end">
            <div class="flex gap-2">
                <x-participante.grupos.filter-grupos :$filters/>
            </div>
            <x-resultadocuatro.participantes.bulk-actions />
        </div>
    </div>

    <div class="overflow-x-auto -mx-4 -my-2 lg:overflow-visible sm:-mx-6 lg:-mx-8">
        <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8">
            <div class="relative">
                <table class="min-w-full divide-y divide-gray-300">
                    <tr>
                        @can('Eliminar fichas R4')
                        <th class="p-3 text-sm font-semibold text-left text-gray-900">
                            <div class="flex items-center">
                                <x-participante.index.check-all />
                            </div>
                        </th>
                        @endcan
                        <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-0">
                            <x-participante.index.sortable column="nombres" :$sortCol :$sortAsc>
                                <div class="whitespace-nowrap">Nombre </div>
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                            <x-participante.index.sortable column="edad" :$sortCol :$sortAsc>
                                Edad
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                            <div class="whitespace-nowrap">Grupo</div>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                            <div class="whitespace-nowrap">Estado</div>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                            Ciudad
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                            Documento de identidad
                        </th>
                        @if(auth()->user()->can('Ver participantes mi pais R4') || auth()->user()->can('Ver participantes mi socio implementador R4'))
                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                            Socio implementador
                        </th>
                        @endif
                        @if(auth()->user()->can('Crear fichas R4') || auth()->user()->can('Cambiar estado R4'))
                        <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                            <span class="sr-only">Acciones</span>
                        </th>
                        @endif
                    </tr>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($participantes as $participante)
                        <tr wire:key='rand-{{ $participante->id }}'>
                            @can('Eliminar fichas R4')
                            <td class="p-3 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    <input wire:model="selectedParticipanteIds" value="{{ $participante->id }}"
                                        type="checkbox" class="rounded border-gray-300 shadow">
                                </div>
                            </td>
                            @endcan
                            <td class="py-5 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">

                                        @if(auth()->user()->can('Ver fichas R4'))
                                            <a href="{{ route('fichas.show', [$pais,$proyecto,$cohorte,$participante]) }}"
                                                wire:navigate>
                                                <div class="font-medium text-gray-900 underline decoration-sky-500">{{ $participante->full_name }}</div>
                                                <div class="mt-1 text-gray-500">{{ $participante->sexo == 1 ? 'Mujer' :
                                                    'Hombre' }}</div>
                                            </a>
                                        @else
                                            <div class="font-medium text-gray-900">{{ $participante->full_name }}</div>
                                            <div class="mt-1 text-gray-500">{{ $participante->sexo == 1 ? 'Mujer' :
                                                'Hombre' }}</div>
                                        @endif

                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                {{ $participante->edad }} años
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                {{ $participante->grupoactivo->grupo->nombre ?? '' }}
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                @if ($participante->grupoactivo)
                                <div class="flex flex-col items-center">

                                    <div role="button" wire:click="selectParticipanteListaEstados('{{ $participante->id }}')"
                                        class="cursor-pointer rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $participante->grupoactivo->lastEstadoParticipante->estado->color }}-600 text-xs bg-{{ $participante->grupoactivo->lastEstadoParticipante->estado->color }}-100">
                                        <div> {{ $participante->grupoactivo->lastEstadoParticipante->estado->nombre ??
                                            "registrado" }} </div>
                                        <x-dynamic-component
                                            :component="$participante->grupoactivo->lastEstadoParticipante->estado->icon" />
                                    </div>

                                </div>
                                @else
                                <div class="">
                                    No tiene estado asignado aún
                                </div>
                                @endif
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                <div class="text-gray-900">{{ $participante->ciudad->nombre ?? '' }}</div>
                                <div class="mt-1 text-gray-500">{{ $participante->ciudad->departamento->nombre ?? '' }}
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                {{ $participante->documento_identidad ?? '' }}
                            </td>
                            @if(auth()->user()->can('Ver participantes mi pais R4') || auth()->user()->can('Ver participantes mi socio implementador R4'))
                            <td class="px-3 py-5 text-sm text-gray-500">
                                {{ $participante->gestor->socioImplementador->nombre ?? '' }}
                            </th>
                            @endif


                            @if(auth()->user()->can('Crear fichas R4') || auth()->user()->can('Cambiar estado R4'))
                            <td
                                class="relative py-5 pr-4 pl-3 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                <div class="flex justify-end items-center">
                                    <x-resultadocuatro.participantes.row-dropdown :$participante :$pais :$proyecto
                                        :$cohorte :nombre="$participante->full_name"
                                        wire:key='row-participante-{{ $participante->id}}' />
                                </div>
                            </td>
                            @endif

                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div wire:loading wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                    class="absolute inset-0 bg-white opacity-50"></div>

                <div wire:loading.flex wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                    class="flex absolute inset-0 justify-center items-center">
                    <x-icon.spinner size="8" class="text-gray-500" />
                </div>
            </div>

            <x-resultadocuatro.table.pagination :page="$participantes" />

            <x-participante.grupos.drawer-estado :$lista :$cohorte :$paisProyecto :$cohortePaisProyecto :$estados :$categorias :$razones />

            <x-participante.grupos.drawer-lista-estado :$lista :$historial :$estados :$categorias :$razones :$selectedCategoria :$selectedRazon :$selectedEstado/>

        </div>
    </div>
</div>
