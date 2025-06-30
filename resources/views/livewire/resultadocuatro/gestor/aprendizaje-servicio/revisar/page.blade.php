<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 4: {{ $titulo }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
    </x-slot>
    <div>


        <form wire:key='form-empleabilidad-glass' id="form-empleabilidad">

            <div x-data="form" class="space-y-10 divide-y divide-gray-900/10">

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

                <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                    <div class="px-4 sm:px-0">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 1</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Datos de organización de acogida.</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-4" x-show="$wire.form.primerRegistro == false">

                                    <x-input-label for="form.cambiar">{{ __('¿Quiere cambiar de
                                        organización y/o institución?') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <div class="flex items-center space-x-4">
                                            <x-input-label class="flex items-center gap-2">
                                                <x-forms.input-radio type="radio"
                                                                     disabled="disabled"
                                                    wire:model.live="form.cambiar_organizacion"
                                                    id="form.cambiar_organizacion" wire:key="cambiar_organizacion1"
                                                    name="form.cambiar_organizacion" type="radio" value="1" />
                                                Si
                                            </x-input-label>
                                            <x-input-label class="flex items-center gap-2">
                                                <x-forms.input-radio type="radio"
                                                                     disabled="disabled"
                                                    wire:model.live="form.cambiar_organizacion"
                                                    id="form.cambiar_organizacion" wire:key="cambiar_organizacion2"
                                                    name="form.cambiar_organizacion" type="radio" value="0" />
                                                No
                                            </x-input-label>
                                        </div>
                                        <x-input-error :messages="$errors->get('form.cambiar_organizacion')" class="mt-2"
                                            aria-live="assertive" />
                                    </div>

                                </div>

                                <div class="sm:col-span-4" x-show="$wire.form.cambiar_organizacion == 1">
                                    <x-input-label for="form.cambiar">{{ __('¿Cuál es el motivo por el que se cambió de
                                        organización?') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="motivoCambioSelected"
                                            wire:model.live="form.motivoCambioSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                                const motivoOption = selectedOption.getAttribute('data-motivo-options');
                                                $wire.set('form.motivoCambioSelectedPivot', motivoOption);"
                                                disabled="disabled"
                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                            , 'border-2 border-red-500'=> $errors->has('form.motivoCambioSelected'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
                                            ])
                                            >

                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                            @foreach($motivoscambio as $motivo)
                                            <option value="{{ $motivo->id }}" data-motivo-options="{{ $motivo->pivotid }}"
                                                wire:key='motivo-{{ $motivo->id }}'>
                                                {{ $motivo->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-span-full">
                                    <x-input-label for="directorioSelected">{{ __('Nombre de la empresa') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <div wire:ignore>
                                            <select wire:model="form.directorioSelected" data-choice
                                                    disabled="disabled"
                                                wire:change="$set('form.directorioSelected', $event.target.value)"
                                                id="directorioSelected" @class([ 'block w-full mt-1' ,'border-2 border-red-500'=> $errors->has('form.directorioSelected'),
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
                                    <x-input-label for="coberturaSelected">{{ __('Tipo de organización') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.tipoinstitucion" id="form.fecha"
                                                name="form.tipoinstitucion" type="text" readonly="readonly"
                                                 disabled="disabled"
                                                disabled="true"
                                            @class([
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.tipoinstitucion')
                                            ])
                                        />
                                    </div>
                                </div>

                                <div class="sm:col-span-4">
                                    <x-input-label for="form.area">{{ __('Área
                                        de intervención de la organización de acogida') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.areaintervencion" id="form.area"
                                                name="form.areaintervencion" type="text" readonly="readonly"
                                                disabled="true"
                                            @class([
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',// => $form->readonly,
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.areaintervencion')
                                            ])
                                        />
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="programa_proyecto">{{ __('Programa/Proyecto/Dependencia
                                        de la organización') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="programa_proyecto" id="programa_proyecto" wire:model='form.programa_proyecto' rows="3"
                                                  disabled="disabled"
                                        @class([
                                            'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.programa_proyecto'),
                                            'border-2 border-red-500' => $errors->has('form.programa_proyecto'),
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        ])></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                    <div class="px-4 sm:px-0">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 2</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Lugar donde el/la participante realiza aprendizaje de servicio.</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <x-input-label for="coberturaSelected">{{ __('Departamento') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="departamento"
                                            wire:model.live='form.departamentoSelected'
                                            disabled="disabled"
                                            id="departamentoSelected" :options="$departamentos"
                                            selected="Seleccione un departamento"
                                            @class([
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.departamentoSelected')
                                            ])
                                            />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="coberturaSelected">{{ __('Municipio') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-forms.single-select name="ciudad_id" wire:model.live='form.ciudad_id'
                                            disabled="disabled" id="ciudad"
                                            :options="$ciudades"
                                            @class([
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.ciudad_id')
                                            ])
                                            selected="Seleccione un municipio"/>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="coberturaSelected">{{ __('Comunidad/Cantón/Aldea') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.comunidad" id="form.comunidad"
                                            name="form.comunidad" type="text"
                                            disabled="disabled"
                                            @class([
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.comunidad')
                                            ])
                                        />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                    <div class="px-4 sm:px-0">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 3</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Fechas prevista de desarrollo del aprendizaje de servicio.</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="max-w-2xl space-y-10">
                                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <x-input-label for="form.fecha_inicio_prevista">{{ __('Fecha inicio') }}
                                            <x-required-label />
                                        </x-input-label>
                                        <div class="mt-2">
                                            @if ($form->minDate || $form->maxDate)
                                                <x-text-input wire:model="form.fecha_inicio_prevista" id="form.fecha_inicio_prevista"
                                                    name="form.fecha_inicio_prevista" type="date"
                                                    min="{{ $form->minDate }}" max="{{ $form->maxDate }}"
                                                    disabled="disabled"
                                                    @class([
                                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_inicio_prevista')
                                                    ])
                                                />
                                            @else
                                                <x-text-input wire:model="form.fecha_inicio_prevista" id="form.fecha_inicio_prevista"
                                                    name="form.fecha_inicio_prevista" type="date"  disabled="disabled"
                                                @class([
                                                    'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                    'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_inicio_prevista')
                                                ])
                                                />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <x-input-label for="form.fecha_fin_prevista">{{ __('Fecha fin') }}
                                            <x-required-label />
                                        </x-input-label>
                                        <div class="mt-2">
                                            @if ($form->minDate || $form->maxDate)
                                                <x-text-input wire:model="form.fecha_fin_prevista" id="form.fecha_fin_prevista"
                                                        name="form.fecha_fin_prevista" type="date"
                                                        min="{{ $form->minDate }}" max="{{ $form->maxDate }}"
                                                        disabled="disabled"
                                                    @class([
                                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_fin_prevista')
                                                    ])
                                                />
                                            @else
                                                <x-text-input wire:model="form.fecha_fin_prevista" id="form.fecha_fin_prevista"
                                                        name="form.fecha_fin_prevista" type="date"
                                                        disabled="disabled"
                                                    @class([
                                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_fin_prevista')
                                                    ])
                                                />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                    <div class="px-4 sm:px-0">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 4</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Practica de aprendizaje de servicio se orientara a</p>
                    </div>

                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="max-w-2xl space-y-10">
                                <div class="col-span-full">
                                    <x-input-label for="discapacidades">{{ __('Seleccione los temas sobre los que realizara el aprendizaje de servicio:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <div class="px-4 py-3">
                                            <div class="max-w-2xl space-y-10">
                                                <x-input-label for="inclusion-social">{{ __('Inclusión Social') }}
                                                    <x-required-label />
                                                </x-input-label>
                                                <div class="grid grid-cols-2 gap-6">
                                                    @foreach ($inclusionSocialTema as $key => $value)
                                                    <div class="relative flex gap-x-3">
                                                        <div class="flex items-center h-6">
                                                            <x-text-input type="checkbox" name="inclusionSocialTema"
                                                                          disabled="disabled"
                                                                wire:key='inclusion-tema-{{$key}}'
                                                                wire:model="form.inclusionSocialTema"
                                                                value="{{ $key }}"
                                                                class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                                id="inclusion-tema-{{$key }}" />
                                                        </div>
                                                        <div class="text-sm leading-6">
                                                            <label for="inclusion-tema-{{$key }}" class="font-medium text-gray-900">
                                                                {{ $value }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>

                                                <x-input-label for="inclusion-social">{{ __('Medioambiente') }}
                                                    <x-required-label />
                                                </x-input-label>

                                                <div class="grid grid-cols-2 gap-6">
                                                    @foreach ($medioambienteTema as $key => $value)
                                                    <div class="relative flex gap-x-3">
                                                        <div class="flex items-center h-6">
                                                            <x-text-input type="checkbox" name="medioambienteTema"
                                                                wire:key='medioambiente-tema-{{$key}}'
                                                                wire:model="form.medioambienteTema"
                                                                value="{{ $key }}"
                                                                class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                                id="medioambiente-tema-{{$key }}" disabled="disabled" />
                                                        </div>
                                                        <div class="text-sm leading-6">
                                                            <label for="medioambiente-tema-{{$key }}" class="font-medium text-gray-900">
                                                                {{ $value }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>

                                                <x-input-label for="inclusion-social">{{ __('Cultura y Ciudadanía') }}
                                                    <x-required-label />
                                                </x-input-label>

                                                <div class="grid grid-cols-2 gap-6">
                                                    @foreach ($culturaTema as $key => $value)
                                                    <div class="relative flex gap-x-3">
                                                        <div class="flex items-center h-6">
                                                            <x-text-input type="checkbox" name="culturaTema"
                                                                wire:key='cultura-tema-{{$key}}'
                                                                wire:model="form.culturaTema"
                                                                value="{{ $key }}"
                                                                class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                                id="cultura-tema-{{$key }}" />
                                                        </div>
                                                        <div class="text-sm leading-6">
                                                            <label for="cultura-tema-{{$key }}" class="font-medium text-gray-900">
                                                                {{ $value }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="discapacidades">{{ __('Seleccione los servicios sobre los que realizará el aprendizaje de servicio:') }}
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
                                                            x-on:change="event.target.checked
                                                                ? $wire.form.serviciosDesarrollarSelectedBase.push(+event.target.getAttribute('data-org-key'))
                                                                : $wire.form.serviciosDesarrollarSelectedBase = $wire.form.serviciosDesarrollarSelectedBase.filter(key => +key !== +event.target.getAttribute('data-org-key'))"
                                                                wire:key='servicio-{{$servicio->id}}'
                                                                wire:model="form.serviciosDesarrollarSelected"
                                                                value="{{ $servicio->pivotid }}"
                                                                class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                                data-org-key="{{ $servicio->id }}"
                                                                id="servicio-{{$servicio->id }}" disabled="disabled" />
                                                        </div>
                                                        <div class="text-sm leading-6">
                                                            <label for="servicio-{{$servicio->id }}" class="font-medium text-gray-900">
                                                                {{ $servicio->nombre }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-full"
                                x-data="serviciosDesarrollar" x-show="showDiv">
                                    <x-input-label for="discapacidades">{{ __('Escriba los servicios
                                        seleccionados') }}

                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="descripcion_otros_servicios_desarrollar" id="descripcion_otros_servicios_desarrollar" wire:model='form.descripcion_otros_servicios_desarrollar' rows="3"
                                                  disabled="disabled"
                                        @class([
                                            'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.descripcion_otros_servicios_desarrollar'),
                                            'border-2 border-red-500' => $errors->has('form.descripcion_otros_servicios_desarrollar'),
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        ])></textarea>
                                        <x-input-error :messages="$errors->get('form.descripcion_otros_servicios_desarrollar')" class="mt-2"
                                                aria-live="assertive" />
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="discapacidades">{{ __('Seleccione las Habilidades a adquirir:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <div class="px-4 py-3">
                                            <div class="max-w-2xl space-y-10">
                                                <div class="grid grid-cols-2 gap-6">
                                                    @foreach ($habilidades as $habilidad)
                                                    <div class="relative flex gap-x-3">
                                                        <div class="flex items-center h-6">
                                                            <x-text-input type="checkbox" name="habilidadSelected"
                                                            x-on:change="event.target.checked
                                                            ? $wire.form.habilidadSelectedBase.push(+event.target.getAttribute('data-org-key'))
                                                            : $wire.form.habilidadSelectedBase = $wire.form.habilidadSelectedBase.filter(key => +key !== +event.target.getAttribute('data-org-key'))"
                                                                wire:key='habilidad-{{$habilidad->id}}'
                                                                wire:model="form.habilidadSelected"
                                                                value="{{ $habilidad->pivotid }}"
                                                                class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                                data-org-key="{{ $habilidad->id }}"
                                                                id="habilidad-{{$habilidad->id }}" />
                                                        </div>
                                                        <div class="text-sm leading-6">
                                                            <label for="habilidad-{{$habilidad->id }}" class="font-medium text-gray-900">
                                                                {{ $habilidad->nombre }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-full" x-data="habilidadesAdquirir" x-show="showDiv">
                                    <x-input-label for="discapacidades">{{ __('Escriba las
                                        habilidades seleccionadas') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="descripcion_habilidad_adquirir" id="descripcion_habilidad_adquirir" wire:model='form.descripcion_habilidad_adquirir' rows="3"
                                            @class([
                                                'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                                'border-0 border-slate-300'=> $errors->missing('form.descripcion_habilidad_adquirir'),
                                                'border-2 border-red-500' => $errors->has('form.descripcion_habilidad_adquirir'),
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' ,
                                            ])></textarea>
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="otros_conocimientos">{{ __('Otros conocimientos,
                                        habilidades o aprendizajes a adquirir') }}
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="otros_conocimientos" id="otros_conocimientos" wire:model='form.otros_conocimientos' rows="3" disabled="disabled"
                                        @class([
                                            'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.otros_conocimientos'),
                                            'border-2 border-red-500' => $errors->has('form.otros_conocimientos'),
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        ])></textarea>
                                    </div>
                                </div>
                                <div class="col-span-full">
                                    <x-input-label for="titulo_contribucion_cambio">{{ __('Titulo contribución al cambio') }}
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="titulo_contribucion_cambio" id="titulo_contribucion_cambio" wire:model='form.titulo_contribucion_cambio' rows="3" disabled="disabled"
                                        @class([
                                            'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.titulo_contribucion_cambio'),
                                            'border-2 border-red-500' => $errors->has('form.titulo_contribucion_cambio'),
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        ])></textarea>
                                    </div>
                                </div>
                                <div class="col-span-full">
                                    <x-input-label for="objetivo_contribucion_cambio">{{ __('Escriba el objetivo principal de contribución al cambio') }}
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="objetivo_contribucion_cambio" id="objetivo_contribucion_cambio" wire:model='form.objetivo_contribucion_cambio' rows="3" disabled="disabled"
                                        @class([
                                            'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.objetivo_contribucion_cambio'),
                                            'border-2 border-red-500' => $errors->has('form.objetivo_contribucion_cambio'),
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        ])></textarea>
                                    </div>
                                </div>
                                <div class="col-span-full">
                                    <x-input-label for="acciones_contribucion_cambio">{{ __('Escriba las principales acciones de contribución al cambio') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="acciones_contribucion_cambio" id="acciones_contribucion_cambio" wire:model='form.acciones_contribucion_cambio' rows="3" disabled="disabled"
                                        @class([
                                            'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.acciones_contribucion_cambio'),
                                            'border-2 border-red-500' => $errors->has('form.acciones_contribucion_cambio'),
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        ])></textarea>
                                    </div>
                                </div>

                                <div class="max-w-2xl space-y-10">
                                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                        <div class="sm:col-span-1">
                                            <x-input-label for="form.fecha_inicio_cambio">{{ __('Fecha inicio de contribución al cambio') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                @if ($form->minDate || $form->maxDate)
                                                    <x-text-input wire:model="form.fecha_inicio_cambio" id="form.fecha_inicio_cambio"
                                                        name="form.fecha_inicio_cambio" type="date"
                                                        min="{{ $form->minDate }}" max="{{ $form->maxDate }}"
                                                        disabled="disabled"
                                                    @class([
                                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_inicio_cambio')
                                                    ])
                                                    />
                                                @else
                                                    <x-text-input wire:model="form.fecha_inicio_cambio" id="form.fecha_inicio_cambio"
                                                        name="form.fecha_inicio_cambio" type="date"
                                                        disabled="disabled"
                                                    @class([
                                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_inicio_cambio')
                                                    ])
                                                    />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="sm:col-span-1">
                                            <x-input-label for="form.fecha_fin_cambio">{{ __('Fecha fin de contribución al cambio') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                @if ($form->minDate || $form->maxDate)
                                                    <x-text-input wire:model="form.fecha_fin_cambio" id="form.fecha_fin_cambio"
                                                            name="form.fecha_fin_cambio" type="date"
                                                            min="{{ $form->minDate }}" max="{{ $form->maxDate }}"
                                                            disabled="disabled"
                                                        @class([
                                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_fin_cambio')
                                                        ])
                                                    />
                                                @else
                                                    <x-text-input wire:model="form.fecha_fin_cambio" id="form.fecha_fin_cambio"
                                                            name="form.fecha_fin_cambio" type="date"
                                                            disabled="disabled"
                                                        @class([
                                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_fin_cambio')
                                                        ])
                                                    />
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="max-w-2xl space-y-10">
                                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">
                                        <div class="sm:col-span-1">
                                            <x-input-label for="form.promedio_aprendizaje">{{ __('Cantidad promedio de personas atendidas durante el aprendizaje de servicio') }}
                                                <x-required-label />
                                            </x-input-label>
                                            <div class="mt-2">
                                                    <x-text-input wire:model="form.promedio_aprendizaje" id="form.promedio_aprendizaje"
                                                        name="form.promedio_aprendizaje" type="number" step="1" min="1"
                                                        disabled="disabled"
                                                    @class([
                                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.promedio_aprendizaje')
                                                    ])
                                                    />
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-span-full">
                                    <x-input-label for="otros_comentarios">{{ __('Otros comentarios') }}
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="otros_comentarios" id="otros_comentarios" wire:model='form.otros_comentarios' rows="3" disabled="disabled"
                                        @class([
                                            'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.otros_comentarios'),
                                            'border-2 border-red-500' => $errors->has('form.otros_comentarios'),
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
        <livewire:resultadocuatro.gestor.visualizador.forms.comentario :$pais :$proyecto :model="$aprendizajeServicio"  />
        <livewire:resultadocuatro.gestor.visualizador.estado-registro.index :model="$aprendizajeServicio" />

    </div>

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
