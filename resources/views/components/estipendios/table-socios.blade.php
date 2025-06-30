<div class="flow-root mt-8">

    {{-- prueba: {{ $cohortePaisProyecto }} --}}

    <div class="flex flex-col justify-end grid-cols-1 my-4 sm:grid">


        <x-estipendios.bulk-actions-vista-grupos />

    </div>



    {{-- <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8"> --}}
        <div class="-mx-4 -my-2 overflow-x-auto lg:overflow-visible sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="relative">
                    <table class="min-w-full divide-y divide-gray-300">
                        <tr>
                            <th class="p-3 text-sm font-semibold text-left text-gray-900">
                                <div class="flex items-center">
                                    <x-estipendios.check-all-estipendios />
                                </div>
                            </th>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-gray-900 sm:pl-0">
                                Mes
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                Anio
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
                            <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">
                                <div class="whitespace-nowrap">Fecha de registro</div>
                            </th>
                            <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-0">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $lastCombination = null;
                            @endphp
                            @foreach ($estipendios as $estipendio)
                                @php
                                    $currentCombination = $estipendio->mes . '-' . $estipendio->anio;
                                @endphp

                                @if ($currentCombination !== $lastCombination)
                                    <tr class="border-t border-gray-200">
                                        <th colspan="8" scope="colgroup" class="py-2 pl-4 pr-3 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:pl-3">
                                            {{ \Carbon\Carbon::create()->month($estipendio->mes)->locale('es')->monthName }} {{ $estipendio->anio }}
                                        </th>
                                    </tr>
                                    @php
                                        $lastCombination = $currentCombination;
                                    @endphp
                                @endif

                                <tr wire:key='rand-{{ $estipendio->id }}'>
                                    <td class="p-3 text-sm whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input wire:model="selectedParticipanteIds" value="{{ $estipendio->id }}" type="checkbox" class="border-gray-300 rounded shadow">
                                        </div>
                                    </td>
                                    <td class="py-5 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::create()->month($estipendio->mes)->locale('es')->monthName }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $estipendio->anio ?? "" }}
                                    </td>
                                    <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $estipendio->socioImplementador->nombre ?? "" }}
                                    </td>
                                    <td class="px-3 py-5 text-sm text-gray-500">
                                        <div class="text-gray-900">{{ $estipendio->perfilParticipante->nombre ?? "" }}</div>
                                    </td>

                                    <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $estipendio->is_closed == 0 ? 'activo' : 'cerrado' }}
                                    </td>

                                    <td class="p-3 text-sm whitespace-nowrap">
                                        {{ $estipendio->fecha_inicio->format("d/m/Y") }} - {{
                                        $estipendio->fecha_fin->format("d/m/Y") }}
                                    </td>

                                    {{--
                                    Route::get('/pais/{pais}/proyecto/{proyecto}/cohorte/{cohorte}/estipendios/{estipendio}/configurar',
                                    IndexEstipendios::class)
                                    ->name('estipendios.mecla.configurar'); --}}

                                    <td
                                        class="relative py-5 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                        <div class="flex items-center justify-end">
                                            @if ($estipendio->is_closed == 0)
                                            <a href="{{ route('estipendios.mecla.configurar', [$pais,$proyecto,$cohorte,$estipendio->id]) }}"
                                                wire:navigate
                                                class="mr-2 text-indigo-600 hover:text-indigo-900">Configurar</a>
                                            |

                                            <button wire:click="delete('{{ $estipendio->id }}')"
                                                wire:confirm="¿Esta segura(o) que desea eliminar el registro {{ $estipendio->id }}?"
                                                class="ml-2 text-red-600 hover:text-red-900">Eliminar</button>

                                            @endif
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
                $start = ($estipendios->currentPage() - 1) * $estipendios->perPage() + 1;
                $end = min($estipendios->currentPage() * $estipendios->perPage(), $estipendios->total());
                @endphp
                Mostrando {{ $start }} a {{ $end }} de un total de {{
                \Illuminate\Support\Number::format($estipendios->total()) }} registros
            </div>

            <div class="text-sm text-gray-700">
                Página actual: {{ $estipendios->currentPage() }} de {{ $estipendios->lastPage() }}
            </div>

            {{ $estipendios->links('livewire.resultadouno.gestor.participante.index.pagination') }}
        </div>
    </div>
