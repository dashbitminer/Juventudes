<div class="mt-2">
    {{-- <a @click="$wire.openDirectorioForm()" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-500 border border-transparent rounded-md cursor-pointer hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25">
        Agrega Directorio
    </a> --}}

    <div @keydown.window.escape="$wire.openDrawer = false" x-cloak x-show="$wire.openDrawer"
        class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="fixed inset-y-0 right-0 flex max-w-2xl pl-10 pointer-events-none sm:pl-16">
                    <div x-show="$wire.openDrawer"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                        @click.away="$wire.openDrawer = false"
                        class="w-screen pointer-events-auto">

                        <form wire:submit="save" enctype="multipart/form-data" class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl">

                            <div class="px-4 py-6 bg-indigo-700 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-base font-semibold leading-6 text-white" id="slide-over-title">
                                        Nueva organización o Institución
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
                                        Agregue la nueva organización o institución a la lista.
                                    </p>
                                </div>
                            </div>

                            <div x-data="formDirectorio" class="flex-1 h-0 overflow-y-auto">
                                <div class="py-6 space-y-6 sm:space-y-0 sm:divide-y sm:divide-gray-200 sm:py-0">

                                    <div class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div class="px-4 sm:px-0">
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 1</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Datos generales de la organización</p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <div class="grid max-w-2xl grid-cols-1 gap-y-4 sm:grid-cols-1">
                                                <div class="col-span-full">
                                                    <x-input-label for="form.nombre">
                                                        {{ __('Nombre de la organización:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.nombre" id="form.nombre"
                                                            name="form.nombre" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                        @class([
                                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.nombre')
                                                        ])
                                                    />
                                                    <x-input-error :messages="$errors->get('form.nombre')" class="mt-2" />
                                                    </div>
                                                </div>

                                                <div class="col-span-full">
                                                    <x-input-label for="form.descripcion">
                                                        {{ __('Descripción general del trabajo de la organización:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.descripcion" id="descripcion"
                                                            name="descripcion" type="text"
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.descripcion')])
                                                            />
                                                        <x-input-error :messages="$errors->get('form.descripcion')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="form.telefono">
                                                        {{ __('Teléfono de la organización:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.telefono" id="telefono"
                                                            name="telefono" type="text"
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.telefono')])
                                                            />
                                                        <x-input-error :messages="$errors->get('form.telefono')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>
                                                <div class="sm:col-span-3"></div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="form.tipo_institucion_id">
                                                        {{ __('Tipo de institución:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-forms.single-select name="form.tipo_institucion_id"
                                                            wire:model.live='form.tipo_institucion_id'
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="tipo_institucion_id"
                                                            :options="$instituciones" selected="Seleccione una opción"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.tipo_institucion_id')])
                                                            x-on:change="changeTipoInstitucion"
                                                            />
                                                        <x-input-error :messages="$errors->get('form.tipo_institucion_id')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <div x-show="tipo_institucion">
                                                        <x-input-label for="form.tipo_institucion_otros">
                                                            {{ __('Especifique:') }}
                                                            <x-required-label />
                                                        </x-input-label>
                                                        <div class="mt-2">
                                                            <x-text-input wire:model="form.tipo_institucion_otros" id="tipo_institucion_otros"
                                                                name="tipo_institucion_otros" type="text"
                                                                disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                                @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                                $form->readonly,
                                                                'block w-full mt-1','border-2 border-red-500' =>
                                                                $errors->has('form.tipo_institucion_otros')])
                                                                />
                                                            <x-input-error :messages="$errors->get('form.tipo_institucion_otros')"
                                                                class="mt-2" aria-live="assertive" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="form.area_intervencion_id">
                                                        {{ __('Área(s) de Intervención') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-forms.single-select name="form.area_intervencion_id"
                                                            wire:model.live='form.area_intervencion_id'
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="area_intervencion_id"
                                                            :options="$areas" selected="Seleccione una opción"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.area_intervencion_id')])
                                                            x-on:change="changeAreaIntervencion"
                                                            />
                                                            <x-input-error :messages="$errors->get('form.area_intervencion_id')"
                                                                class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <div x-show="area_intervencion">
                                                        <x-input-label for="form.area_intervencion_otros">
                                                            {{ __('Especifique:') }}
                                                            <x-required-label />
                                                        </x-input-label>
                                                        <div class="mt-2">
                                                            <x-text-input wire:model="form.area_intervencion_otros" id="area_intervencion_otros"
                                                                name="area_intervencion_otros" type="text"
                                                                disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                                @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                                $form->readonly,
                                                                'block w-full mt-1','border-2 border-red-500' =>
                                                                $errors->has('form.area_intervencion_otros')])
                                                                />
                                                            <x-input-error :messages="$errors->get('form.area_intervencion_otros')"
                                                                class="mt-2" aria-live="assertive" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div class="px-4 sm:px-0">
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 2</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Ubicación de la Organización</p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <div class="grid max-w-2xl grid-cols-1 gap-y-4 sm:grid-cols-1">
                                                <div class="sm:col-span-3">
                                                    <x-input-label for="form.departamento_id">
                                                        {{ __('Departamento:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-forms.single-select name="form.departamento_id"
                                                            wire:model.live='form.departamento_id'
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="form.departamento_id"
                                                            :options="$departamentos" selected="Seleccione un departamento"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.departamento_id')])
                                                            />
                                                            <x-input-error :messages="$errors->get('form.departamento_id')"
                                                                class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="form.ciudad_id">
                                                        {{ __('Municipio/Distrito:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-forms.single-select name="form.ciudad_id" wire:model='form.ciudad_id'
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}" id="form.ciudad_id"
                                                            :options="$form->ciudades" selected="Seleccione un municipio"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.ciudad_id')])
                                                            />
                                                        <x-input-error :messages="$errors->get('form.ciudad_id')" class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="col-span-full">
                                                    <x-input-label for="form.direccion">
                                                        {{ __('Dirección:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.direccion" id="form.direccion"
                                                            name="form.direccion" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                        @class([
                                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.direccion')
                                                        ])
                                                    />
                                                    <x-input-error :messages="$errors->get('form.direccion')" class="mt-2" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div class="px-4 sm:px-0">
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 3</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Datos de la persona enlace con la organización</p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <div class="grid max-w-2xl grid-cols-1 gap-y-4 sm:grid-cols-1">
                                                <div class="sm:col-span-3">
                                                    <x-input-label for="form.ref_nombre">
                                                        {{ __('Nombre Completo:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.ref_nombre" id="ref_nombre"
                                                            name="ref_nombre" type="text"
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.ref_nombre')])
                                                            />
                                                        <x-input-error :messages="$errors->get('form.ref_nombre')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="form.telefono">
                                                        {{ __('Cargo:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.ref_cargo" id="ref_cargo"
                                                            name="ref_cargo" type="text"
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.ref_cargo')])
                                                            />
                                                        <x-input-error :messages="$errors->get('form.ref_cargo')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="form.ref_celular">
                                                        {{ __('Celular:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.ref_celular" id="ref_celular"
                                                            name="ref_celular" type="text"
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.ref_celular')])
                                                            />
                                                        <x-input-error :messages="$errors->get('form.ref_celular')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="form.ref_email">
                                                        {{ __('Correo Electrónico: ') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.ref_email" id="ref_email"
                                                            name="ref_email" type="text"
                                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $form->readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.ref_email')])
                                                            />
                                                        <x-input-error :messages="$errors->get('form.ref_email')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-4 space-y-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:space-y-0 sm:px-6 sm:py-5">
                                        <div class="px-4 sm:px-0">
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 4</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-600">Apoyo al programa</p>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <div class="grid max-w-2xl grid-cols-1 gap-y-4 sm:grid-cols-6">
                                                <div class="col-span-full">
                                                    <x-input-label>
                                                        {{ __('Seleccione el tipo de apoyo que la organización brinda al programa') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <div class="px-4 py-3">
                                                            <div class="max-w-2xl space-y-10">
                                                                <div class="grid grid-cols-1 gap-4">
                                                                    @foreach ($apoyos as $key => $value)
                                                                    <div class="relative flex gap-x-3">
                                                                        <div class="flex items-center h-6">
                                                                            <x-text-input type="checkbox"
                                                                                wire:key='tipo_apoyo_id{{$key}}'
                                                                                disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                                                wire:model="form.tipo_apoyo_id"
                                                                                value="{{ $key }}"
                                                                                class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                                                id="tipo_apoyo-{{$key}}" />
                                                                        </div>
                                                                        <div class="text-sm leading-6">
                                                                            <label for="tipo_apoyo-{{$key}}" class="font-medium text-gray-900">
                                                                                {{ $value }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                                <x-input-error :messages="$errors->get('form.tipo_apoyo_id')"
                                                                    class="mt-2" aria-live="assertive" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="flex justify-end flex-shrink-0 px-4 py-4">
                                <button type="button" @click="$wire.openDrawer = false"
                                    class="px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="inline-flex justify-center px-3 py-2 ml-4 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Guardar
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-resultadocuatro.form.alert-success-notification>
        <p class="text-sm font-medium text-gray-900">¡Guardado exitosamente!</p>
        <p class="mt-1 text-sm text-gray-500">Los datos del formulario de directorio se han guardado con éxito.</p>
    </x-resultadocuatro.form.alert-success-notification>
</div>

@script
<script>
    Alpine.data('formDirectorio', () => ({
        tipo_institucion: false,
        area_intervencion: false,

        changeTipoInstitucion(event) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            this.tipo_institucion = selectedOption.text.includes("Otra");

            setTimeout(() => {
                document.querySelector('#tipo_institucion_otros').focus();
            }, 200);
        },

        changeAreaIntervencion(event) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            this.area_intervencion = selectedOption.text.includes("Otra");

            setTimeout(() => {
                document.querySelector('#area_intervencion_otros').focus();
            }, 200);
        },
    }));
</script>
@endscript
