<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 4: {{ $titulo }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
    </x-slot>
    <div>

        <form  wire:key='form-empleabilidad-glass' id="form-empleabilidad">

            <div class="space-y-10 divide-y divide-gray-900/10" x-data="form">

                <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
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
                                            wire:model.live="form.medioVidaSelected"
                                                disabled="disabled"
                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
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


                                <div class="col-span-full">
                                    <x-input-label for="coberturaSelected">{{ __('Nombre de la empresa') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <div wire:ignore>
                                            <select wire:model="form.directorioSelected" data-choice
                                                    disabled="disabled"
                                                wire:change="$set('form.directorioSelected', $event.target.value)"
                                                id="directorioSelected" @class([ 'block w-full mt-1' ,'border-2
                                                border-red-500'=> $errors->has('form.directorioSelected'),
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
                                                ])
                                                >
                                                <option value="">Seleccione una organización</option>
                                                @foreach($directorio as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <x-input-label for="tipoEstudioSelected">{{ __('Seleccione el tipo de estudio') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="tipoEstudioSelected"
                                                disabled="disabled"
                                            wire:model.live="form.tipoEstudioSelected"
                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                            , 'border-2 border-red-500'=> $errors->has('form.tipoEstudioSelected'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
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
                                    </div>
                                </div>

                                <div class="col-span-full"
                                    x-show="$wire.form.tipoEstudioSelected == {{ \App\Models\TipoEstudio::OTRO }}">
                                    <x-input-label for="coberturaSelected">{{ __('Especifique:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="otro_tipo_estudio" id="otro_tipo_estudio"
                                                  disabled="disabled"
                                            wire:model='form.otro_tipo_estudio' rows="3"
                                            @class([ 'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                            , 'border-0 border-slate-300'=> $errors->missing('form.otro_tipo_estudio'),
                                            'border-2 border-red-500' => $errors->has('form.otro_tipo_estudio'),
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        ])></textarea>
                                    </div>
                                </div>



                                <div class="sm:col-span-4">
                                    <x-input-label for="areaFormacionSelected">{{ __('Seleccione el área de formación')
                                        }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="areaFormacionSelected"
                                                disabled="disabled"
                                            wire:model.live="form.areaFormacionSelected"
                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                            , 'border-2 border-red-500'=> $errors->has('form.areaFormacionSelected'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
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
                                    </div>
                                </div>
                                <div class="sm:col-span-2"></div>

                                <div class="sm:col-span-3"
                                    x-Show="$wire.form.areaFormacionSelected == {{ \App\Models\AreaFormacion::EDUCACION_BASICA }}">
                                    <x-input-label for="nivelEducativoFormacion">{{ __('Seleccione el nivel educativo')
                                        }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">

                                        <select name="nivelEducativoSelected" id="nivelEducativoSelected"
                                            wire:model.live="form.nivelEducativoSelected"
                                                disabled="disabled"
                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                            , 'border-2 border-red-500'=> $errors->has('form.nivelEducativoSelected'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
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
                                    </div>
                                </div>

                                <div class="col-span-full"
                                    x-Show="$wire.form.areaFormacionSelected && ($wire.form.areaFormacionSelected != {{ \App\Models\AreaFormacion::EDUCACION_BASICA }})">
                                    <x-input-label for="curso">{{ __('Nombre del curso o nivel educativo al que
                                        accedió:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="curso" id="curso" wire:model='form.curso' rows="3" disabled="disabled"
                                            @class([ 'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                            , 'border-0 border-slate-300'=> $errors->missing('form.curso'),
                                            'border-2 border-red-500' => $errors->has('form.curso'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        ])></textarea>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <x-input-label for="form.totalHorasDuracion">{{ __('Total de horas de duración') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.totalHorasDuracion" id="form.totalHorasDuracion"
                                                      disabled="disabled"
                                            name="form.totalHorasDuracion" type="number" step="1" min="1"
                                            @class([ 'block w-full mt-1' ,'border-2 border-red-500'=>
                                            $errors->has('form.totalHorasDuracion'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
                                            ])
                                            />
                                    </div>
                                </div>
                                <div class="sm:col-span-4"></div>


                                <div class="sm:col-span-4">
                                    <x-input-label for="tipoModalidad">{{ __('Seleccione el tipo de modalidad') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="tipoModalidad" wire:model='form.tipoModalidad'
                                                               disabled="disabled"
                                            id="tipoModalidad" :options="$tipomodalidades"
                                            selected="Seleccione el tipo de estudio" @class([ 'block w-full mt-1'
                                            ,'border-2 border-red-500'=> $errors->has('form.tipoModalidad'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
                                            ])
                                            />
                                    </div>
                                </div>

                                <div class="pb-5 mt-4 border-t col-span-full border-gray-900/10">
                                    <h2 class="mt-5 text-base font-semibold leading-7 text-gray-900">Medios de
                                        verificación</h2>
                                    <p class="mt-1 text-sm leading-6 text-gray-600">Debe de subir al menos un documento.
                                    </p>
                                </div>

                                <!-- Dynamic Fields Section -->
                                <div class="mt-2 col-span-full">
                                    <div class="p-4 mt-2 border rounded-lg">


                                        <!-- Dropdown -->
                                        <div class="mt-2">
                                            <label for="medioVerificacionSelected"
                                                class="block text-sm font-medium text-gray-700">
                                                Seleccione el medio de verificación
                                                <x-required-label />
                                            </label>
                                            <select id="medioVerificacionSelected" name="medioVerificacionSelected"
                                                    disabled="disabled"
                                                wire:model="form.medioVerificacionSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                                    const medioOption = selectedOption.getAttribute('data-medio-options');
                                                    $wire.set('form.medioVerificacionSelectedPivot', medioOption);"
                                                @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                , 'border-2 border-red-500'=>
                                                $errors->has('form.medioVerificacionSelected'),
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
                                                ])
                                                >
                                                <option value="">{{ __('Seleccione una opción') }}</option>
                                                @foreach($mediosVerificacion as $medio)
                                                <option value="{{ $medio->id }}"
                                                    data-medio-options="{{ $medio->pivotid }}"
                                                    wire:key='medio-{{ $medio->id }}'>
                                                    {{ $medio->nombre }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- File Input -->
                                        <div class="mt-2">
                                            @if ($form->firstFile)
                                                <div class="mt-2">
                                                    <a href="{{ Storage::disk('s3')->temporaryUrl($form->firstFile, \Carbon\Carbon::now()->addHour()) }}"
                                                        target="_blank" class="text-blue-500 underline">Archivo cargado</a>
                                                </div>
                                            @endif
                                        </div>

                                    </div>

                                </div>


                                <div x-data="" class="mt-4 col-span-full">
                                    <!-- Accordion Section -->
                                    <div x-data="{ open: $wire.form.secondFile }" class="mt-4 col-span-full">
                                        <div class="flex items-center justify-between p-4 border rounded-lg cursor-pointer"
                                            @click="open = !open">
                                            <h3 class="block text-sm font-medium text-gray-700">Subir otro medio de
                                                verificación <span class="text-sky-500">(Opcional)</span></h3>
                                            <svg :class="{ 'rotate-180': open }"
                                                class="w-5 h-5 transition-transform duration-200 transform" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                        <div x-show="open" class="p-4 mt-2 border rounded-lg">

                                            <!-- Dropdown -->
                                            <div class="mt-2">
                                                <label for="medioVerificacionSelectedDos"
                                                    class="block text-sm font-medium text-gray-700">
                                                    Seleccione el medio de verificación
                                                    <x-required-label />
                                                </label>
                                                <select id="medioVerificacionSelectedDos"
                                                    name="medioVerificacionSelectedDos"
                                                        disabled="disabled"
                                                    wire:model="form.medioVerificacionSelectedDos"
                                                    x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                                        const medioOption = selectedOption.getAttribute('data-medio-options');
                                                        $wire.set('form.medioVerificacionSelectedPivotDos', medioOption);"
                                                    @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                    , 'border-2 border-red-500'=>
                                                    $errors->has('form.medioVerificacionSelectedDos'),
                                                    'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
                                                    ])
                                                    >
                                                    <option value="">{{ __('Seleccione una opción') }}</option>
                                                    @foreach($mediosVerificacion as $medio)
                                                    <option value="{{ $medio->id }}"
                                                        data-medio-options="{{ $medio->pivotid }}"
                                                        wire:key='medio-{{ $medio->id }}'>
                                                        {{ $medio->nombre }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div x-data="" class="col-span-full">
                                    <!-- Accordion Section -->
                                    <div x-data="{ open: $wire.form.thirdFile }" class="col-span-full">
                                        <div class="flex items-center justify-between p-4 border rounded-lg cursor-pointer"
                                            @click="open = !open">
                                            <h3 class="block text-sm font-medium text-gray-700">Subir otro medio de
                                                verificación <span class="text-sky-500">(Opcional)</span></h3>
                                            <svg :class="{ 'rotate-180': open }"
                                                class="w-5 h-5 transition-transform duration-200 transform" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                        <div x-show="open" class="p-4 mt-2 border rounded-lg">

                                            <!-- Dropdown -->
                                            <div class="mt-2">
                                                <label for="medioVerificacionSelectedTres"
                                                    class="block text-sm font-medium text-gray-700">
                                                    Seleccione el medio de verificación
                                                    <x-required-label />
                                                </label>
                                                <select id="medioVerificacionSelectedTres"
                                                    name="medioVerificacionSelectedTres"
                                                        disabled="disabled"
                                                    wire:model="form.medioVerificacionSelectedTres"
                                                    x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                                        const medioOption = selectedOption.getAttribute('data-medio-options');
                                                        $wire.set('form.medioVerificacionSelectedPivotTres', medioOption);"
                                                    @class([
                                                    'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                    'border-2 border-red-500' => $errors->has('form.medioVerificacionSelectedTres'),
                                                    'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
                                                    ])
                                                    >
                                                    <option value="">{{ __('Seleccione una opción') }}</option>
                                                    @foreach($mediosVerificacion as $medio)
                                                    <option value="{{ $medio->id }}"
                                                        data-medio-options="{{ $medio->pivotid }}"
                                                        wire:key='medio-{{ $medio->id }}'>
                                                        {{ $medio->nombre }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                </div>


                                <div class="col-span-full">
                                    <x-input-label for="coberturaSelected">{{ __('Información adicional que desee
                                        mencionar sobre la formación de la o el joven:') }}
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="informacionAdicionalJoven" id="informacionAdicionalJoven"
                                                  disabled="disabled"
                                            wire:model='form.informacionAdicionalJoven' rows="3"
                                            @class([ 'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                            , 'border-0 border-slate-300'=> $errors->missing('form.informacionAdicionalJoven'),
                                            'border-2 border-red-500' => $errors->has('form.informacionAdicionalJoven'),
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        ])></textarea>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </form>

        <livewire:resultadocuatro.gestor.visualizador.forms.comentario :$pais :$proyecto :model="$ficha_formacion"  />
        <livewire:resultadocuatro.gestor.visualizador.estado-registro.index :model="$ficha_formacion" />

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
                subcategorySelect.refresh();
            });
        });
    </script>
    @endscript
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
