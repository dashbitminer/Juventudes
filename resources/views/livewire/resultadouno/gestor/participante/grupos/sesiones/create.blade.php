<div class="mt-4">
    <div @keydown.window.escape="$wire.openDrawer = false" x-cloak x-show="$wire.openDrawer"
        class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0"></div>

        <div class="overflow-hidden fixed inset-0">
            <div class="overflow-hidden absolute inset-0">
                <div @class([
                    'pointer-events-none fixed inset-y-0 right-0 flex pl-10 sm:pl-16',
                    'max-w-2xl' => $form->tipo_sesion == App\Models\SesionTipo::SESION_GENERAL,
                    'max-w-6xl' => $form->tipo_sesion == App\Models\SesionTipo::HORAS_PARTICIPANTE
                ])>

                    <div x-show="$wire.openDrawer"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                        @click.away="$wire.openDrawer = false"
                        class="w-screen pointer-events-auto">
                        <form wire:submit="saveSesion" class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl">
                            <div class="overflow-y-auto flex-1 h-0">

                                <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                    <div class="flex justify-between items-center">
                                        <h2 class="text-base font-semibold leading-6 text-white" id="slide-over-title">
                                            @if ($isNew)
                                                Nueva Sesion
                                            @else
                                                Editar Sesion
                                            @endif
                                        </h2>
                                        <div class="flex items-center ml-3 h-7">
                                            <button type="button" @click="$wire.openDrawer = false"
                                                class="relative text-indigo-200 bg-indigo-700 rounded-md hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                                <span class="absolute -inset-2.5"></span>
                                                <span class="sr-only">Close panel</span>
                                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <p class="text-sm text-indigo-300">
                                            @if ($isNew)
                                                Crea una nueva sesion y marca el checkbox si el participante estuvo en la sesion.
                                            @else
                                                Edita la sesion y marca el checkbox si el participante estuvo en la sesion.
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Divider container -->
                                <div class="py-6 space-y-6 divide-y divide-gray-200 sm:space-y-0 sm:divide-y sm:divide-gray-200 sm:py-0">
                                    <div class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-4">
                                        <div>
                                            <x-input-label for="titulo">
                                                Titulo
                                                <x-required-label />
                                            </x-input-label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <x-forms.single-select
                                                id="titulo"
                                                name="form.titulo_id"
                                                selected="Seleccione un Titulo"
                                                wire:model.lazy="form.titulo_id"
                                                :options="$titulos"
                                                @class(['block w-full mt-1','border-2 border-red-500' => $errors->has('titulo')])
                                            />
                                            <x-input-error :messages="$errors->get('form.titulo_id')" class="mt-2" />
                                            {{-- @if ($form->titulo_abierto == \App\Models\SesionTitulo::CERRADO)
                                                <x-forms.single-select
                                                    id="titulo"
                                                    name="form.titulo_id"
                                                    selected="Seleccione un Titulo"
                                                    wire:model.lazy="form.titulo_id"
                                                    :options="$titulos"
                                                    @class(['block w-full mt-1','border-2 border-red-500' => $errors->has('titulo')])
                                                />
                                                <x-input-error :messages="$errors->get('form.titulo_id')" class="mt-2" />
                                            @else
                                                <x-text-input id="titulo" wire:model="form.titulo" type="text" class="w-full" autocomplete="off" />
                                                <x-input-error :messages="$errors->get('form.titulo')" class="mt-2" />
                                            @endif --}}

                                            @empty($titulos)
                                                <p class="text-sm text-red-500">
                                                    No hay titulos disponibles.
                                                </p>
                                            @endempty
                                        </div>
                                    </div>

                                    <div class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-4">
                                        <div>
                                            <x-input-label for="fecha">
                                                Fecha
                                                <x-required-label />
                                            </x-input-label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <input id="fecha" wire:model.blur="form.fecha"
                                                type="date" min="{{ $minDate }}" max="{{ $maxDate }}"
                                                class="block py-1.5 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            <x-input-error :messages="$errors->get('form.fecha')" class="mt-2" />
                                        </div>
                                    </div>

                                    @if ($form->tipo_sesion == \App\Models\SesionTipo::HORAS_PARTICIPANTE)
                                        <div class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-4">
                                            <div>
                                                <x-input-label for="fecha">
                                                    Fecha Fin
                                                    <x-required-label />
                                                </x-input-label>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <input id="fecha_fin" wire:model.blur="form.fecha_fin"
                                                    type="date" min="{{ $minDate }}" max="{{ $maxDate }}"
                                                    class="block py-1.5 w-full text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                <x-input-error :messages="$errors->get('form.fecha_fin')" class="mt-2" />
                                            </div>
                                        </div>
                                    @endif

                                    <div class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-4">
                                        <div>
                                            <x-input-label for="form.modalidad">
                                                Modalidad
                                            </x-input-label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <select class='block w-full rounded-md border-gray-300 shadow-sm sm:text-sm sm:leading-6 focus:border-indigo-500 focus:ring-indigo-500'
                                                wire:model="form.modalidad"
                                                id="form.modalidad"
                                            >
                                                <option value="">Seleccione una opción</option>
                                                <option value="1">Presencial</option>
                                                <option value="2">Virtual</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('form.modalidad')" class="mt-2" />
                                        </div>
                                    </div>

                                    @if ($form->tipo_sesion == App\Models\SesionTipo::SESION_GENERAL)
                                    <div class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-4">
                                        <div>
                                            <x-input-label>
                                                Duraci&oacute;n
                                            </x-input-label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <x-text-input id="form.hora" wire:model.live.debounce.500ms="form.hora" type="number" min="0" max="24" class="w-full" autocomplete="off" placeholder="Horas" />
                                                </div>
                                                <div>
                                                    <x-text-input id="form.minuto" wire:model.live.debounce.500ms="form.minuto" type="number" min="0" max="59" class="w-full" autocomplete="off" placeholder="Minutos" />
                                                </div>
                                            </div>
                                            <x-input-error :messages="$errors->get('form.hora')" class="mt-2" />
                                            <x-input-error :messages="$errors->get('form.minuto')" class="mt-2" />
                                        </div>
                                    </div>
                                    @endif

                                    <div class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-4">
                                        <div>
                                            <x-input-label for="comentario">
                                                Comentario
                                            </x-input-label>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <textarea name="comentario" id="comentario" wire:model="form.comentario" rows="3"
                                                class="block py-1.5 w-full text-gray-900 rounded-md ring-1 ring-inset ring-gray-300 shadow-sm placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            ></textarea>
                                        </div>
                                    </div>

                                    <div class="px-4 space-y-2 sm:space-y-0 sm:px-6 sm:py-4"
                                        x-data="sesionCheckAll">
                                        <div class="space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:py-4">
                                            <div class="flex gap-2">
                                                @if ($form->tipo_sesion == \App\Models\SesionTipo::SESION_GENERAL)
                                                    <x-text-input type="checkbox" id="checkall"
                                                        class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                        @click="toggleSesionParticipante"
                                                        x-bind:checked="$wire.marcarTodo == true"
                                                        {{-- x-model="!$wire.openDrawer" --}}
                                                    />

                                                    <x-input-label for="checkall">
                                                        Marcar Todo
                                                    </x-input-label>
                                                @endif
                                            </div>
                                            <div class="sm:col-span-2">
                                                <x-input-error :messages="$errors->get('form.selectedParticipanteIds')" />
                                            </div>
                                        </div>

                                        @if ($form->tipo_sesion == \App\Models\SesionTipo::SESION_GENERAL)
                                            <div class="space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:py-4">
                                                <x-participante.index.search />
                                            </div>

                                            <x-sesiones.participantes-asistencia :$participantes />
                                        @else

                                            @if ($form->enableSesionByFecha)
                                                <div class="space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:py-4">
                                                    <x-participante.index.search />
                                                </div>

                                                <x-sesiones.participantes-fecha :$participantes :$form />
                                            @else
                                                <p class="py-5 text-center text-gray-700">
                                                    Seleccione un rango de fechas para agregar las horas por dia.
                                                </p>
                                            @endif

                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="flex flex-shrink-0 justify-end px-4 py-4">
                                @if ($search)
                                    <button type="button" @click="$wire.cleanSearch()"
                                        class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md ring-1 ring-inset ring-gray-300 shadow-sm hover:bg-gray-50">
                                        Limpiar Busqueda
                                    </button>
                                @else
                                    <button type="button" @click="$wire.openDrawer = false"
                                        class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md ring-1 ring-inset ring-gray-300 shadow-sm hover:bg-gray-50">
                                        Cancelar
                                    </button>
                                    @if ($participantes->count())
                                        <button type="submit"
                                            class="inline-flex justify-center px-3 py-2 ml-4 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                            Guardar
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-notifications.alert-success-notification>
        <p class="text-sm font-medium text-gray-900">¡Guardado exitosamente!</p>
        <p class="mt-1 text-sm text-gray-500">Los datos del formulario de sesion se han guardado con éxito.</p>
    </x-notifications.alert-success-notification>
</div>

@script
<script>
    Alpine.data('sesionCheckAll', () => ({
        toggleSesionParticipante: () => {
            const checkboxes = $el.querySelectorAll('[x-ref="sesioncheckbox"]');
            const marcarTodo = $el.querySelector('#checkall');
            const event = new Event('change');

            if (checkboxes) {
                [...checkboxes].map(element => {
                    element.checked = marcarTodo.checked
                    element.dispatchEvent(event);
                });
            }
        },
    }));
</script>
@endscript
