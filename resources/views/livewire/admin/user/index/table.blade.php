<div class="flow-root mt-8">

    <div class="sm:grid mb-8">
        <div class="mt-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <x-admin.user.user-filters-dropdowns :$socioImplementadores :$roles />
            </div>
        </div>
    </div>

    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid mt-8">
        <x-participante.index.search />

        <x-admin.user.bulk-actions />
    </div>

    <div class="-mx-4 -my-2 overflow-x-auto lg:overflow-visible sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="relative">
                <table class="min-w-full divide-y divide-gray-300 table-fixed">
                    <tr>
                        <th class="p-3 text-sm font-semibold text-left text-gray-900">
                            <div class="flex items-center">
                                <x-admin.user.check-all />
                            </div>
                        </th>
                        <th scope="col" class="w-1/6 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                            <x-participante.index.sortable column="nombres" :$sortCol :$sortAsc>
                                <div class="whitespace-nowrap">Nombre</div>
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                             Email
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            <x-participante.index.sortable column="socio" :$sortCol :$sortAsc>
                                Socio Implementador
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class=" px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            <x-participante.index.sortable column="rol" :$sortCol :$sortAsc>
                                Rol
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
                        @foreach ($users as $user)
                        <tr wire:key='rand-{{ $user->id }}'>
                            <td class="p-3 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    <input wire:model="selectedRecordIds" value="{{ $user->id }}"
                                        type="checkbox" class="border-gray-300 rounded shadow">
                                </div>
                            </td>
                            <td class="py-5 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                {{ $user->email }}
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-900">
                                {{ $user->socioImplementador?->nombre ?? '' }}
                                <div class="text-gray-500">
                                {{ $user->socioImplementador?->pais->nombre ?? '' }}
                                </div>
                            </td>
                            <td class="px-3 py-5 text-sm text-gray-500">
                                {{ $user->roles->pluck('name')->implode(', ') }}
                            </td>

                            <td class="p-3 text-sm whitespace-nowrap">
                                {{ $user->dateForHumans() }}
                            </td>
                            <td class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">

                                <x-admin.user.user-row-dropdown :$user wire:key='row-{{ $user->id}}' />

                                <div class="flex items-center justify-end">
                                    {{-- <x-common.row-dropdown :$formulario
                                        :pais="$pais->slug"
                                        :nombre="$formulario->full_name"
                                        wire:key='row-{{ $formulario->id}}' /> --}}
                                </div>

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
            $start = ($users->count() == 0 ) ? 0 : ($users->currentPage() - 1) * $users->perPage() + 1;
            $end = min($users->currentPage() * $users->perPage(), $users->total());
            @endphp
            Mostrando {{ $start }} a {{ $end }} de un total de {{
            \Illuminate\Support\Number::format($users->total()) }} registros
        </div>

        <div class="text-sm text-gray-700">
            Página actual: {{ $users->currentPage() }} de {{ $users->lastPage() }}
        </div>

        {{ $users->links('livewire.resultadouno.gestor.participante.index.pagination') }}

    </div>

</div>
