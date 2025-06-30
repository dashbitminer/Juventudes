<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 4: {{ $titulo }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }}</small>
</x-slot>
<div>
    <form wire:submit="save" enctype="multipart/form-data">
        <div x-data="formDirectorio" class="space-y-10 divide-y divide-gray-900/10">

            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <h4 class="font-semibold leading-tight text-gray-800">
                        Recuerda que este formulario debe ser llenado para registrar una
                        organización que colabore con la sostenibilidad del proyecto
                    </h4>
                </div>
            </div>

            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 1</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Datos generales de la organización</p>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
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
                                    {{ __('Descripción General del Trabajo de la Organización:') }}
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
                                        name="telefono" type="tel"
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
                                    {{ __('Tipo de Institución:') }}
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
            </div>

            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 2</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Ubicación de la Organización</p>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
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
            </div>

            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 3</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Datos de la persona enlace con la organización</p>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
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
                                        name="ref_celular" type="tel"
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
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.ref_email" id="ref_email"
                                        name="ref_email" type="email"
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
            </div>

            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 4</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Apoyo al programa</p>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <x-input-label>
                                    {{ __('Seleccione el tipo de apoyo que la organización brinda al programa') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <div class="px-4 py-3">
                                        <div class="max-w-2xl space-y-10">
                                            <div class="grid grid-cols-2 gap-6">
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

                            <div class="col-span-full">
                                <h4 class="font-semibold leading-tight text-center text-gray-800">
                                    Fin del formulario ¡Muchas gracias!
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
                        <x-resultadocuatro.form.submit label="Guardar" />
                    </div>
                </div>
            </div>

        </div>
    </form>

    <x-resultadocuatro.form.notifications />
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

        init() {
            const area_intervencion_id = $wire.form.area_intervencion_id;
            const tipo_institucion_id = $wire.form.tipo_institucion_id;

            if (area_intervencion_id) {
                const areaIntervencionOption = $el.querySelector(`#area_intervencion_id option[value="${area_intervencion_id}"]`);

                if (areaIntervencionOption.text == "Otra") {
                    this.area_intervencion = true;
                }
            }

            if (tipo_institucion_id) {
                const tipoInstitucionOption = $el.querySelector(`#tipo_institucion_id option[value="${tipo_institucion_id}"]`);

                if (tipoInstitucionOption.text == "Otra") {
                    this.tipo_institucion = true;
                }
            }
        },
    }));
</script>
@endscript
