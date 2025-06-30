<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 4: {{ __('Participantes') }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
</x-slot>

<div class="overflow-hidden py-6 bg-white shadow-sm sm:rounded-lg">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Participantes</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Lista de todos los estados que tiene el participante.</p>
            </div>
        </div>

        <livewire:resultadouno.gestor.participante.estados.table :$pais :$proyecto :$cohorte :$participante />

        <x-participante.estados.editdrawer :$estados :$categorias :$razones />

        <!-- Success Indicator... -->
        <x-notifications.success-text-notification message="Successfully saved!" />

        <!-- Error Indicator... -->
        <x-notifications.error-text-notification message="Han habido errores en el formulario" />

        <!-- Success Alert... -->
        <x-notifications.alert-success-notification>
            <p class="text-sm font-medium text-gray-900">¡Guardado exitosamente!</p>
            <p class="mt-1 text-sm text-gray-500">El registro fue guardado exitosamente y los cambios aparecerán en
                la ficha de registro.</p>
        </x-notifications.alert-success-notification>

        <!-- Error Alert... -->
        <x-notifications.alert-error-notification>
            <p class="text-sm font-medium text-red-900">¡Errores en el formulario!</p>
            <p class="mt-1 text-sm text-gray-500">Han habido problemas para guardar los cambios, corrija cualquier
                error en el formulario e intente nuevamente.</p>
        </x-notifications.alert-error-notification>
    </div>
</div>
