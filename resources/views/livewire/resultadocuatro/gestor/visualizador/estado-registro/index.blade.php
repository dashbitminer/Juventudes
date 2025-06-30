<div class="space-y-10 divide-y divide-gray-900/10">

    <div class="grid grid-cols-1 gap-x-8 py-10 gap-y-8 md:grid-cols-3">
        <div class="px-4 sm:px-0">
            <h2 class="text-base font-semibold leading-7 text-gray-900"></h2>
            <p class="mt-1 text-sm leading-6 text-gray-600"></p>
        </div>
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
            <div class="px-4 py-6 sm:p-8 overflow-x-auto">
                <div class="w-[800px]  sm:w-full space-y-10">
                    @if ($estados)
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Estado de Registro</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Comentario</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Por</th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estados as $estado)
                                    <tr wire:key="{{ $estado->id }}" class="odd:bg-white even:bg-slate-50">
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            <div class="rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $estado->estado_registro->color }}-600 text-xs bg-{{ $estado->estado_registro->color }}-100">
                                                <div>{{ $estado->estado_registro->nombre ?? "registrado" }}</div>
                                                <x-dynamic-component :component="$estado->estado_registro->icon" />
                                            </div>
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $estado->comentario }}
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $estado->coordinador->name }}
                                        </td>
                                        <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $estado->creadoPor() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
