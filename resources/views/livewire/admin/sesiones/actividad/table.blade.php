<div>
    <div class="flex justify-end pb-4">
        <a href="#" role="button"
            class="block px-3 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            x-on:click.prevent="$wire.openDrawer = true; $wire.resetFields();">
            Crear Actividad
        </a>
    </div>

    <div class="flex flex-col grid-cols-8 gap-2 my-4 sm:grid">
        <x-admin.sesiones.sesion.search />
        <x-admin.permisos.bulk-actions />
    </div>

    <div class="hidden sm:block">
        <div>
            <div class="flex flex-col mt-2">
                <div class="overflow-hidden overflow-x-auto min-w-full align-middle shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-2 py-3 text-sm font-semibold text-left bg-gray-50">
                                    <div class="flex items-center">
                                        <x-resultadocuatro.table.check-all />
                                    </div>
                                </th>
                                <th class="px-3 py-3 text-sm font-semibold text-left text-gray-900 bg-gray-50"
                                    scope="col">Nombre</th>
                                <th class="px-3 py-3 text-sm font-semibold text-left text-gray-900 whitespace-nowrap bg-gray-50"
                                    scope="col">Comentario</th>
                                <th class="px-3 py-3 text-sm font-semibold text-right text-gray-900 bg-gray-50"
                                    scope="col">Fecha</th>
                                <th scope="col" class="relative py-3.5 pr-4 pl-3 bg-gray-50 sm:pr-0">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($results as $model)
                            <tr class="bg-white" wire:key='rand-{{ $model->id }}'>
                                <td class="px-2 py-3 text-sm whitespace-nowrap">
                                    <div class="flex items-center">
                                        <input wire:model="selectedIds" value="{{ $model->id }}"
                                            type="checkbox" class="rounded border-gray-300 shadow">
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-sm text-left text-gray-500 whitespace-nowrap">
                                    <p class="text-gray-900 truncate">
                                        {{ $model->nombre ?? '' }}
                                    </p>
                                </td>
                                <td class="px-3 py-4 text-sm text-left text-gray-500">
                                    {{ $model->comentario ?? '' }}
                                </td>
                                <td class="px-3 py-4 text-sm text-right text-gray-500 whitespace-nowrap">
                                    <time datetime="{{ $model->created_at }}">
                                        {{ \Carbon\Carbon::parse($model->created_at)->format( 'M d, Y, g:i A' ) }}
                                    </time>
                                </td>
                                <td class="relative py-5 pr-4 pl-3 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                    <x-admin.sesiones.user-row-dropdown :model="$model" wire:key='row-{{ $model->id }}' />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <nav class="flex justify-between items-center px-4 py-3 bg-white border-t border-gray-200 sm:px-6"
                        aria-label="Pagination">
                        <div class="hidden sm:block">
                            <p class="text-sm text-gray-700">
                                @php
                                $start = ($results->currentPage() - 1) * $results->perPage() + 1;
                                $end = min($results->currentPage() * $results->perPage(), $results->total());
                                @endphp
                                Mostrando <span class="font-medium">{{ $start }}</span> a <span class="font-medium">{{ $end }}</span>
                                de un total de <span class="font-medium">{{ \Illuminate\Support\Number::format($results->total()) }} registros</span>
                            </p>
                        </div>
                        <div class="flex flex-1 gap-x-3 justify-between sm:justify-end">
                            {{ $results->links('livewire.resultadouno.gestor.participante.index.pagination') }}
                        </div>
                    </nav>
                </div>

                <div wire:loading wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                    class="absolute inset-0 bg-white opacity-50"></div>

                <div wire:loading.flex wire:target='sortBy, search, nextPage, previousPage, delete, perPage, __dispatch'
                    class="flex absolute inset-0 justify-center items-center">
                    <x-icon.spinner size="8" class="text-gray-500" />
                </div>
            </div>
        </div>
    </div>

    <x-admin.sesiones.nivel.drawer />
    <x-admin.sesiones.nivel.editdrawer />

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
