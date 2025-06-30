<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 4: {{ $titulo }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
    </x-slot>
    <div>
        <form>
            <div class="space-y-10 divide-y divide-gray-900/10" x-data="form">
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
                                                disabled="disabled"
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
                                    </div>
                                </div>


                                <div class="sm:col-span-4">
                                    <x-input-label for="coberturaSelected">{{ __('Está vinculado debido
                                        a:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="vinculadoDebidoSelected"
                                            wire:model.live="form.vinculadoDebidoSelected"
                                                disabled="disabled"
                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
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
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        ])></textarea>
                                    </div>
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
                                                disabled="@disabled()"
                                            @class([
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_inicio_voluntariado')
                                            ])
                                        />
                                       @else
                                        <x-text-input wire:model="form.fecha_inicio_voluntariado" id="form.fecha"
                                                name="form.fecha_inicio_voluntariado" type="date"
                                                disabled="@disabled()"
                                            @class([
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_inicio_voluntariado')
                                            ])
                                        />
                                       @endif
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
                                               'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                               'block w-full mt-1','border-2 border-red-500' => $errors->has('form.areaIntervencionNombre')
                                           ])
                                       />
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
                                               'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
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
                                                disabled="disabled"
                                            @class([
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.promedio_horas')
                                            ])
                                        />
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
                                                                data-value="{{ $servicio->nombre }}"
                                                                          disabled="disabled"
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
                                                      disabled="disabled"
                                            @class([
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.servicio_otro'),
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
                                            ])
                                        />
                                    </div>
                                </div>



                                <div class="col-span-full">
                                    <x-input-label for="medioVerificacionSelected">{{ __('Seleccione los Medios
                                        de verificación del voluntariado:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <select name="perfiles" id="medioVerificacionSelected"
                                            wire:model.live="form.medioVerificacionSelected"
                                                disabled="disabled"
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'border-2 border-red-500'=> $errors->has('form.medioVerificacionSelected'),
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'
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
                                </div>

                                <div class="col-span-full">
                                    <x-input-label for="medioVerificacionSelected">{{ __('Información adicional
                                        que desee mencionar sobre el empleo de la o el joven:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="informacionAdicionalJoven" id="informacionAdicionalJoven" wire:model='form.informacionAdicionalJoven' rows="3"
                                                  disabled="disabled"
                                        @class([
                                        'block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                        'border-0 border-slate-300'=> $errors->missing('form.informacionAdicionalJoven'),
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
        <livewire:resultadocuatro.gestor.visualizador.forms.comentario :$pais :$proyecto :model="$voluntario"  />
        <livewire:resultadocuatro.gestor.visualizador.estado-registro.index  :model="$voluntario" />
    </div>
