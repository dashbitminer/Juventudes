<div class="flow-root mt-8">

    <div
    class="flex flex-col items-start justify-start gap-4 sm:flex-row sm:justify-between sm:items-center">
        <div class="flex flex-col gap-1"></div>
    </div>

    <div class="flex flex-col sm:flex-row sm:space-x-4">
        <!-- First Select -->
        <div class="relative w-full sm:w-1/4">
            <select wire:model.live="selectedFormType"
                class="block w-full px-4 py-2 text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @foreach(App\Livewire\Resultadotres\Gestor\Visualizador\Enums\Formularios::cases() as $formType)
                <option value="{{ $formType->value }}">{{ $formType->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">

        <x-resultadotres.table.search :$placeholder />

        <div class="flex col-span-5 gap-2 sm:justify-end">
            <div class="flex gap-2" >
                <x-resultadotres.visualizador.filter-visualizador :$socios />
            </div>
            <x-resultadotres.visualizador.bulk-actions-visualizador />
        </div>
    </div>

    <div class="-mx-4 -my-2 overflow-x-auto lg:overflow-visible sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="relative">
                <table class="min-w-full divide-y divide-gray-300">
                    <tr>
                        <th class="p-3 text-sm font-semibold text-left text-gray-900">
                            <div class="flex items-center">
                                <x-resultadocuatro.table.check-all />
                            </div>
                        </th>
                        <th scope="col"
                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">

                            <div class="whitespace-nowrap">Registrador</div>
                        </th>
                        <th scope="col"
                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                            <x-participante.index.sortable column="nombre" :$sortCol :$sortAsc>
                                <div class="whitespace-nowrap">Nombre de Organizacion</div>
                            </x-participante.index.sortable>
                        </th>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                            <div class="whitespace-nowrap">Nombre de Contacto</div>
                        </th>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                            <div class="whitespace-nowrap">Ciudad</div>
                        </th>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                            <div class="whitespace-nowrap">Estado</div>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Fecha de registro
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">

                        </th>
                    </tr>
                    @forelse ($formularios as $formulario)
                        <tr wire:key='rand-{{ $formulario->id }}'>
                            <td class="p-3 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    <input wire:model="selectedIds"
                                        value="{{ $formulario->id }}"
                                        type="checkbox"
                                        class="border-gray-300 rounded shadow">
                                </div>
                            </td>
                            <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex ">
                                    <div class="font-medium text-gray-900">
                                        {{ $formulario->registrador->name ?? '' }}
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $formulario->nombre_organizacion ?? '' }}

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            @if($formulario->nombre_contacto)
                                                {{ $formulario->nombre_contacto }}
                                            @endif
                                            @if($formulario->nombre_persona_registra)
                                                {{ $formulario->nombre_persona_registra }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            @if($formulario->ciudad)
                                                <div class="text-gray-900">{{ $formulario->ciudad->nombre }}</div>
                                            @endif
                                            @if($formulario->ciudad->departamento)
                                                <div class="mt-1 text-gray-500">{{ $formulario->ciudad->departamento->nombre }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            <div
                                                role="button"
                                                wire:click="$dispatch('openEstadoHistorial', { id: {{ $formulario->id}}, model: '{{ $formShown }}' })"
                                                class="cursor-pointer rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $formulario->lastEstado->estado_registro->color }}-600 text-xs bg-{{ $formulario->lastEstado->estado_registro->color }}-100">
                                                <div> {{ $formulario->lastEstado->estado_registro->nombre ?? "" }}</div>
                                                <x-dynamic-component :component="$formulario->lastEstado->estado_registro->icon" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $formulario->created_at->format("d/m/Y g:i A") }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center justify-end">
                                    <x-resultadotres.visualizador.row-dropdown :$route
                                            :pais="$pais->slug"
                                            :proyecto="$proyecto->slug"
                                            :formulario="$formulario"
                                            wire:key='row-formulario-{{ $formulario->id}}' />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-4 text-center">
                                No se encontraron registros
                            </td>
                        </tr>
                    @endforelse

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

    <x-resultadocuatro.table.pagination :page="$formularios" />
    <livewire:resultadotres.gestor.estados.historial />
</div>
