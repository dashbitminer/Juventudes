<div>
    {{-- <div class="flex flex-wrap mb-4 space-x-2">
        @foreach ($agrupaciones as $agrupacion)
        <div class="flex items-center px-2 py-1 mb-2 space-x-1 text-white rounded-full"
            style="background-color: {{ $agrupacion['color'] }}">
            <span class="w-32 truncate cursor-pointer" wire:click='editarAgrupamiento({{ $agrupacion["nombre"] }})'>{{
                Str::limit($agrupacion["nombre"], 20) }}</span>
            <button class="focus:outline-none" x-on:click="alert(2)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        @endforeach

        <button
            class="px-2 py-1 text-lg text-blue-500 border border-blue-500 border-dotted rounded-full focus:outline-none"
            x-on:click="$wire.openDrawerView = true">+</button>
    </div> --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="overflow-y-auto max-h-[calc(100vh-220px)]">
            <table>
                <thead>
                    <tr>
                        <th
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                            <div class="flex items -center">
                                <input type="checkbox"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded shadow-sm">
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                            Participante</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                            Socio
                            Implementador</th>
                        {{-- <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                            Grupo
                        </th> --}}
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                            Perfil
                        </th>
                        {{-- <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                            Estado
                        </th> --}}
                        {{-- @foreach ($agrupaciones as $agrupacion)
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase"
                            style="background-color: {{ $agrupacion['color'] }}">{{ $agrupacion["nombre"] }}</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase"
                            style="background-color: {{ $agrupacion['color'] }}">% {{ $agrupacion["nombre"] }}</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase"
                            style="background-color: {{ $agrupacion['color'] }}">Alerta</th>
                        @endforeach --}}
                        {{-- <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Promedio
                            de cumplimiento</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Alerta
                            general</th>
                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Porcentaje</th> --}}
                        {{-- <th scope="col"
                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                            Observaciones</th> --}}
                        <th scope="col" class="sr-only">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($participantes as $participante)
                    <tr wire:key='rand-
                        {{ $estipendio->id }}'>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items center">
                                <input type="checkbox"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded shadow-sm">
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items center">
                                <div class="ml-4">
                                    {{ $participante->full_name }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $participante->gestor->socioImplementador->nombre ??
                            '' }}</td>
                        {{-- <td class="px-6 py-4 whitespace-nowrap"> {{ $participante->grupoactivo->grupo->nombre ?? "" }}
                        </td> --}}
                        <td class="px-6 py-4 whitespace-nowrap">Perfil A</td>
                        {{-- <td class="px-6 py-4 whitespace-nowrap">
                            @if ($participante->grupoactivo)
                            <div role="button"
                                class="rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $participante->grupoactivo->lastEstadoParticipante->estado->color }}-600 text-xs bg-{{ $participante->grupoactivo->lastEstadoParticipante->estado->color }}-100">
                                <div> {{ $participante->grupoactivo->lastEstadoParticipante->estado->nombre ??
                                    "registrado"
                                    }} </div>
                                <x-dynamic-component
                                    :component="$participante->grupoactivo->lastEstadoParticipante->estado->icon" />
                            </div>
                            @else
                            <div class="">
                                No tiene estado asignado aún
                            </div>
                            @endif
                        </td> --}}


                        {{-- @foreach ($agrupaciones as $agrupacion)
                        <td class="px-6 py-4 whitespace-nowrap " style="background-color: {{ $agrupacion['color'] }}">{{
                            $agrupacion["nombre"] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap " style="background-color: {{ $agrupacion['color'] }}">{{
                            $agrupacion["denominador"] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap " style="background-color: {{ $agrupacion['color'] }}">{{
                            $agrupacion["color"] }}</td>
                        @endforeach --}}


                        {{-- <td class="px-6 py-4 whitespace-nowrap">98.00</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <svg class="w-6 h-6 font-bold text-green-500 border-double" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7">
                                </path>
                            </svg>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">90%</td> --}}
                        {{-- <td class="px-6 py-4 whitespace-nowrap">this is random text</td> --}}
                        <td>
                            <x-estipendios.row-dropdown :$participante :nombre="$participante->full_name"
                                wire:key='row-participante-{{ $participante->id}}' />
                        </td>
                    </tr>
                    @endforeach
            </table>
        </div>
    </div>


    <x-estipendios.drawer-ver-grupo />

</div>
