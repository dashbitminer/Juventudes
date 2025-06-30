<div class="flow-root mt-8">

    <div class="sm:grid mb-8">
        <div class="mt-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <x-admin.proyecto.participantes.participante-filters-dropdowns :$gestores  />
            </div>
        </div>
    </div>

    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid mt-8">
        <x-admin.proyecto.participantes.search />

        <x-admin.proyecto.participantes.bulk-actions />
    </div>

    <div class="-mx-4 -my-2 overflow-x-auto lg:overflow-visible sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="relative">
                <table class="min-w-full divide-y divide-gray-300 table-fixed">
                    <tr>
                        <!--<th class="p-3 text-sm font-semibold text-left text-gray-900">
                            <div class="flex items-center">
                                <x-admin.user.check-all />
                            </div>
                        </th>-->
                        <th scope="col" class="w-1/6 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                            <x-participante.index.sortable column="nombres" :$sortCol :$sortAsc>
                                <div class="whitespace-nowrap">Nombre</div>
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class=" px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            <x-participante.index.sortable column="rol" :$sortCol :$sortAsc>
                                Gestor
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            <x-participante.index.sortable column="socio" :$sortCol :$sortAsc>
                                Socio Implementador
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            <x-participante.index.sortable column="fecha" :$sortCol :$sortAsc>
                                <div class="whitespace-nowrap">Fecha de registro</div>
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($cohorteProyectoPartipantes as $cohorteProyectoPartipante)
                        <tr wire:key='rand-{{ $cohorteProyectoPartipante->participante->id }}'>
                            <!--<td class="p-3 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    <input wire:model="selectedRecordIds" value="{{ $cohorteProyectoPartipante->participante->id }}"
                                        type="checkbox" class="border-gray-300 rounded shadow">
                                </div>
                            </td>-->
                            <td class="py-5 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">{{ $cohorteProyectoPartipante->participante->full_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500">
                                {{ $cohorteProyectoPartipante->participante->gestor->name ?? '' }}
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-900">
                                {{ $cohorteProyectoPartipante->participante->gestor->socioImplementador?->nombre ?? '' }}
                                <div class="text-gray-500">
                                {{ $cohorteProyectoPartipante->gestor->socioImplementador?->pais->nombre ?? '' }}
                                </div>
                            </td>
                            <td class="p-3 text-sm whitespace-nowrap">
                                {{ $cohorteProyectoPartipante->participante->dateForHumans() }}
                            </td>
                            <td class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">

                                <x-admin.proyecto.participantes.participante-row-dropdown :$cohorteProyectoPartipante wire:key='row-{{ $cohorteProyectoPartipante->participante->id}}' />

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div wire:loading wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                    class="absolute inset-0 bg-white opacity-50"></div>

                <div wire:loading.flex wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                    class="absolute inset-0 flex items-center justify-center">
                    <x-icon.spinner size="8" class="text-gray-500" />
                </div>
            </div>

        </div>
    </div>
    {{-- Pagination... --}}
    <div class="flex items-center justify-between pt-4">
        <div class="text-sm text-gray-700">
            @php
            $start = ($cohorteProyectoPartipantes->count() == 0 ) ? 0 : ($cohorteProyectoPartipantes->currentPage() - 1) * $cohorteProyectoPartipantes->perPage() + 1;
            $end = min($cohorteProyectoPartipantes->currentPage() * $cohorteProyectoPartipantes->perPage(), $cohorteProyectoPartipantes->total());
            @endphp
            Mostrando {{ $start }} a {{ $end }} de un total de {{
            \Illuminate\Support\Number::format($cohorteProyectoPartipantes->total()) }} registros
        </div>

        <div class="text-sm text-gray-700">
            Página actual: {{ $cohorteProyectoPartipantes->currentPage() }} de {{ $cohorteProyectoPartipantes->lastPage() }}
        </div>

        {{ $cohorteProyectoPartipantes->links('livewire.resultadouno.gestor.participante.index.pagination') }}

    </div>

</div>
