

<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Permisos') }}
    </h2>
    {{-- <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small> --}}
</x-slot>



<div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Permisos</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Lista de todos los participantes en su cuenta incluyenhdos su nombre, ciudad, DNI, estado y
                    fecha de registro.</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a href="#"
                    role="button"
                    class="block px-3 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    x-on:click="$wire.openDrawer = true">
                    Crear Permiso
                </a>
            </div>
        </div>

        <div
            class="flex flex-col items-start justify-start gap-4 mt-4 sm:flex-row sm:justify-between sm:items-center">
            <div class="flex flex-col gap-1"></div>
            <div class="flex gap-2">
                {{-- <x-participante.index.filter-participantes :$filters />

                <x-participante.index.filter-range :$filters /> --}}
            </div>
        </div>

        <div class="my-2">
            {{-- <x-participante.index.filter-status :$filters /> --}}
        </div>

        {{-- <livewire:resultadouno.gestor.participante.index.table :$filters :$pais :$proyecto :$cohorte /> --}}
        <livewire:admin.permisos.index.table>

    </div>

    <x-admin.permisos.drawer :$categorias/>
    <x-admin.permisos.editdrawer :$categorias/>

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
