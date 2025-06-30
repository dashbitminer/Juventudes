<div>

    <div class="flow-root mt-8">

        <div class="flex flex-wrap mb-4 space-x-2">
        </div>

        <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">
            <x-participante.index.search />

            <x-estipendios.pago-bulk-actions />
        </div>

        {{-- <div class="overflow-x-auto -mx-4 -my-2 sm:-mx-6 lg:-mx-8"> --}}
            {{-- <div class="overflow-x-auto -mx-4 -my-2 lg:overflow-visible sm:-mx-6 lg:-mx-8">
                <div class="inline-block py-2 min-w-full align-middle sm:px-6 lg:px-8"> --}}
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <div class="overflow-y-auto max-h-[calc(100vh-220px)]">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="sticky top-0 z-10 bg-gray-50">
                                    <tr>
                                        <th class="p-3 text-sm font-semibold text-left text-gray-900">
                                            <div class="flex items-center">
                                                {{-- <x-participante.index.check-all /> --}}
                                            </div>
                                        </th>

                                        <th scope="col"
                                            class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-0">
                                            <div class="whitespace-nowrap">Numero Cuenta</div>
                                        </th>
                                        <th scope="col"
                                            class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-0">
                                            <x-participante.index.sortable column="nombres" :$sortCol :$sortAsc>
                                                <div class="whitespace-nowrap">Participante</div>
                                            </x-participante.index.sortable>
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            <x-participante.index.sortable column="socio" :$sortCol :$sortAsc>
                                                <div class="whitespace-nowrap">Socio</div>
                                            </x-participante.index.sortable>
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            <div class="whitespace-nowrap">Grupo</div>
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            <div class="whitespace-nowrap">Perfil</div>
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            <x-participante.index.sortable column="estado" :$sortCol :$sortAsc>
                                                Estado
                                            </x-participante.index.sortable>
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            <div class="whitespace-nowrap">Porcentaje</div>
                                        </th>
                                        <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                            <div class="whitespace-nowrap">Observaciones</div>
                                        </th>
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
                                                {{-- <input wire:model="selectedParticipanteIds" value="{{ $participante->id }}"
                                                    type="checkbox" class="rounded border-gray-300 shadow"> --}}
                                            </div>
                                        </td>
                                        <td class="py-5 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-0">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900">
                                                        {{ $participante->cohorteParticipanteProyecto[0]->numero_cuenta ?? '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-5 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-0">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900">{{ $participante->full_name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $participante->gestor->socioImplementador->nombre ?? "" }}
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $participante->grupoactivo?->grupo?->nombre ?? "No tiene grupo asignado" }}
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $estipendio->perfilParticipante->nombre ?? ""  }}
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            @if ($participante->grupoactivo)
                                            <div role="button" wire:click="selectParticipanteListaEstados('{{ $participante->id }}')"
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
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $participante->porcentaje_estipendio ?? '0.0' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $participante->observacion }}
                                        </td>
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

            <x-participante.grupos.drawer-lista-estado :$historial :$estados :$categorias :$razones :$selectedCategoria :$selectedRazon :$selectedEstado/>
    </div>
</div>
