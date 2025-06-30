<x-slot:header>
    <h2 class="flex gap-2 text-xl font-semibold leading-tight text-gray-800">
       Resultado 4: {{ __('Participantes') }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }}</small>
</x-slot>

<div>
    <div class="px-6 py-6 bg-white rounded">
        <h3 class="text-lg font-bold tracking-tight text-gray-900">Participantes</h3>

        <livewire:resultadocuatro.gestor.fichas.index.table :$pais :$proyecto :$cohorte/>
    </div>
</div>
