<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 4: {{ $titulo }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
    </x-slot>
    <div>


        <form wire:submit='save'>


            <div class="space-y-10 divide-y divide-gray-900/10" x-data="form">

                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <h4 class="font-semibold leading-tight text-gray-800">
                            ¡Buen día! Recuerda que este formulario debe ser llenado para registrar el voluntariado de
                            el participante
                        </h4>
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
                                <div class="sm:col-span-4">
                                    <x-input-label for="form.nombres">{{ __('¿Cómo accedió al medio de vida?') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="medioVidaSelected"
                                            wire:model.live="form.medioVidaSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const medioOption = selectedOption.getAttribute('data-medio-options');
                                            $wire.set('form.medioVidaSelectedPivot', medioOption);"
                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                            , 'border-2 border-red-500'=> $errors->has('form.medioVidaSelected')
                                            ])
                                            >

                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($mediosvida as $medio)
                                            <option value="{{ $medio->id }}" data-medio-options="{{ $medio->pivotid }}"
                                                wire:key='medio-{{ $medio->id }}'>
                                                {{ $medio->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('form.medioVidaSelected')" class="mt-2"
                                            aria-live="assertive" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                    <div class="px-4 sm:px-0">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 2</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Voluntariado.</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">


                                <div class="col-span-full">
                                    <x-input-label for="coberturaSelected">{{ __('Nombre de la empresa') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <div wire:ignore >
                                            <select
                                                wire:model="form.directorioSelected"
                                                data-choice
                                                wire:change="$set('form.directorioSelected', $event.target.value)"
                                                id="directorioSelected"
                                                @class([
                                                    'block w-full mt-1','border-2 border-red-500' => $errors->has('form.directorioSelected')
                                                ])
                                            >
                                                <option value="">Seleccione una organización</option>
                                                @foreach($directorio as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <x-input-error :messages="$errors->get('form.directorioSelected')" class="mt-2" aria-live="assertive" />


                                        <x-directorio.open-directorio-form  title="Crear nueva empresa"/>


                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <x-input-label for="tipo_institucion">{{ __('Tipo de organización/institución') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.tipoinstitucionnombre" id="tipo_institucion"
                                            name="form.tipoinstitucionnombre" type="text"
                                            disabled="disabled"
                                           @class([
                                               'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',// => $form->readonly,
                                               'block w-full mt-1','border-2 border-red-500' => $errors->has('form.tipoinstitucionnombre')
                                           ])
                                       />
                                        <x-input-error :messages="$errors->get('form.tipoinstitucionnombre')" class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="sm:col-span-4" x-show="$wire.form.tipoinsitucionid == {{ \App\Models\TipoInstitucion::OTRA }}">
                                    <x-input-label for="tipo_institucion_otro">{{ __('Especifique:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.tipoinsitucionotro" id="tipo_institucion_otro"
                                            name="form.tipoinsitucionotro" type="text"
                                            disabled="disabled"
                                           @class([
                                               'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',// => $form->readonly,
                                               'block w-full mt-1','border-2 border-red-500' => $errors->has('form.tipoinsitucionotro')
                                           ])
                                       />
                                        <x-input-error :messages="$errors->get('form.tipoinsitucionotro')" class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>


                                <div class="sm:col-span-4">
                                    <x-input-label for="coberturaSelected">{{ __('Está vinculado debido
                                        a:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="vinculadoDebidoSelected"
                                            wire:model.live="form.vinculadoDebidoSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const medioOption = selectedOption.getAttribute('data-medio-options');
                                            $wire.set('form.vinculadoDebidoSelectedPivot', medioOption);"
                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                            , 'border-2 border-red-500'=> $errors->has('form.vinculadoDebidoSelected')
                                            ])
                                            >

                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($vinculado as $medio)
                                            <option value="{{ $medio->id }}" data-medio-options="{{ $medio->pivotid }}"
                                                wire:key='medio-{{ $medio->id }}'>
                                                {{ $medio->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('form.vinculadoDebidoSelected')" class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="col-span-full" x-show="$wire.form.vinculadoDebidoSelected == {{ App\Models\VinculadoDebido::OTRO }}">
                                    <x-input-label for="coberturaSelected">{{ __('Especifique:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="vinculadoDebidoOtro" id="vinculadoDebidoOtro" wire:model='form.vinculadoDebidoOtro' rows="3"
                                            @class([
                                            'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.vinculadoDebidoOtro'),
                                            'border-2 border-red-500' => $errors->has('form.vinculadoDebidoOtro'),
                                         //   'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                        ])></textarea>
                                        <x-input-error :messages="$errors->get('form.vinculadoDebidoOtro')" class="mt-2"
                                                aria-live="assertive" />
                                    </div>
                                    {{-- <p class="mt-3 text-sm leading-6 text-gray-600">Write a few sentences about
                                        yourself.
                                    </p> --}}
                                </div>

                                <div class="sm:col-span-4">
                                    <x-input-label for="form.fecha">
                                        {{ __('¿Desde cuando realizan el voluntariado?') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        @if ($form->minDate || $form->maxDate)
                                            <x-text-input wire:model="form.fecha_inicio_voluntariado" id="form.fecha"
                                                name="form.fecha_inicio_voluntariado" type="date"
                                                min="{{ $form->minDate }}" max="{{ $form->maxDate }}"
                                                {{-- disabled="{{ $form->readonly ? 'disabled' : '' }}" --}}
                                            @class([
                                                //'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_inicio_voluntariado')
                                            ])
                                        />
                                       @else
                                        <x-text-input wire:model="form.fecha_inicio_voluntariado" id="form.fecha"
                                                name="form.fecha_inicio_voluntariado" type="date"
                                                {{-- disabled="{{ $form->readonly ? 'disabled' : '' }}" --}}
                                            @class([
                                                //'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_inicio_voluntariado')
                                            ])
                                        />
                                       @endif
                                       <x-input-error :messages="$errors->get('form.fecha_inicio_voluntariado')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <x-input-label for="areaIntervencionSelected">{{ __('Área de intervención de la organización/institución:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.areaIntervencionNombre" id="areaIntervencionSelected"
                                            name="form.areaIntervencionNombre" type="text"
                                            disabled="disabled"
                                           @class([
                                               'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',// => $form->readonly,
                                               'block w-full mt-1','border-2 border-red-500' => $errors->has('form.areaIntervencionNombre')
                                           ])
                                       />
                                        <x-input-error :messages="$errors->get('form.areaIntervencionNombre')" class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="col-span-full" x-show="$wire.form.areaIntervencionSelected == {{ App\Models\AreaIntervencion::OTRA }}">
                                    <x-input-label for="otraAreaIntervencion">
                                        {{ __('Especifique:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.otraAreaIntervencion" id="otraAreaIntervencion"
                                            name="form.otraAreaIntervencion" type="text"
                                            disabled="disabled"
                                           @class([
                                               'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',// => $form->readonly,
                                               'block w-full mt-1','border-2 border-red-500' => $errors->has('form.tipo_institucion_otro')
                                           ])
                                       />
                                        <x-input-error :messages="$errors->get('form.otraAreaIntervencion')" class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>


                                <div class="sm:col-span-4">
                                    <x-input-label for="form.horas">
                                        {{ __('Escriba el promedio de
                                        horas que realizan al mes:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.promedio_horas" id="form.horas"
                                                name="form.promedio_horas" type="number" step="1" min="1"
                                                {{-- disabled="{{ $form->readonly ? 'disabled' : '' }}" --}}
                                            @class([
                                                //'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.promedio_horas')
                                            ])
                                        />
                                        <x-input-error :messages="$errors->get('form.promedio_horas')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="discapacidades">{{ __('Seleccione los servicios que desarrolla:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <div class="px-4 py-3">
                                            <div class="max-w-2xl space-y-10">
                                                <div class="grid grid-cols-2 gap-6">
                                                    @foreach ($serviciosDesarrollar as $servicio)
                                                    <div class="relative flex gap-x-3">
                                                        <div class="flex items-center h-6">
                                                            <x-text-input type="checkbox" name="servicioDesarrollar"
                                                                wire:key='servicio-{{$servicio->pivotid}}'
                                                                wire:model="form.serviciosDesarrollarSelected"
                                                                x-on:change="servicioDesarrolloCallback"
                                                                data-value="{{ $servicio->nombre }}"
                                                                value="{{ $servicio->pivotid }}"
                                                                class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                                id="servicio-{{$servicio->pivotid}}" />
                                                        </div>
                                                        <div class="text-sm leading-6">
                                                            <label for="servicio-{{$servicio->pivotid}}" class="font-medium text-gray-900">
                                                                {{ $servicio->nombre }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <x-input-error
                                                    :messages="$errors->get('form.serviciosDesarrollarSelected')"
                                                    class="mt-2" aria-live="assertive" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-full" x-show="servicio_otro">
                                    <x-input-label for="discapacidades">{{ __('Otros:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.servicio_otro" id="form.servicio_otro"
                                                name="form.servicio_otro" type="text"
                                            @class([
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.servicio_otro')
                                            ])
                                        />
                                        <x-input-error :messages="$errors->get('form.servicio_otro')" class="mt-2" />
                                    </div>
                                </div>



                                <div class="col-span-full">
                                    <x-input-label for="medioVerificacionSelected">{{ __('Seleccione los Medios
                                        de verificación del voluntariado:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="medioVerificacionSelected"
                                            wire:model.live="form.medioVerificacionSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const medioOption = selectedOption.getAttribute('data-medio-options');
                                            $wire.set('form.medioVerificacionSelectedPivot', medioOption);"
                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                            , 'border-2 border-red-500'=> $errors->has('form.medioVerificacionSelected')
                                            ])
                                            >
                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($mediosVerificacionVoluntario as $medio)
                                            <option value="{{ $medio->id }}" data-medio-options="{{ $medio->pivotid }}"
                                                wire:key='medio-{{ $medio->id }}'>
                                                {{ $medio->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('form.medioVerificacionSelected')" class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>


                                <div class="col-span-full">


                                @if ($mode == 'edit')
                                    <div class="mt-2">
                                        <div class="mt-2">
                                            <a href="{{ Storage::disk('s3')->temporaryUrl($form->temp_file, \Carbon\Carbon::now()->addHour()) }}" target="_blank" class="text-blue-500 underline">{{ __('Ver archivo de medio de verificación') }}</a>
                                        </div>
                                    </div>
                                @endif

                                    <div class="mt-2" x-data="{ uploading: false, progress: 0 }"
                                        x-on:livewire-upload-start="uploading = true"
                                        x-on:livewire-upload-finish="uploading = false"
                                        x-on:livewire-upload-cancel="uploading = false"
                                        x-on:livewire-upload-error="uploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                                        >

                                        <!-- File Input -->
                                        <x-input-label for="file_documento_medio_verificacion_upload"
                                            class="block py-3 mt-2 mb-2">{{ __('Cargue los medios de
                                            verificación del voluntariado') }}
                                        </x-input-label>


                                        <input type="file" wire:model="form.file_documento_medio_verificacion_upload"
                                        {{-- {{$form->readonly ? 'disabled' : '' }} --}}
                                        {{-- :capture="isChecked ? 'environment' : null"
                                        :accept="isChecked ? 'image/*' : null" --}}
                                        @class([
                                        // 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200
                                        // disabled:shadow-none' => $form->readonly,
                                        "w-full text-sm font-semibold text-gray-400 bg-white border rounded
                                        cursor-pointer file:cursor-pointer file:border-0 file:py-3 file:px-4
                                        file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500"
                                        ])
                                        >
                                        <p class="mt-2 text-xs text-gray-400">Tipos de archivos permitidos: PNG,
                                            JPG, GIF y PDF.</p>

                                        <!-- Progress Bar -->
                                        <div x-show="uploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>

                                        <x-input-error
                                            :messages="$errors->get('form.file_documento_medio_verificacion_upload')"
                                            class="mt-2" aria-live="assertive" />
                                    </div>

                                </div>




                                <div class="col-span-full">
                                    <x-input-label for="medioVerificacionSelected">{{ __('Información adicional
                                        que desee mencionar sobre el empleo de la o el joven:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="informacionAdicionalJoven" id="informacionAdicionalJoven" wire:model='form.informacionAdicionalJoven' rows="3"
                                        @class([
                                        'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                        'border-0 border-slate-300'=> $errors->missing('form.informacionAdicionalJoven'),
                                        'border-2 border-red-500' => $errors->has('form.informacionAdicionalJoven'),
                                     //   'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])></textarea>
                                    <x-input-error :messages="$errors->get('form.informacionAdicionalJoven')" class="mt-2"
                                            aria-live="assertive" />
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div
                            class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
                            <x-resultadocuatro.form.submit label="Guardar" />
                        </div>
                    </div>
                </div>

            </div>

        </form>

        <x-resultadocuatro.form.notifications />

        <livewire:resultadocuatro.gestor.directorio.create.modal :$pais :$proyecto />

    </div>

@script
<script>
    Alpine.data('form', () => ({
        servicio_otro: false,

        servicioDesarrolloCallback(event) {
            const options = $el.querySelectorAll("[name='servicioDesarrollar']");

            options.forEach(element => {
                const key = element.value;
                const value = element.dataset.value;
                const isChecked = element.checked;

                this.servicio_otro = value.includes("Otros") && isChecked;
            });
        },

        init() {
            if ($wire.form.serviciosDesarrollarSelected) {
                for (const id of Object.values($wire.form.serviciosDesarrollarSelected)) {
                    const checkbox = $el.querySelector(`[name="servicioDesarrollar"][value="${id}"]`);

                    if (checkbox.dataset.value.includes("Otros")) {
                        this.servicio_otro = true;
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
        let subcategorySelect = new Choices($wire.$el.querySelector('[data-choice]'), { shouldSort: false });

        // Listen for changes in Livewire and update the second dropdown accordingly
        Livewire.on('refresh-list-directorios', subcategories => {

            // console.log(typeof subcategories, subcategories.length);

            // console.log(subcategories[0]);

            // Get the dropdown element
            let subcategoryElement = document.getElementById('directorioSelected');

            //subcategoryElement.innerHTML = '';


            // Clear the current options
           // subcategoryElement.innerHTML = '<option value="">Seleccione una organización</option>';

            // Add the new subcategory options
            for (const [key, value] of Object.entries(subcategories[0])) {
                console.log(key, value);

                $wire.form.directorioSelected = key;

                let newOption = new Option(value, key);

                if ($wire.form.directorioSelected == key) {
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
