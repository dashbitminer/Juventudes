<div class="flow-root mt-8">

    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">

        <x-alianza.index.search />

        <div class="flex col-span-5 gap-2 sm:justify-end">
            <div class="flex gap-2" >
                <x-alianza.index.filter-visualizador :$socios />
            </div>
            <x-alianza.index.bulk-actions />
        </div>

    </div>

    {{-- <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"> --}}
        <div class="-mx-4 -my-2 overflow-x-auto lg:overflow-visible sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="relative">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th class="p-3 text-sm font-semibold text-left text-gray-900">
                                    <div class="flex items-center">
                                        <x-alianza.index.check-all />
                                    </div>
                                </th>

                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                    <x-participante.index.sortable column="nombres" :$sortCol :$sortAsc>
                                        <div class="whitespace-nowrap">Nombre de organización</div>
                                    </x-participante.index.sortable>
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    <x-participante.index.sortable column="edad" :$sortCol :$sortAsc>
                                        Nombre de contacto
                                    </x-participante.index.sortable>
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Ciudad
                                </th>
                                {{-- <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Tipo de sector
                                </th> --}}
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    <div class="whitespace-nowrap">Estado</div>
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
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($alianzas as $alianza)
                            <tr wire:key='rand-{{ $alianza->id }}'>
                                <td class="p-3 text-sm whitespace-nowrap">
                                    <div class="flex items-center">
                                        <input wire:model="selectedAlianzasIds" value="{{ $alianza->id }}"
                                            type="checkbox" class="border-gray-300 rounded shadow">
                                    </div>
                                </td>
                                <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ $alianza->nombre_organizacion }}
                                            </div>
                                            <div class="mt-1 text-gray-500">{{ $alianza->telefono_contacto }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    <div class="text-gray-900">{{ $alianza->nombre_contacto }}</div>
                                    <div class="mt-1 text-gray-500">{{ $alianza->email_contacto }}</div>
                                </td>
                                <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    <div class="text-gray-900">{{ $alianza->ciudad->nombre }}</div>
                                    <div class="mt-1 text-gray-500">{{ $alianza->ciudad->departamento->nombre }}</div>

                                </td>
                                {{-- <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 rounded-md bg-green-50 ring-1 ring-inset ring-green-600/20">Active</span>
                                </td> --}}
                                <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                    @php
                                        $estado = $alianza->estado_display;
                                    @endphp
                                    <div
                                        role="button"
                                        wire:click="$dispatch('openEstadoHistorial', { id: {{ $alianza->id}}, model: 'alianza' })""
                                        class="cursor-pointer rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $estado['color'] }}-600 text-xs bg-{{ $estado['color'] }}-100">
                                        <div>{{ $estado['nombre'] ?? 'registrado' }}</div>
                                        <x-dynamic-component :component="$estado['icon']" />
                                    </div>
                                </td>
                                <td>
                                    {{ $alianza->created_at->format('d/m/Y g:i A') }}
                                </td>
                                <td
                                class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                    <div class="flex items-center justify-end">
                                        <x-alianza.index.row-dropdown :$alianza
                                            :pais="$pais->slug" :proyecto="$proyecto->slug"
                                            :nombre="$alianza->nombre_organizacion"
                                            wire:key='row-alianza-{{ $alianza->id}}' />
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center">
                                    No se ha creado ninguna Alianza
                                </td>
                            </tr>
                            @endforelse
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
                $start = ($alianzas->currentPage() - 1) * $alianzas->perPage() + 1;
                $end = min($alianzas->currentPage() * $alianzas->perPage(), $alianzas->total());
                @endphp
                Mostrando {{ $start }} a {{ $end }} de un total de {{
                \Illuminate\Support\Number::format($alianzas->total()) }} registros
            </div>

            <div class="text-sm text-gray-700">
                Página actual: {{ $alianzas->currentPage() }} de {{ $alianzas->lastPage() }}
            </div>

            {{ $alianzas->links('livewire.resultadouno.gestor.participante.index.pagination') }}
        </div>

        
        <livewire:resultadotres.gestor.estados.historial  />

    </div>
