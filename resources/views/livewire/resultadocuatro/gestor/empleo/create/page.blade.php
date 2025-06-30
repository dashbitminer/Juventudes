<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
       Resultado 4: {{ $titulo }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
</x-slot>
<div>
    <form wire:submit="save" enctype="multipart/form-data">
        <div x-data="form" class="space-y-10 divide-y divide-gray-900/10">

            <div class="space-y-10 divide-y divide-gray-900/10">
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <h4 class="font-semibold leading-tight text-gray-800">
                        Recuerda que este formulario debe ser llenado para registrar el empleo de el participante
                    </h4>
                </div>
            </div>
            </div>

            {{-- <div class="space-y-10 divide-y divide-gray-900/10"> --}}
                <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                    <div class="px-4 sm:px-0">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">INICIO</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Datos del participante</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="website"
                                        class="block text-sm font-medium leading-6 text-gray-900">Nombre
                                        completo</label>
                                    <div class="mt-2">
                                        <p>{{ $participante->full_name }}</p>
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="website"
                                        class="block text-sm font-medium leading-6 text-gray-900">Género</label>
                                    <div class="mt-2">
                                        <p>{{ $participante->sexo == 1 ? "Femenino" : "Masculino" }}</p>
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="website"
                                        class="block text-sm font-medium leading-6 text-gray-900">Documento de
                                        identidad</label>
                                    <div class="mt-2">
                                        <p>{{ $participante->documento_identidad }}</p>
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="website"
                                        class="block text-sm font-medium leading-6 text-gray-900">Edad</label>
                                    <div class="mt-2">
                                        <p>{{ $participante->edad }} años</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- </div> --}}

            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 1</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Datos generales del participante</p>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <x-input-label for="form.medio_vida_id">
                                    {{ __('¿Cómo accedió al medio de vida?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.medio_vida_id"
                                        wire:model='form.medio_vida_id'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        id="form.medio_vida_id"
                                        :options="$medios_vida" selected="Seleccione una opción"
                                        @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.medio_vida_id')]) />
                                    <x-input-error :messages="$errors->get('form.medio_vida_id')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 2</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Empleo</p>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <x-input-label for="form.directorio_id">
                                    {{ __('Nombre de la empresa') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <div wire:ignore>
                                        <select wire:model="form.directorio_id" data-choice
                                            wire:change="$set('form.directorio_id', $event.target.value)"
                                            id="form.directorio_id" @class([ 'block w-full mt-1' ,'border-2
                                            border-red-500'=> $errors->has('form.directorio_id')
                                            ])
                                            >
                                            <option value="">Seleccione una organización</option>
                                            @foreach($directorio as $key => $value)
                                            <option value="{{ $key }}" {{ $key == $form->directorio_id }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div wire:ignore>
                                        <x-forms.single-select name="form.directorio_id" data-choice
                                            wire:model="form.directorio_id"
                                            wire:change="$set('form.directorio_id', $event.target.value)"
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            id="form.directorio_id"
                                            :options="$directorio"
                                            selected="Seleccione una organización"
                                            @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.directorio_id')])
                                        />
                                    </div> --}}
                                    <x-input-error :messages="$errors->get('form.directorio_id')" class="mt-2"
                                        aria-live="assertive" />

                                    <x-directorio.open-directorio-form  title="Crear nueva empresa"/>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.sector_empresa_organizacion_id">
                                    {{ __('Sector de la empresa u organización  ') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.sector_empresa_organizacion_id"
                                        wire:model='form.sector_empresa_organizacion_id'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        id="form.sector_empresa_organizacion_id"
                                        :options="$sectores" selected="Seleccione una opción"
                                        @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.sector_empresa_organizacion_id')]) />
                                    <x-input-error :messages="$errors->get('form.sector_empresa_organizacion_id')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.tipo_empleo_id">
                                    {{ __('Tipo de empleo') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.tipo_empleo_id"
                                        wire:model='form.tipo_empleo_id'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        id="form.tipo_empleo_id"
                                        :options="$empleos" selected="Seleccione una opción"
                                        @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.tipo_empleo_id')]) />
                                    <x-input-error :messages="$errors->get('form.tipo_empleo_id')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.cargo">
                                    {{ __('Cargo desempeñado') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.cargo" id="form.cargo"
                                        name="form.cargo" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                        'block text-sm w-full mt-1','border-2 border-red-500' => $errors->has('form.cargo')
                                        ]) />
                                    <x-input-error :messages="$errors->get('form.cargo')" class="mt-2" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.salario_id">
                                    {{ __('Salario') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.salario_id"
                                        wire:model='form.salario_id'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        id="form.salario_id"
                                        :options="$salarios" selected="Seleccione un opción"
                                        @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.salario_id')]) />
                                    <x-input-error :messages="$errors->get('form.salario_id')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.habilidades">
                                    {{ __('¿Qué habilidades adquiridas o fortalecidas en el programa le ayudaron a conseguir el empleo?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea wire:model="form.habilidades"
                                        id="form.habilidades" name="form.habilidades" rows="3"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </textarea>
                                    <x-input-error :messages="$errors->get('form.habilidades')" class="mt-2" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.medio_verificacion_id">
                                    {{ __('Seleccione los Medios de verificación del enlace a medio de vida') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-1">
                                        @foreach ($medios_verificacion as $key => $value)
                                        <div class="relative flex gap-x-3">
                                            <div class="flex items-center h-6">
                                                <x-text-input type="checkbox"
                                                    wire:key='medio_verificacion{{$key}}'
                                                    wire:model="form.medio_verificacion_id" value="{{ $key }}"
                                                    x-on:change="medioVerificacion"
                                                    data-value="{{ $value }}"
                                                    class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                    id="medio_verificacion-{{$key}}"
                                                    name="form.medio_verificacion_id"
                                                    />
                                            </div>
                                            <div class="leading-6 sm:text-lg">
                                                <x-input-label for="medio_verificacion-{{$key}}">
                                                    {{ $value }}
                                                </x-input-label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <x-input-error :messages="$errors->get('form.medio_verificacion_id')" class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <div x-show="medio_verificacion_otros">
                                    <x-input-label for="form.medio_verificacion_otros">
                                        {{ __('Especifique:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.medio_verificacion_otros" id="form.medio_verificacion_otros"
                                            name="form.medio_verificacion_otros" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            @class([
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.medio_verificacion_otros')
                                            ]) />
                                        <x-input-error :messages="$errors->get('form.medio_verificacion_otros')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-full" x-show="archivos_verificacion">
                                <x-input-label for="form.achivos_verificacion">
                                    {{ __('Cargue los medios de verificación del enlace a medio de vida') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    @foreach ($medios_verificacion as $key => $value)
                                        <div wire:key="{{ $key }}" x-show="archivos_verificacion_{{ $key }}" class="mt-4">
                                            @if(isset($form->medio_verificacion_archivos[$key]))
                                                <div class="py-2">
                                                    <a href="{{ Storage::disk('s3')->temporaryUrl($form->medio_verificacion_archivos[$key], \Carbon\Carbon::now()->addHour()) }}"
                                                        class="text-blue-600 underline md:text-green-600"
                                                        target="_blank" rel="noopener noreferrer">
                                                        Ver documento actual
                                                    </a>
                                                </div>
                                            @endif
                                            <p class="block text-sm font-medium text-orange-700">
                                                Archivo para <em>{{ $value }}</em>:
                                            </p>
                                            <input type="file"
                                                wire:model="form.achivos_verificacion.{{ $key }}"
                                                @class([
                                                "w-full text-sm font-semibold text-gray-400 bg-white border rounded
                                                cursor-pointer file:cursor-pointer file:border-0 file:py-3 file:px-4
                                                file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500"
                                                ]) />
                                            <p class="mt-2 text-xs text-gray-400">
                                                Tipos de archivos permitidos: PNG, JPG, GIF, DOCX y PDF.
                                            </p>
                                        </div>
                                    @endforeach
                                    <x-input-error :messages="$errors->get('form.achivos_verificacion')" class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.area_intervencion_id">
                                    {{ __('Información adicional que desee mencionar sobre el empleo de la o el joven:') }}
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea wire:model="form.informacion_adicional"
                                        id="form.informacion_adicional" name="form.informacion_adicional" rows="3"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </textarea>
                                </div>
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

    <livewire:resultadocuatro.gestor.directorio.create.modal :$pais :$proyecto wire:key='123' />
</div>

@script
<script>
    Alpine.data('form', () => ({
        medio_verificacion_otros: false,
        archivos_verificacion: false,

        @foreach ($medios_verificacion as $key => $value)
        archivos_verificacion_{{ $key }}: false,
        @endforeach

        medioVerificacion(event) {
            const options = $el.querySelectorAll("[name='form.medio_verificacion_id']");
            let totalChecked = 0;

            options.forEach(element => {
                const key = element.value;
                const value = element.dataset.value;
                const isChecked = element.checked;

                this.medio_verificacion_otros = value.includes("Otros") && isChecked;
                this[`archivos_verificacion_${key}`] = isChecked;

                if (isChecked) {
                    totalChecked++;
                }
            });

            this.archivos_verificacion = totalChecked > 0;
        },

        init() {
            if ($wire.form.medio_verificacion_id.length) {
                this.archivos_verificacion = true;

                for (const [key, value] of Object.entries($wire.form.medio_verificacion_id)) {
                    this[`archivos_verificacion_${value}`] = true;

                    const option = $el.querySelector(`[name='form.medio_verificacion_id'][value='${value}']`);

                    if (option.dataset.value.includes("Otros")) {
                        this.medio_verificacion_otros = true;
                    }
                }
            }
        },
    }));
</script>
@endscript

@script
<script>
 document.addEventListener('livewire:navigated', function () {
           // alert("hola");
            // Initialize Choices.js for the second dropdown
            let subcategorySelect = new Choices($wire.$el.querySelector('[data-choice]'), { shouldSort: false, itemSelectText: 'Seleccione', searchPlaceholderValue: 'Buscar' });

            // Listen for changes in Livewire and update the second dropdown accordingly
            Livewire.on('refresh-list-directorios', subcategories => {

                console.log(typeof subcategories, subcategories.length);

                console.log(subcategories[0]);

                // Get the dropdown element
                let subcategoryElement = document.getElementById('form.directorio_id');

                //subcategoryElement.innerHTML = '';


                // Clear the current options
               // subcategoryElement.innerHTML = '<option value="">Seleccione una organización</option>';

                // Add the new subcategory options
                for (const [key, value] of Object.entries(subcategories[0])) {
                    console.log(key, value);

                    $wire.form.directorio_id = key;

                    let newOption = new Option(value, key);

                    if ($wire.form.directorio_id == key) {
                        newOption.selected = true;
                    }

                    subcategoryElement.append(newOption);

                    // subcategoryElement.add(newOption);
                }

                //console.log($wire.form.directorioSelected);
                // Re-initialize Choices.js with the new options
                subcategorySelect.refresh();
               // new Choices($wire.$el.querySelector('[data-choice]'), { shouldSort: false });
                //subcategorySelect = new Choices($wire.$el.querySelector('[data-choice]'), { shouldSort: false });
            });
        });
</script>
@endscript
