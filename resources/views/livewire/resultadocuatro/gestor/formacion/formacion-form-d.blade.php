<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 4: {{ $titulo }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }}</small>
    </x-slot>
    <div>



        <form wire:submit='save' wire:key='form-empleabilidad-glass' id="form-empleabilidad">

            <div class="space-y-10 divide-y divide-gray-900/10">
                <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
                    <div class="px-4 sm:px-0">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">INICIO</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600 uppercase">Datos generales del participante</p>
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
            </div>

            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 2.</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600"> EDUCACIÓN Y/O FORMACIÓN.</p>
                </div>

                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <x-input-label for="tipoEstudioSelected">{{ __('Seleccione el tipo de estudio') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="tipoEstudioSelected"
                                            wire:model.live="form.tipoEstudioSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const medioOption = selectedOption.getAttribute('data-tipo-options');
                                            $wire.set('form.tipoEstudioSelectedPivot', medioOption);"
                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                            , 'border-2 border-red-500'=> $errors->has('form.tipoEstudioSelected')
                                            ])
                                            >

                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($tipoEstudio as $tipo)
                                            <option value="{{ $tipo->id }}" data-tipo-options="{{ $tipo->pivotid }}"
                                                wire:key='tipo-{{ $tipo->id }}'>
                                                {{ $tipo->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('form.tipoEstudioSelected')" class="mt-2"
                                            aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full" x-show="$wire.form.tipoEstudioSelected == {{ \App\Models\TipoEstudio::OTRO }}">
                                <x-input-label for="coberturaSelected">{{ __('Especifique:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="otro_tipo_estudio" id="otro_tipo_estudio"
                                        wire:model='form.otro_tipo_estudio' rows="3"
                                        @class([ 'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                        , 'border-0 border-slate-300'=> $errors->missing('form.otro_tipo_estudio'),
                                        'border-2 border-red-500' => $errors->has('form.otro_tipo_estudio'),
                                    //   'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])></textarea>
                                    <x-input-error :messages="$errors->get('form.otro_tipo_estudio')" class="mt-2"
                                        aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="coberturaSelected">{{ __('Nombre de la empresa') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <div wire:ignore>
                                        <select wire:model="form.directorioSelected" data-choice
                                            wire:change="$set('form.directorioSelected', $event.target.value)"
                                            id="directorioSelected" @class([ 'block w-full mt-1' ,'border-2
                                            border-red-500'=> $errors->has('form.directorioSelected')
                                            ])
                                            >
                                            <option value="">Seleccione una organización</option>
                                            @foreach($directorio as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-input-error :messages="$errors->get('form.directorioSelected')" class="mt-2"
                                        aria-live="assertive" />

                                        <x-directorio.open-directorio-form title="Crear nueva empresa" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="form.totalHorasDuracion">{{ __('Total de horas de duración') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.totalHorasDuracion" id="form.totalHorasDuracion"
                                        name="form.totalHorasDuracion" type="number" step="1" min="1"
                                        @class([
                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.totalHorasDuracion')
                                        ])
                                        />
                                        <x-input-error :messages="$errors->get('form.totalHorasDuracion')" class="mt-2" />
                                </div>
                            </div>
                            <div class="sm:col-span-4"></div>

                            <div class="sm:col-span-3">
                                <x-input-label for="areaFormacionSelected">{{ __('Seleccione el área de formación') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="areaFormacionSelected"
                                        wire:model.live="form.areaFormacionSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                        const medioOption = selectedOption.getAttribute('data-area-options');
                                        $wire.set('form.areaFormacionSelectedPivot', medioOption);"
                                        @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                        , 'border-2 border-red-500'=> $errors->has('form.areaFormacionSelected')
                                        ])
                                        >

                                        <option value="">{{ __('Seleccione una opción') }}</option>
                                        @foreach($areas as $area)
                                        <option value="{{ $area->id }}" data-area-options="{{ $area->pivotid }}"
                                            wire:key='area-{{ $area->id }}'>
                                            {{ $area->nombre }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('form.areaFormacionSelected')" class="mt-2"
                                        aria-live="assertive" />
                                    </div>
                            </div>

                            <div class="sm:col-span-3" x-Show="$wire.form.areaFormacionSelected == {{ \App\Models\AreaFormacion::EDUCACION_BASICA }}">
                                <x-input-label for="nivelEducativoFormacion">{{ __('Seleccione el nivel educativo') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">

                                    <select name="nivelEducativoSelected" id="nivelEducativoSelected"
                                        wire:model.live="form.nivelEducativoSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                        const medioOption = selectedOption.getAttribute('data-area-options');
                                        $wire.set('form.nivelEducativoSelectedPivot', medioOption);"
                                        @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                        , 'border-2 border-red-500'=> $errors->has('form.nivelEducativoSelected')
                                        ])
                                        >

                                        <option value="">{{ __('Seleccione una opción') }}</option>
                                        @foreach($nivelEducativo as $nivel)
                                        <option value="{{ $nivel->id }}" data-nivel-options="{{ $nivel->pivotid }}"
                                            wire:key='nivel-{{ $nivel->id }}'>
                                            {{ $nivel->nombre }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('form.nivelEducativoSelected')" class="mt-2"
                                        aria-live="assertive" />

                                </div>
                            </div>

                            <div class="col-span-full" x-Show="$wire.form.areaFormacionSelected && ($wire.form.areaFormacionSelected != {{ \App\Models\AreaFormacion::EDUCACION_BASICA }})">
                                <x-input-label for="curso">{{ __('Nombre del curso o nivel educativo al que accedió:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="curso" id="curso"
                                        wire:model='form.curso' rows="3"
                                        @class([ 'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                        , 'border-0 border-slate-300'=> $errors->missing('form.curso'),
                                        'border-2 border-red-500' => $errors->has('form.curso'),
                                    //   'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])></textarea>
                                    <x-input-error :messages="$errors->get('form.curso')" class="mt-2"
                                        aria-live="assertive" />
                                </div>
                            </div>


                            <div class="sm:col-span-4">
                                <x-input-label for="tipoModalidad">{{ __('Seleccione el tipo de modalidad') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="tipoModalidad"
                                        wire:model='form.tipoModalidad' id="tipoModalidad"
                                        :options="collect([])" selected="Seleccione el tipo de estudio"
                                        @class([ 'block w-full mt-1' ,'border-2 border-red-500'=>
                                        $errors->has('form.tipoModalidad')
                                        ])
                                        />
                                        <x-input-error :messages="$errors->get('form.tipoModalidad')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>



                            <!-- Dynamic Fields Section -->
                            <div x-data="{ fields: [{ id: Date.now() }] }" class="mt-4 col-span-full">

                                {{-- <button type="button" x-on:click="fields.push({ id: Date.now() })" class="px-4 py-2 font-semibold text-white bg-blue-500 rounded">
                                    Agregar más
                                </button> --}}

                                {{-- <template x-for="(field, index) in fields" :key="field.id"> --}}
                                    <div class="p-4 mt-4 border rounded-lg">


                                        <!-- Dropdown -->
                                        <div class="mt-2">
                                            <label :for="'dropdown_' + field.id" class="block text-sm font-medium text-gray-700">
                                                Seleccione el medio de verificación <x-required-label /></label>
                                            <select :id="'dropdown_' + field.id"



                                            wire:model="form.medioVerificacionSelected"
                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const medioOption = selectedOption.getAttribute('data-medio-options');
                                            $wire.set('form.medioVerificacionSelectedPivot', medioOption);"

                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                            , 'border-2 border-red-500'=> $errors->has('form.medioVerificacionSelected')
                                            ])
                                            >
                                                <option value="">{{ __('Seleccione una opción') }}</option>
                                                @foreach($mediosVerificacion as $medio)
                                                <option value="{{ $medio->id }}" data-medio-options="{{ $medio->pivotid }}"
                                                    wire:key='medio-{{ $medio->id }}'>
                                                    {{ $medio->nombre }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- File Input -->
                                        <div class="mt-2">
                                            {{-- <label :for="'file_' + field.id" class="block text-sm font-medium text-gray-700">File</label> --}}
                                            <div class="mt-2" x-data="{ uploading: false, progress: 0 }"
                                                x-on:livewire-upload-start="uploading = true"
                                                x-on:livewire-upload-finish="uploading = false"
                                                x-on:livewire-upload-cancel="uploading = false"
                                                x-on:livewire-upload-error="uploading = false"
                                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                                                >

                                                <!-- File Input -->
                                                <x-input-label for="form.medio_verificacion_upload"
                                                    class="block py-3 mt-2 mb-2">{{ __('Cargue el medios de
                                                    verificación') }}
                                                </x-input-label>


                                                <input type="file" :id="'file_' + field.id" wire:model="form.medio_verificacion_upload"
                                                @class([ "w-full text-sm font-semibold text-gray-400 bg-white border rounded cursor-pointer file:cursor-pointer file:border-0 file:py-3 file:px-4 file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500"
                                                ]) >
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


                                            {{-- <input type="file" :id="'file_' + field.id" class="block w-full text-sm text-gray-900 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"> --}}
                                        </div>

                                        <!-- Remove Button -->
                                        {{-- <button type="button" x-on:click="fields.splice(index, 1)" class="px-4 py-2 mt-4 font-semibold text-white bg-red-500 rounded">
                                            Eliminar
                                        </button> --}}
                                    </div>
                                {{-- </template> --}}

                                <x-input-error :messages="$errors->get('form.medioVerificacionSelected')" class="mt-2" aria-live="assertive" />
                            </div>





                            <div class="col-span-full">
                                <x-input-label for="coberturaSelected">{{ __('Información adicional que desee mencionar sobre la formación de la o el joven:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="otro_tipo_estudio" id="otro_tipo_estudio"
                                        wire:model='form.otro_tipo_estudio' rows="3"
                                        @class([ 'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                        , 'border-0 border-slate-300'=> $errors->missing('form.otro_tipo_estudio'),
                                        'border-2 border-red-500' => $errors->has('form.otro_tipo_estudio'),
                                    //   'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])></textarea>
                                    <x-input-error :messages="$errors->get('form.otro_tipo_estudio')" class="mt-2"
                                        aria-live="assertive" />
                                </div>
                            </div>



                        </div>
                    </div>
                    <div class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
                        <x-resultadocuatro.form.submit label="Guardar" />
                    </div>
                </div>
            </div>

        </form>

        <x-resultadocuatro.form.notifications />

        <livewire:resultadocuatro.gestor.directorio.create.modal :$pais :$proyecto wire:key='123' />

    </div>

    @script
    <script>
        document.addEventListener('livewire:navigated', function () {
           // alert("hola");
            // Initialize Choices.js for the second dropdown
            let subcategorySelect = new Choices($wire.$el.querySelector('[data-choice]'), { shouldSort: false });

            // Listen for changes in Livewire and update the second dropdown accordingly
            Livewire.on('refresh-list-directorios', subcategories => {

                console.log(typeof subcategories, subcategories.length);

                console.log(subcategories[0]);

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
    {{-- const arrayExtracted = Array.from(this.$wire.form.serviciosDesarrollarSelectedBase);
    const otherValues = ['13', 13];
    otherValues.some(value => arrayExtracted.includes(value) --}}
    @script
    <script>
        Alpine.data('serviciosDesarrollar', () => ({

        showDiv: false,

        init() {

            this.showDiv = Array.from(this.$wire.form.serviciosDesarrollarSelectedBase).includes(13);

            this.$watch('$wire.form.serviciosDesarrollarSelectedBase', () => {
                this.checkOtherserviciosDesarrollarSelectedBase()
            })

        },
        checkOtherserviciosDesarrollarSelectedBase() {

            // const arrayExtracted = Array.from(this.$wire.form.serviciosDesarrollarSelectedBase);
            // this.showDiv = arrayExtracted.includes($wire.form.otroProyectoVidaEspecificar.toString() || $wire.form.otroProyectoVidaEspecificar);

            const arrayExtracted = Array.from(this.$wire.form.serviciosDesarrollarSelectedBase);

            const otherValues = [13, '13'];
            this.showDiv = otherValues.some(value => arrayExtracted.includes(value));
            console.log(arrayExtracted);
            console.log(otherValues.some(value => arrayExtracted.includes(value)));
        },

    }));
    </script>
    @endscript
    @script
    <script>
        Alpine.data('habilidadesAdquirir', () => ({

        showDiv: false,

        init() {

            this.showDiv = Array.from(this.$wire.form.habilidadSelectedBase).includes(10);

            this.$watch('$wire.form.habilidadSelectedBase', () => {
                this.checkOtherhabilidadSelectedBase()
            })

        },
        checkOtherhabilidadSelectedBase() {

            // const arrayExtracted = Array.from(this.$wire.form.habilidadSelectedBase);
            // this.showDiv = arrayExtracted.includes($wire.form.otroProyectoVidaEspecificar.toString() || $wire.form.otroProyectoVidaEspecificar);

            const arrayExtracted = Array.from(this.$wire.form.habilidadSelectedBase);

            const otherValues = [10, '10'];
            this.showDiv = otherValues.some(value => arrayExtracted.includes(value));
        },

    }));
    </script>
    @endscript
