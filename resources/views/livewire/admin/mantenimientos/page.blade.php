
<x-slot:header>
    <h2 class="flex gap-2 text-xl font-semibold leading-tight text-gray-800">
        <a href="#">
            {{ __('Mantenimientos') }}
        </a>
        {{-- <span class="text-slate-500">Formulario socioeconómico: {{ $participante->full_name }}</span> --}}
    </h2>
    {{-- <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small> --}}
</x-slot>


<div>

<div class="max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg">
    <div class="px-6 py-4">
        <h3 class="text-xl font-semibold text-gray-800">Mantenimientos</h3>
        <ul class="mt-4">
            <li class="my-2">
                <a href="/mantenimiento1" class="text-blue-500 hover:underline">Mantenimiento 1</a>
            </li>
            <li class="my-2">
                <a href="/mantenimiento2" class="text-blue-500 hover:underline">Mantenimiento 2</a>
            </li>
            <li class="my-2">
                <a href="/mantenimiento3" class="text-blue-500 hover:underline">Mantenimiento 3</a>
            </li>
        </ul>
    </div>
</div>
</div>
