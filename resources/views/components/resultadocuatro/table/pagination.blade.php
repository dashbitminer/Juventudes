@props(['page'])
<div class="flex items-center justify-between pt-4">
    <div class="text-sm text-gray-700">
        @php
        $start = ($page->currentPage() - 1) * $page->perPage() + 1;
        $end = min($page->currentPage() * $page->perPage(), $page->total());
        @endphp
        Mostrando {{ $start }} a {{ $end }} de un total de {{
        \Illuminate\Support\Number::format($page->total()) }} registros
    </div>

    <div class="text-sm text-gray-700">
        Página actual: {{ $page->currentPage() }} de {{ $page->lastPage() }}
    </div>

    {{ $page->links('livewire.resultadouno.gestor.participante.index.pagination') }}
</div>
