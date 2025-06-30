<form>
    <div class="space-y-10 divide-y divide-gray-900/10">

        <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">SECCIÓN I</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">GENERALIDADES DE SOCIO</p>
            </div>


            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        <div class="sm:col-span-3">
                            <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">N°
                                de
                                cohorte</label>
                            <div class="mt-2">
                                {{ $cohorte->nombre }}
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="last-name"
                                class="block text-sm font-medium leading-6 text-gray-900">Socio
                                implementador</label>
                            <div class="mt-2">
                                {{ $user->socioImplementador->nombre }}
                            </div>
                        </div>


                        <div class="sm:col-span-3">
                            <label for="website" class="block text-sm font-medium leading-6 text-gray-900">3.
                                Fecha
                                de levantamiento de información: </label>
                            <div class="mt-2">
                                {{ $participante->dateForHumans() }}
                            </div>
                        </div>
{{--
                        <div class="sm:col-span-3">
                            <label for="about" class="block text-sm font-medium leading-6 text-gray-900">4.
                                Modalidad de programa</label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <fieldset>
                                        <legend class="text-sm font-semibold leading-6 text-gray-900">

                                        </legend>
                                    </fieldset>
                                </div>
                            </div>
                        </div> --}}
                        <div class="sm:col-span-3">
                            <label for="about" class="block text-sm font-medium leading-6 text-gray-900">4.
                                Nombre de
                                Persona encuestada</label>
                            <div class="px-4">
                                <div class="max-w-2xl space-y-10">
                                    <fieldset>
                                        <legend class="text-sm font-semibold leading-6 text-gray-900">
                                            {{ $participante->full_name }}
                                        </legend>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">SECCIÓN II</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">DATOS GENERALES DE PARTICIPANTE</p>
            </div>

            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-2">
                            <x-input-label for="form.primer_nombre">{{ __('Primer nombre') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model.blur="form.primer_nombre" id="form.primer_nombre"
                                    name="form.primer_nombre" type="text"
                                    :$disabled
                                    @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.primer_nombre')
                                    ])
                                />
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <x-input-label for="form.segundo_nombre">{{ __('Segundo nombre') }}
                            </x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model.blur="form.segundo_nombre" id="form.segundo_nombre"
                                    name="form.segundo_nombre" type="text"
                                    :$disabled
                                    @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.segundo_nombre')
                                    ])
                                    />
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <x-input-label for="form.tercer_nombre">{{ __('Tercer nombre') }}
                            </x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model.blur="form.tercer_nombre" id="form.tercer_nombre"
                                    name="form.tercer_nombre" type="text"
                                    :$disabled
                                    @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.tercer_nombre')
                                    ])
                                />
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <x-input-label for="form.primer_apellido">{{ __('Primer apellido') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model.blur="form.primer_apellido"
                                    id="form.primer_apellido" name="form.primer_apellido" type="text"
                                    :$disabled
                                    @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.primer_apellido')
                                    ])
                                />
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <x-input-label for="form.segundo_apellido">{{ __('Segundo apellido') }}
                            </x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model.blur="form.segundo_apellido"
                                    id="form.segundo_apellido" name="form.segundo_apellido" type="text"
                                    :$disabled
                                    @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.segundo_apellido')
                                    ])
                                />
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <x-input-label for="form.tercer_apellido">{{ __('Tercer apellido') }}
                            </x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model.blur="form.tercer_apellido"
                                    id="form.tercer_apellido" name="form.tercer_apellido" type="text"
                                    :$disabled
                                    @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.tercer_apellido')
                                    ])
                                />

                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <x-input-label for="form.fecha_nacimiento">{{ __('Fecha de nacimiento') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.fecha_nacimiento" id="form.fecha_nacimiento"
                                 name="form.fecha_nacimiento" type="date" :$disabled
                                    @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_nacimiento')
                                    ])
                                />
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <x-input-label for="form.nacionalidad">{{ __('Nacionalidad') }} <x-required-label /></x-input-label>
                            <div class="px-4 py-3">
                                <div class="flex gap-6">
                                    <x-input-label class="flex items-center gap-2">
                                        <x-forms.input-radio type="radio" wire:model="form.nacionalidad" id="form.nacionalidad" wire:key="nacionalidad1"
                                        name="form.nacionalidad" type="radio" value="1"
                                        @class([ 'w-4 h-4' ])
                                         :$disabled/>
                                        Nacional
                                    </x-input-label>
                                    <x-input-label class="flex items-center gap-2">
                                        <x-forms.input-radio type="radio" wire:model="form.nacionalidad" id="form.nacionalidad" wire:key="nacionalidad2"
                                        name="form.nacionalidad" type="radio" value="2" :$disabled/>
                                        Extranjero
                                    </x-input-label>
                                </div>
                                <x-input-error :messages="$errors->get('form.nacionalidad')" class="mt-2" aria-live="assertive"/>
                            </div>
                        </div>


                        <div class="col-span-full">
                            <x-input-label for="form.estado_civil">{{ __('Estado civil') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <div class="px-4 py-3">
                                    <div class="max-w-2xl space-y-10">
                                        <fieldset>
                                            <div class="grid grid-cols-2 gap-6">
                                                @foreach ($estadosCiviles as $key => $value)
                                                <x-input-label class="flex items-center gap-4">
                                                    <x-forms.input-radio type="radio"
                                                        :$disabled
                                                        wire:model="form.estado_civil_id"
                                                        id="form.estado_civil_id"
                                                        wire:key="estado-civil-{{ $key }}"
                                                        name="form.estado_civil_id" type="radio"
                                                        value="{{ $key }}" />{{ $value }}
                                                </x-input-label>
                                                @endforeach
                                            </div>
                                            <x-input-error :messages="$errors->get('form.estado_civil_id')"
                                                class="mt-2" aria-live="assertive" />
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <x-input-label for="perfilSelected">{!! __('¿A cuál perfil se está registrando al jóven?') !!}
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-2">
                                <select
                                    wire:model='form.perfilSelected'
                                    class = "block w-full border-gray-300 rounded-md shadow-sm sm:text-sm sm:leading-6 focus:border-indigo-500 focus:ring-indigo-500"
                                    @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled,
                                    ])
                                    disabled="{{ $disabled ? 'disabled' : '' }}"
                                >
                                    <option value="" selected>Seleccione una opción</option>
                                    @foreach ($cohortePaisProyecto->perfilesParticipante as $perfil)
                                    <option value="{{ $perfil->pivot->id }}"
                                            wire:key='{{ $perfil->nombre . '-'. $perfil->pivot->id }}'>
                                        {{ $perfil->nombre }}
                                    </option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('form.perfilSelected')"
                                        class="mt-2" aria-live="assertive" />
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <x-input-label for="ciudad">{{ __('¿Estima que contará con el tiempo necesario para atender las actividades asignadas por el programa?') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-2">
                                <x-forms.single-select name="tiempo_atender_actividades" wire:model='form.tiempo_atender_actividades'
                                    :$disabled id="ciudad"
                                    :options="collect(['1' => 'Si', '2' => 'No', '3' => 'No sabe'])"
                                    @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled,
                                        'block w-full mt-1','border-2 border-red-500' => $errors->has('form.tiempo_atender_actividades')
                                    ])
                                    selected="Seleccione una opción"/>
                                    <x-input-error :messages="$errors->get('form.tiempo_atender_actividades')" class="mt-2"
                                        aria-live="assertive" />
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <h2 class="mb-2 text-base font-semibold leading-7 text-gray-900">Domicilio</h2>
                            <x-input-label for="form.tipo_zona_residencia">{{ __('¿En qué tipo de zona resides?') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <div class="px-4">
                                    <div class="max-w-2xl space-y-10">
                                        <fieldset>
                                            <div class="flex grid-cols-2 gap-6">
                                                <x-input-label class="flex items-center gap-4" for="urbana">
                                                    <x-forms.input-radio type="radio" wire:model="form.tipo_zona_residencia"
                                                        value="1" id="urbana" :$disabled/>
                                                    Zona urbana (Ciudad, áreas metropolitanas)
                                                </x-input-label>
                                                <x-input-label class="flex items-center gap-4" for="rural">
                                                    <x-forms.input-radio type="radio" wire:model="form.tipo_zona_residencia"
                                                        value="2" id="rural" :$disabled/>
                                                    Zona rural (Pueblos, aldeas, áreas agrícolas)
                                                </x-input-label>
                                            </div>
                                            <x-input-error :messages="$errors->get('form.tipo_zona_residencia')" class="mt-2" aria-live="assertive"/>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="sm:col-span-3">
                            <x-input-label for="departamentoSelected">{{ __('Departamento') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-forms.single-select name="departamento" wire:model.live='form.departamentoSelected'
                                    id="departamentoSelected" :options="$departamentos" selected="Seleccione un departamento"
                                    @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled, 'block w-full mt-1','border-2 border-red-500' => $errors->has('form.departamentoSelected')])
                                    :$disabled />
                                <x-input-error :messages="$errors->get('form.departamentoSelected')" class="mt-2" aria-live="assertive"/>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <x-input-label for="ciudad">{{ __('Municipio') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-forms.single-select name="ciudad_id" wire:model.live='form.ciudad_id'
                                    id="ciudad"
                                    :options="$ciudades"
                                    @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled, 'block w-full mt-1','border-2 border-red-500' => $errors->has('form.ciudad_id')])
                                    selected="Seleccione un municipio" :$disabled />
                                <x-input-error :messages="$errors->get('form.ciudad_id')" class="mt-2" aria-live="assertive"/>
                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="colonia">{{ __('Comunidad / Colonia') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.colonia" id="form.colonia"
                                    disabled="disabled" name="form.colonia"
                                    type="text"
                                    @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> true,
                                    'block w-full mt-1','border-2 border-red-500' =>
                                    $errors->has('form.colonia')])
                                    />
                                    <x-input-error :messages="$errors->get('form.colonia')" class="mt-2"
                                        aria-live="assertive" />
                            </div>
                        </div>

                        @if($form->pais->id == App\Models\Pais::HONDURAS)
                        <x-participante.index.direccion_honduras :$form :$disabled/>
                        @elseif($form->pais->id == App\Models\Pais::GUATEMALA)
                        <x-participante.index.direccion_guatemala :$form :$disabled/>
                        @else
                        {{--
                        <x-participante.index.direccion_default :$form /> --}}
                        @endif

                        <div class="col-span-full">
                            <x-input-label for="direccion">
                                @if(App\Models\Pais::HONDURAS == $form->pais->id)
                                {{ __('Punto de referencia domicilio') }}
                                @elseif(App\Models\Pais::GUATEMALA == $form->pais->id)
                                {{ __('Dirección') }}
                                @else
                                {{ __('Dirección completa con puntos de referencia') }}
                                @endif
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-2">
                                <textarea name="direccion" id="direccion" wire:model='form.direccion'
                                    rows="3" {{ $form->readonly || ($disabled ?? false) ? 'disabled' : '' }}
                                @class(['block w-full rounded-md py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                , 'border-0 border-slate-300'=> $errors->missing('form.direccion'),
                                'border-2 border-red-500' => $errors->has('form.direccion'),
                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly || ($disabled ?? false) ? 'disabled' : ''
                            ])></textarea>
                                <x-input-error :messages="$errors->get('form.direccion')" class="mt-2"
                                    aria-live="assertive" />
                            </div>
                        </div>

                        <div class="sm:col-span-4">
                            <x-input-label for="sexo">{{ __('Sexo según registro nacional') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <div class="px-4 py-3">
                                    <div class="max-w-2xl space-y-10">
                                        <fieldset>
                                            <div class="flex grid-cols-2 gap-6">
                                                <x-input-label class="flex items-center gap-4" for="mujer">
                                                    <x-forms.input-radio type="radio" wire:model="form.sexo"
                                                        value="1" id="mujer" :$disabled />
                                                    Mujer
                                                </x-input-label>
                                                <x-input-label class="flex items-center gap-4" for="hombre">
                                                    <x-forms.input-radio type="radio" wire:model="form.sexo"
                                                        value="2" id="hombre" :$disabled />
                                                    Hombre
                                                </x-input-label>
                                            </div>
                                            <x-input-error :messages="$errors->get('form.sexo')" class="mt-2" aria-live="assertive"/>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="discapacidades">{{ __(' ¿Posee algún tipo de discapacidad?') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <div class="px-4 py-3">
                                    <div class="max-w-2xl space-y-10">
                                        <div class="grid grid-cols-2 gap-6">
                                            @foreach ($discapacidades as $key => $value)
                                            <div class="relative flex gap-x-3">
                                                <div class="flex items-center h-6">
                                                    <x-text-input type="checkbox" name="discapacidad"
                                                        wire:key='discapacidad{{$key}}'
                                                        :$disabled
                                                        wire:model.live="form.discapacidadesSelected"
                                                        value="{{ $key}}"
                                                        class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                        id="discapacidad{{$key}}" />
                                                </div>
                                                <div class="text-sm leading-6">
                                                    <label for="discapacidad{{$key}}"
                                                        class="font-medium text-gray-900">{{ $value
                                                        }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <x-input-error
                                            :messages="$errors->get('form.discapacidadesSelected')"
                                            class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="form.comunidad_etnica">{{ __('¿A cuál comunidad étnica pertenece?') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-2">
                                @foreach ($gruposEtnicos->sortByDesc(function($grupo) { }) as $grupo)
                                    <div class="px-4 py-3">
                                        <div class="max-w-2xl space-y-10">
                                            <fieldset>
                                                <legend class="text-sm font-semibold leading-6 text-gray-900 uppercase">+ {{ $grupo->nombre }}
                                                </legend>

                                                <div class="grid grid-cols-2 gap-6 mt-6 md:grid-cols-3">
                                                    @foreach ($grupo->comunidadesEtnicas as $comunidad)
                                                    <x-input-label class="flex items-center gap-4"
                                                        for="comunidad{{ $comunidad->id }}">
                                                        <x-forms.input-radio wire:model="form.comunidad_etnica"
                                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                                            value="{{ $comunidad->id }}"
                                                            wire:key="comunidad{{ $comunidad->id }}"
                                                            id="comunidad{{ $comunidad->id }}" />
                                                        {{ $comunidad->nombre }}
                                                    </x-input-label>
                                                    @endforeach
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if($form->pais->id == 1)
                            <div class="col-span-full">
                                <x-input-label for="comunidad_linguistica">{{ __('¿Qué idiomas habla?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <div class="px-4 py-3">
                                        <div class="max-w-2xl space-y-10">
                                            <div class="grid grid-cols-2 gap-6 md:grid-cols-3">
                                                @foreach ($comunidadesLinguisticas->sortByDesc(function($comunidad) {
                                                    return str_contains($comunidad->nombre, 'Español');
                                                }) as $comunidad)
                                                <div class="relative flex gap-x-3">
                                                    <div class="flex items-center h-6">
                                                        <x-text-input type="checkbox"
                                                            name="comunidad_linguistica"
                                                            wire:key='comunidad_linguistica_{{$comunidad->id}}'
                                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                                            wire:model.live="form.comunidadesLinguisticasSelected"
                                                            value="{{ $comunidad->id }}"
                                                            class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                            x-on:change="
                                                                if ([34, 35, 36].includes(parseInt($event.target.value))) {
                                                                    $wire.set('form.comunidadesLinguisticasSelected', [$event.target.value]);
                                                                } else {
                                                                    $wire.set('form.comunidadesLinguisticasSelected', $wire.form.comunidadesLinguisticasSelected.filter(value => ![34, 35, 36].includes(parseInt(value))).concat($event.target.value));
                                                                }
                                                            "
                                                            id="comunidad_linguistica_{{$comunidad->id}}" />
                                                    </div>
                                                    <div class="text-sm leading-6">
                                                        <label for="comunidad_linguistica_{{$comunidad->id}}"
                                                            class="font-medium text-gray-900">{{ $comunidad->nombre }}</label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <x-input-error
                                                :messages="$errors->get('form.comunidadesLinguisticasSelected')"
                                                class="mt-2" aria-live="assertive" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-span-full">
                            <x-input-label for="proyecto_vida">{{ __('¿Cuál es tu proyecto de vida principal? Marca la opción que mejor describa tu
                                objetivo:') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <div class="px-4">
                                    <div class="max-w-2xl space-y-10">
                                        <fieldset>
                                            <div class="mt-6 space-y-6">
                                                @foreach ($proyectoVidas as $proyecto)
                                                <div class="relative flex gap-x-3">
                                                    <div class="flex items-center h-6">
                                                      <x-text-input type="checkbox" name="proyecto_vida"
                                                          wire:key='proyecto-vida{{$proyecto->id}}'
                                                          wire:model.live="form.proyectoVidaSelected"
                                                          value="{{ $proyecto->id}}"
                                                          @class(['w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600'])
                                                          id="proyectoVidaSelected{{$proyecto->id}}"
                                                          :$disabled
                                                      />
                                                    </div>
                                                    <div class="text-sm leading-6">
                                                      <label for="proyectoVidaSelected{{$proyecto->id}}" class="font-medium text-gray-900">{{ $proyecto->nombre }}
                                                          <p class="text-gray-500">{{ $proyecto->comentario }}</p>
                                                      </label>
                                                    </div>
                                                  </div>
                                                @endforeach
                                            </div>
                                            <x-input-error :messages="$errors->get('form.proyectoVidaSelected')" class="mt-2" aria-live="assertive"/>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-span-full" x-data="proyectoVidaOtro" x-show="showDiv">
                            <x-input-label for="proyecto_vida_descripcion">{{ __('Especifique otro proyecto de vida:') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.proyecto_vida_descripcion" id="proyecto_vida_descripcion"
                                 name="proyecto_vida_descripcion" type="text" :$disabled
                                    @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled,
                                    'block w-full mt-1','border-2 border-red-500' => $errors->has('form.proyecto_vida_descripcion')])
                                />
                                <x-input-error :messages="$errors->get('form.proyecto_vida_descripcion')" class="mt-2" aria-live="assertive"/>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <x-input-label for="hijos">{{ __('¿Tienes hijos y/o hijas?') }} <x-required-label /></x-input-label>
                            <div class="grid grid-cols-2 gap-6 px-4 py-3">
                                <x-input-label class="flex items-center gap-4" for="sihijos">
                                    <x-forms.input-radio type="radio" wire:model.boolean="form.tiene_hijos" type="radio" name="tiene_hijos"
                                    id="sihijos" value="true" :$disabled/>
                                    Si
                                </x-input-label>
                                <x-input-label class="flex items-center gap-4" for="nohijos">
                                    <x-forms.input-radio type="radio" wire:model.boolean="form.tiene_hijos" type="radio" name="tiene_hijos"
                                    id="sihijos" value="false" :$disabled/>
                                    No
                                </x-input-label>
                            </div>
                            <x-input-error :messages="$errors->get('form.tiene_hijos')" class="mt-2" />
                        </div>

                        <div class="sm:col-span-3" x-show="$wire.form.tiene_hijos">
                            <x-input-label for="cantidad_hijos">{{ __('¿Cuántos hijos y/o hijas tienes?') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.cantidad_hijos" id="form.cantidad_hijos"
                                    name="form.cantidad_hijos" type="number" step="1" min="1" :$disabled
                                    @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled,
                                    'block w-full mt-1','border-2 border-red-500' => $errors->has('form.cantidad_hijos')])
                                />
                                <x-input-error :messages="$errors->get('form.cantidad_hijos')" class="mt-2" />
                            </div>
                        </div>


                        <div class="col-span-full" x-show="$wire.form.tiene_hijos">
                            <x-input-label for="responsabilidad_hijos">{{ __('¿Con quién o quienes compartes la paternidad/maternidad de tus hijos?') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <div class="px-4 py-3">
                                    <div class="max-w-2xl space-y-10">
                                        <fieldset>
                                            <div class="grid grid-cols-2 gap-6">
                                                @foreach ($responsabilidadHijos as $key => $value)
                                                <label class="flex items-center gap-4"
                                                    for="responsabilidad_hijos{{$key}}">
                                                    <x-text-input type="checkbox"
                                                        name="responsabilidad_hijos"
                                                        wire:key='responsabilidad{{$key}}'
                                                        :$disabled
                                                        wire:model.live="form.responsabilidadHijosSelected"
                                                        value="{{ $key}}"
                                                        class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                        id="responsabilidad_hijos{{$key}}" />
                                                    <span class="text-sm font-medium text-gray-900">{{
                                                        $value }}</span>
                                                </label>
                                                @endforeach
                                            </div>

                                            <x-input-error :messages="$errors->get('form.responsabilidadHijosSelected')" class="mt-2" />
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-full" x-show="$wire.form.tiene_hijos">
                            <x-input-label for="apoyoHijos">{{ __('¿Tienes apoyo para cuidar a tus hijos o hijas mientras participas en el
                                programa?') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <div class="px-4">
                                    <div class="max-w-2xl space-y-10">
                                        <div class="grid grid-cols-2 gap-6">
                                            @foreach ($apoyoHijos as $key => $value)
                                            <div class="relative flex gap-x-3">
                                                <div class="flex items-center h-6">
                                                    <x-text-input type="checkbox" name="apoyo_hijos"
                                                        wire:key='apoyohijos{{$key}}'
                                                        :$disabled
                                                        wire:model.live="form.apoyoHijosSelected"
                                                        value="{{ $key}}"
                                                        class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                        id="apoyoHijosSelected{{$key}}" />
                                                </div>
                                                <div class="text-sm leading-6">
                                                    <label for="apoyoHijosSelected{{$key}}"
                                                        class="font-medium text-gray-900">{{ $value
                                                        }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <x-input-error :messages="$errors->get('form.apoyoHijosSelected')"
                                            class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">SECCIÓN III</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">DATOS SOBRE EDUCACIÓN DE PARTICIPANTE</p>
            </div>

            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="max-w-2xl space-y-10">
                        <fieldset class="flex flex-col gap-2 sm:col-span-3">
                            <x-input-label for="apoyoHijos">{{ __('¿Estudia actualmente?') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="flex gap-6">
                                <x-input-label class="flex items-center gap-4" for="estudiasi">
                                    <x-forms.input-radio type="radio"
                                        wire:model.boolean="form.estudia_actualmente"
                                        disabled="{{ $disabled ? 'disabled' : '' }}" value="true"
                                        id="estudiasi" />
                                    Sí
                                </x-input-label>

                                <x-input-label class="flex items-center gap-4" for="estudiano">
                                    <x-forms.input-radio type="radio"
                                        wire:model.boolean="form.estudia_actualmente"
                                        disabled="{{ $disabled ? 'disabled' : '' }}" value="false"
                                        id="estudiano" />
                                    No
                                </x-input-label>
                            </div>
                            <x-input-error :messages="$errors->get('form.estudia_actualmente')"
                                class="mt-2" />
                        </fieldset>

                        <div x-show="$wire.form.estudia_actualmente == true">
                            <x-input-label class="my-4">{{ __('Seleccione el grado que se encuentra cursando actualmente') }}</x-input-label>

                            <div class="col-span-full">
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach ($nivelconcategorias as $categoria => $niveles)
                                    <div class="max-w-2xl space-y-10">
                                        <fieldset>
                                            <legend
                                                class="text-sm font-semibold leading-6 text-gray-900 uppercase">
                                                {{ $categoria }}</legend>
                                            <div class="mt-6 space-y-6">
                                                @foreach ($niveles as $key => $nivel)
                                                <div class="flex items-center gap-x-3">
                                                    <x-input-label class="flex items-center gap-4"
                                                        for="nivel{{ $key }}">
                                                        <x-forms.input-radio
                                                            wire:model="form.nivel_academico_id"
                                                            type="radio" id="nivel{{ $key }}"
                                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                                            value="{{ $key }}"
                                                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-600" />
                                                        {{ $nivel }}
                                                    </x-input-label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </fieldset>
                                    </div>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('form.nivel_academico_id')"
                                    class="mt-2" />
                            </div>

                            <div class="py-3 mt-4 sm:col-span-4">
                                <x-input-label for="seccion_grado_id">{{ __('Sección del grado actual:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <div class="px-4 py-3">
                                        <div class="max-w-2xl space-y-10">
                                            <fieldset>
                                                <div class="grid grid-cols-2 gap-6 md:grid-cols-3">
                                                    @foreach ($seccionGrado as $key => $value)
                                                    <x-input-label class="flex items-center gap-4"
                                                        for="grado{{ $key }}">
                                                        <x-forms.input-radio
                                                            wire:model="form.seccion_grado_id" type="radio"
                                                            id="grado{{ $key }}"
                                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                                            value="{{ $key }}"
                                                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-600" />
                                                        {{ $value }}
                                                    </x-input-label>
                                                    @endforeach
                                                </div>
                                                <x-input-error
                                                    :messages="$errors->get('form.seccion_grado_id')"
                                                    class="mt-2" aria-live="assertive" />
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <x-input-label for="turno_jornada_id">{{ __('Turno o jornada en la que
                                    estudia:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <div class="px-4 py-3">
                                        <div class="max-w-2xl space-y-10">
                                            <fieldset>
                                                <div class="grid grid-cols-2 gap-6 md:grid-cols-3">
                                                    @foreach ($turnoJornada as $key => $value)
                                                    <x-input-label class="flex items-center gap-4"
                                                        for="turno{{ $key }}">
                                                        <x-forms.input-radio
                                                            wire:model="form.turno_jornada_id" type="radio"
                                                            id="turno{{ $key }}"
                                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                                            value="{{ $key }}" name="turno_jornada_id"
                                                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-600" />
                                                        {{ $value }}
                                                    </x-input-label>
                                                    @endforeach
                                                </div>
                                                <x-input-error
                                                    :messages="$errors->get('form.turno_jornada_id')"
                                                    class="mt-2" aria-live="assertive" />
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="sm:col-span-4" x-show="$wire.form.estudia_actualmente == 0">
                            <x-input-label for="turno_jornada_id">{{ __('Último nivel educativo alcanzado:')
                                }}
                                <x-required-label />
                            </x-input-label>
                            <div class="mt-6 col-span-full">
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach ($nivelEducativo as $categoria => $niveles)
                                    <div class="max-w-2xl space-y-10">
                                        <fieldset>
                                            <legend
                                                class="mt-2 text-sm font-semibold leading-6 text-gray-900 uppercase">
                                                {{ $categoria }}</legend>
                                            <div class="mt-6 space-y-6">
                                                @foreach ($niveles as $key => $nivel)
                                                <div class="flex items-center gap-x-3">
                                                    <x-input-label class="flex items-center gap-4"
                                                        for="niveleducativo{{ $key }}">
                                                        <x-forms.input-radio
                                                            wire:model="form.nivel_educativo_id"
                                                            type="radio" id="niveleducativo{{ $key }}"
                                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                                            value="{{ $key }}"
                                                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-600" />
                                                        {{ $nivel }}
                                                    </x-input-label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </fieldset>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="grid max-w-2xl grid-cols-1 mt-8 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-3">
                                    <x-input-label for="fultimo_anio">{!! __(' ¿Cuál fue el último año en el que <br />estudió?') !!}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2" x-data>
                                        @php
                                            $currentYear = date('Y');
                                            $minYear = $currentYear - 20;
                                        @endphp

                                        <x-text-input
                                            wire:model="form.ultimo_anio_estudio"
                                            id="form.ultimo_anio_estudio"
                                            name="form.ultimo_anio_estudio"
                                            type="number"
                                            min="{{ $minYear }}"
                                            max="{{ $currentYear - 1 }}"
                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                            @class([
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled,
                                                'block w-full mt-1', 'border-2 border-red-500'=> $errors->has('form.ultimo_anio_estudio')
                                            ])
                                        />
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="municipio_nacimiento_id">{{ __('¿Se inscribirá para continuar con sus estudios en un lapso no mayor a 3 meses?') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="px-4 py-3">
                                        <div class="flex gap-6">
                                            <x-input-label class="flex items-center gap-2">
                                                <x-forms.input-radio type="radio"
                                                    :$disabled
                                                    wire:model.live="form.continuidad_tres_meses" id="form.continuidad_tres_meses"
                                                    wire:key="continuidad_tres_meses" name="form.continuidad_tres_meses" type="radio"
                                                    value="1" />
                                                Si
                                            </x-input-label>
                                            <x-input-label class="flex items-center gap-2">
                                                <x-forms.input-radio type="radio"
                                                    :$disabled
                                                    wire:model.live="form.continuidad_tres_meses" id="form.continuidad_tres_meses"
                                                    wire:key="continuidad_tres_meses2" name="form.continuidad_tres_meses" type="radio"
                                                    value="0" />
                                                No
                                            </x-input-label>
                                        </div>
                                        <x-input-error :messages="$errors->get('form.continuidad_tres_meses')" class="mt-2"
                                            aria-live="assertive" />
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">SECCIÓN IV</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">ADICIONAL</p>
            </div>

            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="max-w-2xl space-y-10">
                        <fieldset class="flex flex-col gap-2 sm:col-span-3">

                            <x-input-label for="participado_glasswing">{{ __('¿Ha participado en años
                                    anteriores en actividades de Glasswing?') }} <x-required-label /></x-input-label>


                            <div class="flex gap-6">

                                <x-input-label class="flex items-center gap-4" for="participado_glasswing_si">
                                    <x-forms.input-radio wire:model.boolean="form.participo_actividades_glasswing"
                                    type="radio" name="participo_actividades_glasswing" value="true"
                                    wire:key="siparticipo"
                                    id="participado_glasswing_si"
                                    class="w-4 h-4 text-indigo-600 focus:ring-indigo-600" :$disabled/>
                                        Si
                                </x-input-label>

                                <x-input-label class="flex items-center gap-4" for="participado_glasswing_no">
                                    <x-forms.input-radio wire:model.boolean="form.participo_actividades_glasswing"
                                        type="radio" name="participo_actividades_glasswing" value="false"
                                        wire:key="noparticipo"
                                        id="participado_glasswing_no"
                                        class="w-4 h-4 text-indigo-600 focus:ring-indigo-600" :$disabled/>
                                        No
                                </x-input-label>
                            </div>
                            <x-input-error :messages="$errors->get('form.participo_actividades_glasswing')" class="mt-2" aria-live="assertive"/>
                        </fieldset>

                        <div x-show="$wire.form.participo_actividades_glasswing == true">
                            <div class="col-span-full">
                                <x-input-label for="rol_participado">{{ __('¿Con qué rol ha
                                        participado?') }} <x-required-label /></x-input-label>

                                <div class="flex gap-6 pt-3">

                                    <x-input-label class="flex items-center gap-4" for="participado_glasswing_voluntario">
                                        <x-forms.input-radio wire:model.boolean="form.rol_participo" type="radio"
                                        name="rol_participo" value="1" wire:key='participovoluntario' id="participado_glasswing_voluntario"
                                        class="w-4 h-4 text-indigo-600 focus:ring-indigo-600" :$disabled />
                                        Voluntario/voluntaria
                                    </x-input-label>

                                    <x-input-label class="flex items-center gap-4" for="participado_glasswing_participante">
                                        <x-forms.input-radio wire:model.boolean="form.rol_participo" type="radio"
                                        name="rol_participo" value="2" wire:key='participantoparticipante' id="participado_glasswing_participante"
                                        class="w-4 h-4 text-indigo-600 focus:ring-indigo-600" :$disabled />
                                        Participante
                                    </x-input-label>

                                </div>
                                <x-input-error :messages="$errors->get('form.rol_participo')" class="mt-2" aria-live="assertive"/>
                            </div>


                            <div class="py-3 col-span-full">

                                <x-input-label for="descripcion_participo">{{ __('¿En qué participó?') }} <x-required-label /></x-input-label>

                                <div class="mt-2">

                                        <x-text-input wire:model="form.descripcion_participo" id="form.descripcion_participo"
                                         name="form.descripcion_participo" type="text" :$disabled
                                            @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled,
                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.descripcion_participo')])
                                        />
                                        <x-input-error :messages="$errors->get('form.descripcion_participo')" class="mt-2" />
                                </div>
                            </div>

                        </div>

                        <fieldset class="flex flex-col gap-2 sm:col-span-3">

                            <x-input-label for="participado_glasswing">{{ __('¿Algún miembro de su familia participa o ha participado en la Iniciativa Jóvenes con Propósito?') }}
                                <x-required-label />
                            </x-input-label>

                            <div class="flex gap-6">

                                <x-input-label class="flex items-center gap-4"
                                    for="pariente_participo_jovenes_proposito_si">
                                    <x-forms.input-radio
                                        wire:model.boolean="form.pariente_participo_jovenes_proposito"
                                        disabled="{{ $disabled ? 'disabled' : '' }}" type="radio"
                                        name="pariente_participo_jovenes_proposito" value="1"
                                        wire:key="siparticipo" id="pariente_participo_jovenes_proposito_si"
                                        class="w-4 h-4 text-indigo-600 focus:ring-indigo-600" />
                                    Sí
                                </x-input-label>

                                <x-input-label class="flex items-center gap-4"
                                    for="pariente_participo_jovenes_proposito_no">
                                    <x-forms.input-radio
                                        wire:model.boolean="form.pariente_participo_jovenes_proposito"
                                        disabled="{{  $disabled ? 'disabled' : '' }}" type="radio"
                                        name="pariente_participo_jovenes_proposito" value="0"
                                        wire:key="noparticipo" id="pariente_participo_jovenes_proposito_no"
                                        class="w-4 h-4 text-indigo-600 focus:ring-indigo-600" />
                                    No
                                </x-input-label>
                            </div>

                            <x-input-error :messages="$errors->get('form.pariente_participo_jovenes_proposito')"
                                class="mt-2" aria-live="assertive" />
                        </fieldset>

                        <div x-show="$wire.form.pariente_participo_jovenes_proposito == true">
                            <div class="sm:col-span-3">
                                <x-input-label for="fparentesco_joven_participante">{{ __('Parentesco con joven participante') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="parentesco_pariente_parcicipo_jovenes_proposito"
                                        wire:model.live='form.parentesco_pariente_parcicipo_jovenes_proposito'
                                        id="fparentesco_joven_participante" :options="$form->parentescos_parientes_participo"
                                        selected="Seleccione una opción"
                                        disabled="{{  $disabled ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $disabled,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.parentesco_pariente_parcicipo_jovenes_proposito')])
                                        />
                                        <x-input-error
                                            :messages="$errors->get('form.parentesco_pariente_parcicipo_jovenes_proposito')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>
                        </div>

                        <div class="col-span-full" x-show="$wire.form.parentesco_pariente_parcicipo_jovenes_proposito == 4 " >
                            <x-input-label for="pariente_participo_otros">{{ __('Otros') }}
                                <x-required-label />
                            </x-input-label>

                            <div class="mt-2">

                                <x-text-input wire:model="form.pariente_participo_otros"
                                    id="form.pariente_participo_otros" name="form.pariente_participo_otros"
                                    type="text" disabled="{{  $disabled ? 'disabled' : '' }}"
                                    @class(['block w-full mt-1','border-2 border-red-500'=>
                                    $errors->has('form.pariente_participo_otros')])
                                />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">SECCIÓN V</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">BANCARIZACIÓN</p>
            </div>

            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="max-w-2xl space-y-10">

                        <div class="col-span-full">
                            <x-input-label for="documento_identidad">{{ __('Número de documento
                                de identidad de participante') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.documento_identidad" id="documento_identidad"
                                         name="form.documento_identidad" type="text" :$disabled
                                            @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled,
                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.documento_identidad')])
                                        />
                            </div>
                            <x-input-error :messages="$errors->get('form.documento_identidad')" class="mt-2" />
                        </div>
                        <div class="col-span-full">
                            <x-input-label for="email">{{ __('Correo
                                electrónico de participante') }} <span class="text-indigo-500">(Opcional)</span></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.email" id="email"
                                         name="form.email" type="email" :$disabled
                                            @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled,
                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.email')])
                                        />
                            </div>
                            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                        </div>
                        <div class="col-span-full">
                            <x-input-label for="telefono">{{ __('Número de teléfono de participante') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <x-text-input wire:model="form.telefono" id="telefono"
                                         name="telefono" type="text" :$disabled
                                            @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled,
                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.telefono')])
                                        />
                            </div>
                            <x-input-error :messages="$errors->get('form.telefono')" class="mt-2" />
                        </div>


                        @if( $form->nacionalidad  == 2)

                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <x-input-label for="pais_nacimiento_extranjero">{{ __('Pais de nacimiento')
                                    }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.pais_nacimiento_extranjero"
                                        id="pais_nacimiento_extranjero" name="pais_nacimiento_extranjero"
                                        type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.pais_nacimiento_extranjero')])
                                        />
                                </div>
                                <x-input-error :messages="$errors->get('form.pais_nacimiento_extranjero')"
                                    class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="departamento_nacimiento_extranjero">{{ __('Departamento
                                    de nacimiento') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.departamento_nacimiento_extranjero"
                                        id="departamento_nacimiento_extranjero"
                                        name="departamento_nacimiento_extranjero" type="text"
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.departamento_nacimiento_extranjero')])
                                        />
                                </div>
                                <x-input-error
                                    :messages="$errors->get('form.departamento_nacimiento_extranjero')"
                                    class="mt-2" />
                            </div>

                            <div class="sm:col-span-2">
                                <x-input-label for="municipio_nacimiento_extranjero">{{ __('Municipio de
                                    nacimiento') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.municipio_nacimiento_extranjero"
                                        id="municipio_nacimiento_extranjero"
                                        name="municipio_nacimiento_extranjero" type="text"
                                        disabled="{{ $disabled ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $disabled,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.municipio_nacimiento_extranjero')])
                                        />
                                </div>
                                <x-input-error
                                    :messages="$errors->get('form.municipio_nacimiento_extranjero')"
                                    class="mt-2" />
                            </div>
                        </div>

                        @else

                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <x-input-label for="fdepartamento_nacimiento_id">{{ __('Departamento de
                                    nacimiento') }} <x-required-label /></x-input-label>
                                <div class="mt-2">

                                    <x-forms.single-select name="departamentoNacimientoSelected"
                                    wire:model.live='departamentoNacimientoSelected'
                                    id="fdepartamento_nacimiento_id" :options="$departamentos"
                                    selected="Seleccione un departamento"
                                    disabled="disabled"
                                    @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                    'block w-full mt-1','border-2 border-red-500' =>
                                    $errors->has('departamentoNacimientoSelected')])
                                    />


                                    {{-- <x-text-input wire:model.live="form.departamento_nacimiento_id" id="fdepartamento_nacimiento_id"
                                         name="departamento_nacimiento_id" type="text" :$disabled
                                            @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled,
                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.departamento_nacimiento_id')])
                                        /> --}}
                                </div>
                                <x-input-error :messages="$errors->get('form.departamento_nacimiento_id')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="municipio_nacimiento_id">{{ __('Municipio de
                                    nacimiento') }} <x-required-label /></x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="municipio_nacimiento_id"
                                    wire:model.live='form.municipio_nacimiento_id' id="ciudad"
                                    disabled="disabled"
                                    :options="$ciudadesNacimiento"
                                    @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                    $form->readonly,
                                    'block w-full mt-1','border-2 border-red-500' =>
                                    $errors->has('form.municipio_nacimiento_id')])
                                    selected="Seleccione un municipio"/>
                                </div>
                                <x-input-error :messages="$errors->get('form.municipio_nacimiento_id')" class="mt-2" />
                            </div>
                        </div>

                        @endif



                        <div class="col-span-full">
                            <x-input-label for="nombre_beneficiario">{{ __('Nombre completo de persona que
                                asignan como beneficiaria de cuenta bancaria
                                en caso de fallecimiento (Persona mayor de edad)') }}
                                <x-required-label />
                            </x-input-label>
                            <div class="grid max-w-2xl grid-cols-1 mt-4 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-2">
                                    <x-input-label for="form.primer_nombre_beneficiario">{{ __('Primer nombre') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model.blur="form.primer_nombre_beneficiario" id="form.primer_nombre_beneficiario"
                                            name="form.primer_nombre_beneficiario" type="text"
                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $disabled,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.primer_nombre_beneficiario')
                                            ])
                                            />
                                            <x-input-error :messages="$errors->get('form.primer_nombre_beneficiario')"
                                                class="mt-2" />
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <x-input-label for="form.segundo_nombre_beneficiario">{{ __('Segundo nombre') }}
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model.blur="form.segundo_nombre_beneficiario" id="form.segundo_nombre_beneficiario"
                                            name="form.segundo_nombre_beneficiario" type="text"
                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>$disabled,
                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.segundo_nombre_beneficiario')
                                            ])
                                            />
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <x-input-label for="form.tercer_nombre_beneficiario">{{ __('Tercer nombre') }}
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model.blur="form.tercer_nombre_beneficiario" id="form.tercer_nombre_beneficiario"
                                            name="form.tercer_nombre_beneficiario" type="text"
                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.tercer_nombre_beneficiario')
                                            ])
                                        />
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <x-input-label for="form.primer_apellido_beneficiario">{{ __('Primer apellido') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model.blur="form.primer_apellido_beneficiario"
                                            id="form.primer_apellido_beneficiario" name="form.primer_apellido_beneficiario" type="text"
                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.primer_apellido_beneficiario')
                                            ])
                                        />
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <x-input-label for="form.segundo_apellido_beneficiario">{{ __('Segundo apellido') }}
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model.blur="form.segundo_apellido_beneficiario"
                                            id="form.segundo_apellido_beneficiario" name="form.segundo_apellido_beneficiario" type="text"
                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                            @class([
                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                                'block w-full mt-1','border-2 border-red-500' =>$errors->has('form.segundo_apellido_beneficiario')
                                            ])
                                        />
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <x-input-label for="form.tercer_apellido_beneficiario">{{ __('Tercer apellido') }}
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model.blur="form.tercer_apellido_beneficiario"
                                            id="form.tercer_apellido_beneficiario" name="form.tercer_apellido_beneficiario" type="text"
                                            disabled="{{ $disabled ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                                'block w-full mt-1','border-2 border-red-500' => $errors->has('form.tercer_apellido_beneficiario')
                                            ])
                                        />

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="parentesco_id">{{ __('Parentesco con participante') }} <x-required-label /></x-input-label>
                            <div class="mt-2">
                                <div class="px-4 py-3">
                                    <div class="max-w-2xl space-y-10">
                                        <fieldset>
                                            <div class="grid grid-cols-2 gap-6">
                                                @foreach ($parentescos as $key => $parentesco)
                                                <x-input-label class="flex items-center gap-4"
                                                    for="parentesco-relacion-{{ $key }}">
                                                    <x-forms.input-radio
                                                        wire:model.live="form.parentesco_id" type="radio"
                                                        name="parentesco_id" value="{{ $key }}"
                                                        wire:key="parentesco{{ $key }}"
                                                        id="parentesco-relacion-{{ $key }}"
                                                        class="w-4 h-4 text-indigo-600 focus:ring-indigo-600" :$disabled />
                                                    {{ $parentesco }}
                                                </x-input-label>
                                                @endforeach
                                            </div>
                                            <x-input-error :messages="$errors->get('form.parentesco_id')"
                                                class="mt-2" aria-live="assertive" />
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
            <div class="px-4 sm:px-0">
                <h2 class="text-base font-semibold leading-7 text-gray-900">SECCIÓN VI</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">ESTATUS DE DOCUMENTACIÓN </p>
            </div>

            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                <div class="px-4 py-6 sm:p-8">
                    <div class="max-w-2xl space-y-10">

                        <fieldset class="flex flex-col gap-2 sm:col-span-3">
                            <div>
                                <legend class="text-base font-medium text-slate-700">Marcar los documentos con
                                    que se cuenta para cargar en formulario de inscripción de la persona
                                    participante
                                </legend>
                            </div>

                            <div class="col-span-full">

                                <label class="flex items-center gap-2 mt-4">

                                    <x-text-input type="checkbox" name="form.uploaddui"
                                        wire:model.live='form.uploaddui'
                                        @class(['w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600'])
                                        id="form.uploaddui" :$disabled
                                    />

                                    <span class="text-sm font-medium text-gray-900">Copia de documento de
                                        identidad seleccionado de participante</span>
                                </label>

                                <div class="mt-2" x-data="{ uploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="uploading = true"
                                    x-on:livewire-upload-finish="uploading = false"
                                    x-on:livewire-upload-cancel="uploading = false"
                                    x-on:livewire-upload-error="uploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                    x-show="$wire.form.uploaddui == true">

                                    <!-- File Input -->
                                    <x-input-label for="file_documento_identidad_upload" class="block py-3 mt-2 mb-2">{{ __('Subir documento') }} <x-required-label /></x-input-label>

                                    <h3 class="text-sm font-bold text-slate-700">Frente</h3>

                                    @if($participante->copia_documento_identidad)
                                        <div class="py-4">
                                            <a href="{{ Storage::disk('s3')->temporaryUrl($participante->copia_documento_identidad, \Carbon\Carbon::now()->addHour()) }}"
                                                class="text-blue-600 underline md:text-green-600"
                                                target="_blank"
                                                >Ver documento actual</a>
                                        </div>
                                    @endif

                                    <input type="file" wire:model="form.file_documento_identidad_upload" :disabled="$wire.disabled"
                                        @class([
                                            'w-full text-sm font-semibold text-gray-400 bg-white border rounded cursor-pointer file:cursor-pointer file:border-0 file:py-3 file:px-4 file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled])>
                                    <p class="mt-2 text-xs text-gray-400">PNG, JPG SVG, WEBP, and GIF are
                                        Allowed.</p>

                                    <!-- Progress Bar -->
                                    <div x-show="uploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>

                                    <x-input-error :messages="$errors->get('form.file_documento_identidad_upload')" class="mt-2" aria-live="assertive"/>


                                    <h3 class="pt-10 text-sm font-bold text-slate-700">Reverso</h3>

                                    @if($participante->copia_documento_identidad_reverso)
                                    <div class="py-4">
                                        <a href="{{ Storage::disk('s3')->temporaryUrl($participante->copia_documento_identidad_reverso, \Carbon\Carbon::now()->addHour()) }}"
                                            class="text-blue-600 underline md:text-green-600"
                                            target="_blank">Ver documento actual</a>
                                    </div>
                                    @endif

                                    <input type="file" disabled="$wire.disabled" wire:model="form.file_documento_identidad_upload_reverso" {{
                                        $form->readonly ? 'disabled' : '' }}
                                        @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200
                                        disabled:shadow-none' => $form->readonly,
                                        "w-full text-sm font-semibold text-gray-400 bg-white border rounded
                                        cursor-pointer file:cursor-pointer file:border-0 file:py-3 file:px-4
                                        file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500"
                                        ])
                                        >
                                    <p class="mt-2 text-xs text-gray-400">Tipos de archivos permitidos: PNG,
                                        JPG, GIF, DOCX y PDF.</p>

                                </div>

                                <div class="mt-4">
                                    <x-input-label for="comentario_documento_identidad_upload">{{ __('Comentario/observación') }} <x-required-label /></x-input-label>
                                    <textarea name="comentario_documento_identidad_upload"
                                        id="comentario_documento_identidad_upload"
                                        wire:model="form.comentario_documento_identidad_upload" rows="3"
                                        @class([ 'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                        , 'border-0 border-slate-300'=> $errors->missing('form.comentario_documento_identidad_upload'),
                                            'border-2 border-red-500' => $errors->has('form.comentario_documento_identidad_upload'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled,
                                        ])
                                        @error('form.comentario_documento_identidad_upload')
                                            aria-invalid="true"
                                            aria-description="{{ $message }}"
                                        @enderror
                                        :disabled="$wire.disabled"
                                        ></textarea>

                                    <x-input-error :messages="$errors->get('form.comentario_documento_identidad_upload')" class="mt-2" aria-live="assertive"/>
                                </div>
                            </div>


                            <div class="col-span-full">

                                <label class="flex items-center gap-2 mt-4">

                                    <x-text-input type="checkbox" name="form.uploadcertificado"
                                        wire:model.live='form.uploadcertificado'
                                        class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                        id="form.uploadcertificado" :$disabled
                                    />

                                    <span class="text-sm font-medium text-gray-900">Copia de certificado o
                                        constancia de estudios</span>

                                </label>

                                <div class="mt-2"
                                x-data="{ uploading: false, progress: 0 }"
                                x-on:livewire-upload-start="uploading = true"
                                x-on:livewire-upload-finish="uploading = false"
                                x-on:livewire-upload-cancel="uploading = false"
                                x-on:livewire-upload-error="uploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                                x-show="$wire.form.uploadcertificado == true">

                                    <x-input-label for="file_copia_certificado_estudio_upload" class="block py-3 mt-2 mb-2">{{ __('Subir documento') }} <x-required-label /></x-input-label>

                                    @if($participante->copia_constancia_estudios)
                                        <div class="py-4">
                                            <a href="{{ Storage::disk('s3')->temporaryUrl($participante->copia_constancia_estudios, \Carbon\Carbon::now()->addHour()) }}"
                                                class="text-blue-600 underline md:text-green-600"
                                                target="_blank"
                                                >Ver documento actual</a>
                                        </div>
                                    @endif

                                    <input type="file" wire:model="form.file_copia_certificado_estudio_upload" :disabled="$wire.disabled"
                                        @class([
                                            'w-full text-sm font-semibold text-gray-400 bg-white border rounded cursor-pointer file:cursor-pointer file:border-0 file:py-3 file:px-4 file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled]) />
                                    <p class="mt-2 text-xs text-gray-400">PNG, JPG SVG, WEBP, and GIF are
                                        Allowed.</p>

                                        <!-- Progress Bar -->
                                    <div x-show="uploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>
                                    <x-input-error :messages="$errors->get('form.file_copia_certificado_estudio_upload')" class="mt-2" aria-live="assertive"/>

                                </div>

                                <div class="mt-4">

                                    <x-input-label for="comentario_copia_certificado_estudio_upload" class="block mt-2 mb-2">{{ __('Comentario/observación') }} <x-required-label /></x-input-label>

                                    <textarea name="comentario_copia_certificado_estudio_upload"
                                        id="comentario_copia_certificado_estudio_upload"
                                        wire:model="form.comentario_copia_certificado_estudio_upload" rows="3"
                                        @class([ 'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                                        , 'border-0 border-slate-300'=> $errors->missing('form.comentario_copia_certificado_estudio_upload'),
                                            'border-2 border-red-500' => $errors->has('form.comentario_copia_certificado_estudio_upload'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled
                                        ])
                                        @error('form.comentario_copia_certificado_estudio_upload')
                                            aria-invalid="true"
                                            aria-description="{{ $message }}"
                                        @enderror
                                        :disabled="$wire.disabled"
                                        ></textarea>

                                    <x-input-error :messages="$errors->get('form.comentario_copia_certificado_estudio_upload')" class="mt-2" aria-live="assertive"/>
                                </div>
                            </div>

                            <div class="col-span-full">

                                <label class="flex items-center gap-2 mt-4">

                                    <x-text-input type="checkbox" name="form.uploadconsentimiento"
                                        wire:model.live='form.uploadconsentimiento'
                                        class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                        id="form.uploadconsentimiento" :$disabled
                                    />

                                    <span class="text-sm font-medium text-gray-900">Formulario de
                                        consentimientos y/o asentimientos para inscripción al programa</span>
                                </label>

                                <div class="mt-2"
                                x-data="{ uploading: false, progress: 0 }"
                                x-on:livewire-upload-start="uploading = true"
                                x-on:livewire-upload-finish="uploading = false"
                                x-on:livewire-upload-cancel="uploading = false"
                                x-on:livewire-upload-error="uploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                                x-show="$wire.form.uploadconsentimiento == true">

                                    <x-input-label for="file_formulario_consentimiento_programa_upload"
                                        class="block py-3 mt-2 mb-2 ">{{ __('Permisos') }}
                                        <x-required-label />
                                    </x-input-label>

                                    @php
                                        $checkboxLabels = [
                                            'Participación voluntaria' => 'form.participacion_voluntaria',
                                            'Recolección y uso por Glasswing' => 'form.recoleccion_uso_glasswing',
                                            'Compartir y uso para investigaciones' => 'form.compartir_para_investigaciones',
                                            'Compartir y uso para bancarización' => 'form.compartir_para_bancarizacion',
                                            'Compartir y uso por Gobierno' => 'form.compartir_por_gobierno',
                                            'Voz e imagen' => 'form.voz_e_imagen',
                                        ];

                                    @endphp

                                    <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2">
                                        @foreach ($checkboxLabels as $label => $property)
                                        <div class="flex items-center">
                                            <input type="checkbox"
                                            disabled
                                            wire:model="{{ $property }}"
                                            class="w-5 h-5 text-green-600 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                                            <span class="ml-2 text-gray-700">{{ $label }}</span>
                                        </div>
                                        @endforeach
                                    </div>

                                    <x-input-label for="file_formulario_consentimiento_programa_upload" class="block py-3 mt-2 mb-2">{{ __('Subir documento') }} <x-required-label /></x-input-label>

                                    @if($participante->consentimientos_inscripcion_programa)
                                        <div class="py-4">
                                            <a href="{{ Storage::disk('s3')->temporaryUrl($participante->consentimientos_inscripcion_programa, \Carbon\Carbon::now()->addHour()) }}"
                                                class="text-blue-600 underline md:text-green-600"
                                                target="_blank"
                                                >Ver documento actual</a>
                                        </div>
                                    @endif

                                    <!-- File Input -->
                                    <input type="file"
                                        :disabled="$wire.disabled"
                                        wire:model="form.file_formulario_consentimiento_programa_upload"
                                        @class([
                                            'w-full text-sm font-semibold text-gray-400 bg-white border rounded cursor-pointer file:cursor-pointer file:border-0 file:py-3 file:px-4 file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $disabled ]) />
                                    <p class="mt-2 text-xs text-gray-400">PNG, JPG SVG, WEBP, and GIF are
                                        Allowed.</p>

                                     <!-- Progress Bar -->
                                    <div x-show="uploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>

                                    <x-input-error :messages="$errors->get('form.file_formulario_consentimiento_programa_upload')" class="mt-2" aria-live="assertive"/>
                                </div>

                                <div class="mt-4">
                                    <x-input-label for="comentario_formulario_consentimiento_programa_upload">{{ __('Comentario/observación') }} <x-required-label /></x-input-label>

                                    <textarea name="comentario_formulario_consentimiento_programa_upload"
                                        id="comentario_formulario_consentimiento_programa_upload"
                                        wire:model="form.comentario_formulario_consentimiento_programa_upload"
                                        rows="3"
                                        @class([ 'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.comentario_formulario_consentimiento_programa_upload'),
                                            'border-2 border-red-500' => $errors->has('form.comentario_formulario_consentimiento_programa_upload'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                        ])
                                        @error('form.comentario_formulario_consentimiento_programa_upload')
                                            aria-invalid="true"
                                            aria-description="{{ $message }}"
                                        @enderror
                                        :disabled="$wire.disabled"
                                        ></textarea>

                                    <x-input-error :messages="$errors->get('form.comentario_formulario_consentimiento_programa_upload')" class="mt-2" aria-live="assertive"/>
                                </div>
                            </div>
                            <div class="col-span-full" x-show="$wire.form.continuidad_tres_meses == true">

                                <label class="flex items-center gap-2 mt-4">

                                    <x-text-input type="checkbox" name="form.uploadcompromisoestudio"
                                        wire:model='form.uploadcompromisoestudio' :$disabled
                                        class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                        id="form.uploadcompromisoestudio"
                                        />

                                        <span class="text-sm font-medium text-gray-900">Imagen del compromiso para continuar los estudios</span>
                                </label>

                                <div class="mt-2" x-data="{ uploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="uploading = true"
                                    x-on:livewire-upload-finish="uploading = false"
                                    x-on:livewire-upload-cancel="uploading = false"
                                    x-on:livewire-upload-error="uploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                    x-show="$wire.form.uploadcompromisoestudio == true">


                                    <x-input-label for="file_formulario_consentimiento_programa_upload"
                                        class="block py-3 mt-2 mb-2">{{ __('Subir documento') }}
                                        <x-required-label />
                                    </x-input-label>

                                    @if($participante->copia_compromiso_continuar_estudio)
                                    <div class="py-4">
                                        <a href="{{ Storage::disk('s3')->temporaryUrl($participante->copia_compromiso_continuar_estudio, \Carbon\Carbon::now()->addHour()) }}"
                                            class="text-blue-600 underline md:text-green-600"
                                            target="_blank">Ver documento actual</a>
                                    </div>
                                    @endif


                                    <!-- File Input -->
                                    <input type="file" :disabled="$wire.disabled"
                                        wire:model="form.file_compromiso_continuar_estudio_upload"
                                        {{ $form->readonly ? 'disabled' : '' }}
                                    @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200
                                        disabled:shadow-none' => $form->readonly,
                                        "w-full text-sm font-semibold text-gray-400 bg-white border rounded
                                        cursor-pointer file:cursor-pointer file:border-0 file:py-3 file:px-4
                                        file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500"
                                    ])
                                    />
                                    <p class="mt-2 text-xs text-gray-400">Tipos de archivos permitidos: PNG,
                                        JPG, GIF, DOCX y PDF.</p>

                                    <!-- Progress Bar -->
                                    <div x-show="uploading">
                                        <progress max="100" x-bind:value="progress"></progress>
                                    </div>

                                    <x-input-error
                                        :messages="$errors->get('form.file_compromiso_continuar_estudio_upload')"
                                        class="mt-2" aria-live="assertive" />
                                </div>

                                <div class="mt-4">
                                    <x-input-label
                                        for="comentario_file_compromiso_continuar_estudio_upload">{{
                                        __('Comentario/observación') }}
                                        <x-required-label />
                                    </x-input-label>

                                    <textarea name="comentario_file_compromiso_continuar_estudio_upload"
                                    id="comentario_file_compromiso_continuar_estudio_upload"
                                    wire:model="form.comentario_file_compromiso_continuar_estudio_upload"
                                    rows="3"
                                    @class([ 'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                        'border-0 border-slate-300'=> $errors->missing('form.comentario_file_compromiso_continuar_estudio_upload'),
                                        'border-2 border-red-500' => $errors->has('form.comentario_file_compromiso_continuar_estudio_upload'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $disabled,
                                    ])
                                    @error('form.comentario_file_compromiso_continuar_estudio_upload')
                                        aria-invalid="true"
                                        aria-description="{{ $message }}"
                                    @enderror
                                    :disabled="$wire.disabled"
                                    ></textarea>


                                    <x-input-error
                                        :messages="$errors->get('form.comentario_file_compromiso_continuar_estudio_upload')"
                                        class="mt-2" aria-live="assertive" />
                                </div>

                            </div>
                        </fieldset>

                    </div>
                </div>
            </div>

        </div>

    </div>
</form>

@script
<script>
    Alpine.data('proyectoVidaOtro', () => ({

    showDiv: false,

    init() {

        this.showDiv = Array.from(this.$wire.form.proyectoVidaSelected).includes($wire.form.otroProyectoVidaEspecificar);

        this.$watch('$wire.form.proyectoVidaSelected', () => {
            this.checkOtherProyectoVidaSelected()
        })

    },
    checkOtherProyectoVidaSelected() {
        const arrayExtracted = Array.from(this.$wire.form.proyectoVidaSelected);
        this.showDiv = arrayExtracted.includes($wire.form.otroProyectoVidaEspecificar.toString());
    },

    }));
</script>
@endscript
