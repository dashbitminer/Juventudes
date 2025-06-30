@props(['participantes', 'form'])

<table class="min-w-full divide-y divide-gray-300">
    <thead>
        <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Nombre</th>

            @foreach ($form->rangeDates as $fecha)
                <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">
                    {{ $fecha }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
        @forelse ($participantes as $participante)
        <tr wire:key='rand-{{ $participante->id }}'>
            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                <div class="font-medium text-gray-900">{{ $participante->full_name }}</div>
            </td>

            @foreach ($form->rangeDates as $key => $value)
                <td wire:key='p-{{ $participante->id }}' class="whitespace-nowrap px-1 py-3 text-center text-sm text-gray-500">
                    <div class="grid grid-cols-2 gap-1">
                        <input wire:model="form.rangoParticipanteHora.{{ $participante->id }}.{{ $key }}" type="number" min="0" max="24" size="2" placeholder="h" class="block rounded time-custom-size">
                        <input wire:model="form.rangoParticipanteMinutos.{{ $participante->id }}.{{ $key }}" type="number" min="0" max="59" size="2" placeholder="m" class="block rounded time-custom-size">
                    </div>
                </td>
            @endforeach
        </tr>
        @empty
            <tr>
                <td colspan="8">
                    <p class="py-5 text-center text-gray-700">No se ha encontrado ningun participante para esta sesión.</p>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<style>
    .time-custom-size {
        padding: .5rem 0 .5rem .4rem;
    }
</style>
