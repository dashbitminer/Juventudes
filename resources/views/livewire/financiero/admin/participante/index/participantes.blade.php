<div class="flow-root mt-8">

    {{-- prueba: {{ $cohortePaisProyecto }} --}}

    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">
        <x-participante.index.search />

        {{--
        <x-bancarizacion.bulk-actions-admin /> --}}
        <x-bancarizacion.bulk-participantes-actions />

    </div>

    {{-- <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"> --}}
        <div class="-mx-4 -my-2 overflow-x-auto lg:overflow-visible sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="relative">
                    <table class="min-w-full divide-y divide-gray-300">
                        <tr>
                            <th class="p-3 text-sm font-semibold text-left text-gray-900">
                                <div class="flex items-center">
                                    <x-participante.index.check-participantes-bancarizacion-all />
                                </div>
                            </th>

                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                <x-participante.index.sortable column="nombres" :$sortCol :$sortAsc>
                                    <div class="whitespace-nowrap">Participante</div>
                                </x-participante.index.sortable>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <x-participante.index.sortable column="edad" :$sortCol :$sortAsc>
                                    Grupo
                                </x-participante.index.sortable>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <x-participante.index.sortable column="perfil" :$sortCol :$sortAsc>
                                    Monto
                                </x-participante.index.sortable>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <x-participante.index.sortable column="perfil" :$sortCol :$sortAsc>
                                    Ciudad
                                </x-participante.index.sortable>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Coordinador
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
                            @foreach ($records as $participantes)
                            <tr wire:key='rand-{{ $participantes->participante->id }}'
                                x-data="{ isSelected: $wire.selectedParticipanteIds.includes('{{ $participantes->participante->id }}') }"
                                :class="{ 'bg-gray-50': isSelected }" x-init="$watch('$wire.selectedParticipanteIds', () => {
                                        isSelected = $wire.selectedParticipanteIds.includes('{{ $participantes->participante->id }}')
                                        {{-- console.log($wire.selectedRecordIds) --}}
                                    })
                            ">
                                <td class="p-3 text-sm whitespace-nowrap"
                                    :class="{ 'border-l-4 border-l-indigo-500': isSelected }">
                                    <div class="flex items-center">
                                        <input wire:model="selectedParticipanteIds"
                                            value="{{ $participantes->participante->id }}" type="checkbox"
                                            class="border-gray-300 rounded shadow">
                                    </div>
                                </td>
                                <td class="py-5 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{
                                                $participantes->participante->full_name }}</div>
                                            <div class="mt-1 text-gray-500">{{
                                                $participantes->participante->documento_identidad }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-5 text-sm text-gray-500">
                                    {{ $participantes->bancarizacionGrupo->nombre ?? '' }}
                                    @if($participantes->bancarizacionGrupo->monto !== null)
                                    <div class="mt-1 text-gray-500">$ {{
                                        number_format($participantes->bancarizacionGrupo->monto, 2) }}
                                    </div>
                                    @endif
                                </td>
                                <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    @if($participantes->monto !== null)
                                    <div class="mt-1 text-gray-500">$ {{ number_format($participantes->monto, 2) }}
                                    </div>
                                    @endif
                                </td>
                                <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    <div class="text-gray-900">{{ $participantes->participante->ciudad->nombre ?? "" }}
                                    </div>
                                    <div class="mt-1 text-gray-500">{{
                                        $participantes->participante->ciudad->departamento->nombre ?? "" }}</div>
                                </td>

                                <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $participantes->bancarizacionGrupo->user->name ?? '' }}
                                </td>

                                <td class="p-3 text-sm whitespace-nowrap">
                                    {{ $participantes->participante->created_at->format("d/m/Y g:i A") }}
                                </td>
                                <td
                                    class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                    <div class="flex items-center justify-end">
                                        <x-bancarizacion.row-dropdown-participantes-admin
                                            :participante="$participantes->participante" />

                                    </div>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div wire:loading wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                        class="absolute inset-0 bg-white opacity-50"></div>

                    <div wire:loading.flex
                        wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
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
                $start = ($records->currentPage() - 1) * $records->perPage() + 1;
                $end = min($records->currentPage() * $records->perPage(), $records->total());
                @endphp
                Mostrando {{ $start }} a {{ $end }} de un total de {{
                \Illuminate\Support\Number::format($records->total()) }} registros
            </div>

            <div class="text-sm text-gray-700">
                Página actual: {{ $records->currentPage() }} de {{ $records->lastPage() }}
            </div>

            {{ $records->links('livewire.resultadouno.gestor.participante.index.pagination') }}
        </div>

        <x-bancarizacion.drawer-editar-participante-en-grupo :$lista />

        <!-- Success Alert... -->
        {{-- <x-notifications.alert-success-notification>
            <p class="text-sm font-medium text-gray-900">¡Guardado exitosamente!</p>
            <p class="mt-1 text-sm text-gray-500">El grupo se ha guardo exitosamente con todos los participantes.</p>
        </x-notifications.alert-success-notification> --}}

    </div>
