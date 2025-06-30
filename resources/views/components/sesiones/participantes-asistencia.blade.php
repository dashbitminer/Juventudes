<table class="min-w-full divide-y divide-gray-300">
    <thead>
        <tr>
            <th scope="col" class="py-3.5 pr-3 pl-4 text-sm font-semibold text-left text-gray-900 sm:pl-0">Nombre</th>
            <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-left text-gray-900">Estado</th>
            <th scope="col" class="px-3 py-3.5 text-sm font-semibold text-center text-gray-900">Asistencia</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse ($participantes as $participante)
        <tr wire:key='rand-{{ $participante->id }}'>
            <td class="py-5 pr-3 pl-4 text-sm whitespace-nowrap sm:pl-0">
                <div class="font-medium text-gray-900">{{ $participante->full_name }}</div>
                <div class="mt-1 text-gray-500">{{ $participante->sexo == 1 ? 'Mujer' : 'Hombre' }}</div>
            </td>
            <td class="px-3 py-5 text-sm text-gray-500 whitespace-nowrap">
                <div role="button"
                    class="rounded-full py-1 pl-2 pr-1 inline-flex font-medium items-center gap-1 text-{{ $participante->grupoactivo->lastEstadoParticipante->estado->color }}-600 text-xs bg-{{ $participante->grupoactivo->lastEstadoParticipante->estado->color }}-100">
                    <div> {{ $participante->grupoactivo->lastEstadoParticipante->estado->nombre ?? "registrado" }} </div>
                    <x-dynamic-component
                        :component="$participante->grupoactivo->lastEstadoParticipante->estado->icon" />
                </div>
            </td>
            <td class="px-3 py-5 text-sm text-center text-gray-500 whitespace-nowrap">
                <x-text-input type="checkbox" class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                    name="asistencia"
                    wire:key="asistencia-{{ $participante->id }}"
                    wire:model="form.selectedParticipanteIds.{{ $participante->id }}"
                    x-ref="sesioncheckbox"
                />
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="3">
                    <p class="py-5 text-center text-gray-700">No se ha encontrado ningun participante para esta sesión.</p>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
