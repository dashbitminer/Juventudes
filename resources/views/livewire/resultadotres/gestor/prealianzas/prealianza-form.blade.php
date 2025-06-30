<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 3: {{ __('Pre-alianzas') }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }}</small>
</x-slot>
<div>
    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($form->showValidationErrorIndicator)
    <div class="mt-4">
        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
        <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
            @foreach ($form->validationErrors as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

    <form wire:submit="save" enctype="multipart/form-data">
        <div class="space-y-10 divide-y divide-gray-900/10">
            <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 0</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Origen de la Alianza</p>
                </div>

                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <label for="website"
                                    class="block text-sm font-medium leading-6 text-gray-900">Origen de la gestión
                                    de la Alianza:
                                    {{ $socioImplementador->nombre }}
                                    {{-- @if($formMode == 'create')
                                      {{ optional(auth()->user()->lastestSocioImplementador->socioImplementador)->nombre }}
                                    @else
                                        {{ $prealianza->socioImplementador->nombre ?? "" }}
                                    @endif --}}
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 1</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Datos de la organización
                    </p>
                </div>

                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <x-input-label for="nombre_organizacion">{{ __('Nombre de la
                                    organización:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.nombre_organizacion" id="form.nombre_organizacion"
                                    name="form.nombre_organizacion" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.nombre_organizacion')
                                       ])
                                   />
                                   <x-input-error :messages="$errors->get('form.nombre_organizacion')" class="mt-2" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="coberturaSelected">{{ __('Área de cobertura de la
                                    organización:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <div wire:ignore x-cloak
                                        x-data
                                        x-init="
                                            $nextTick(() => {
                                                const choices = new Choices($refs.newselect, {
                                                    removeItems: true,
                                                    removeItemButton: true,
                                                    placeholderValue: 'Seleccione una o más areas de cobertura',
                                                })
                                        })"
                                    >
                                        <select
                                            x-ref="newselect"
                                            wire:change="$set('form.coberturaSelected', [...$event.target.options].filter(option => option.selected).map(option => option.value))"
                                            multiple
                                            {{ $form->readonly ? 'disabled' : '' }} id="coberturaSelected"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.coberturaSelected')])
                                        >
                                            @foreach($form->departamentos as $key => $value)
                                                <option value="{{ $key }}" @selected(in_array($key, $form->coberturaSelected))>{{ $value }}</option>
                                            @endforeach
                                        </select>


                                            <!-- Conditionally display this section if there are invalid values -->
                                            <div class="mt-4" x-show="$wire.form.showCoberturaWarning">
                                                <div class="p-4 rounded-md bg-yellow-50">
                                                    <div class="flex">
                                                        <div class="flex-shrink-0">
                                                            <svg class="w-5 h-5 text-yellow-400"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4a1 1 0 002 0V7zm-1 8a1 1 0 100-2 1 1 0 000 2z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                        <div class="ml-3">
                                                            <h3 class="text-sm font-medium text-yellow-800">Hay departamentos diferentes a los 4 configurados por defecto: Alta Verapaz, Huehuetenango, Ciudad de Guatemala y Quetzaltenango.
                                                            </h3>
                                                        </div>
                                                        <div class="pl-3 ml-auto">
                                                            <div class="-mx-1.5 -my-1.5">
                                                                <button type="button"
                                                                    class="inline-flex rounded-md bg-yellow-50 p-1.5 text-yellow-500 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-yellow-50 focus:ring-yellow-600"
                                                                    @click="$wire.form.showCoberturaWarning = false">
                                                                    <span class="sr-only">Dismiss</span>
                                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 20 20" fill="currentColor"
                                                                        aria-hidden="true">
                                                                        <path fill-rule="evenodd"
                                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                    </div>
                                    <x-input-error :messages="$errors->get('form.coberturaSelected')" class="mt-2" aria-live="assertive" />

                                </div>
                            </div>


                            <div class="sm:col-span-3"
                                x-data=""
                                {{-- x-data="{ selectedPerfil: $wire.entangle('form.tipoSectorSelected'), selectedPerfilPivot: $wire.entangle('form.tipoSectorSelectedPivot') }" --}}
                                >
                                <x-input-label for="tipoSectorSelected">{{ __('Tipo de sector:') }}
                                        <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                        <select name="tipoSectorSelected" id="perfilSelected" wire:model.live="form.tipoSectorSelected"
                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                            const sectorOption = selectedOption.getAttribute('data-sector-options');
                                            $wire.set('form.tipoSectorSelectedPivot', sectorOption);"
                                            @class([
                                                'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                                'border-2 border-red-500' => $errors->has('form.tipoSectorSelected')
                                            ])
                                        >

                                            <option value="">{{ __('Seleccione un perfil') }}</option>
                                            @foreach($tiposector as $sector)
                                                <option value="{{ $sector->id }}" data-sector-options="{{ $sector->pivotid }}" wire:key='perfil-{{ $sector->id }}'>
                                                    {{ $sector->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('form.tipoSectorSelected')" class="mt-2" aria-live="assertive" />
                                </div>
                            </div>


                            <div class="sm:col-span-3"
                                x-data=""
                                {{-- x-data="{ selectedPerfilPublico: $wire.entangle('form.tipoSectorPublicoSelected'), selectedPerfilPivot: $wire.entangle('form.tipoSectorPublicoSelectedPivot') }" --}}
                                x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPublica }}"
                                >
                                <x-input-label for="tipoSectorPublicoSelected">{{ __('Publico:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="tipoSectorPublicoSelected" wire:model.live="form.tipoSectorPublicoSelected"
                                        x-on:change="const selectedOption2 = event.target.options[event.target.selectedIndex];
                                        const sectorOption2 = selectedOption2.getAttribute('data-sector-publico-options');
                                        $wire.set('form.tipoSectorPublicoSelectedPivot', sectorOption2);
                                        console.log($wire.form.tipoSectorPublicoSelected, $wire.form.tipoSectorPublicoSelected);
                                        "
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'border-2 border-red-500' => $errors->has('form.tipoSectorPublicoSelected')
                                        ])
                                    >

                                        <option value="" data-sector-publico-options="">{{ __('Seleccione un perfil') }}</option>
                                        @foreach($tipoSectorPublico as $sector)
                                            <option value="{{ $sector->id }}" data-sector-publico-options="{{ $sector->pivotid }}" wire:key='publico-{{ $sector->id }}'>
                                                {{ $sector->nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <x-input-error :messages="$errors->get('form.tipoSectorPublicoSelected')" class="mt-2" aria-live="assertive" />

                                </div>
                            </div>

                            <div class="sm:col-span-3"
                            x-data=""
                            x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPrivada }}">
                                <x-input-label for="tiposectorprivado">{{ __('Privado:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="tiposectorprivado" wire:model.live="form.tipoSectorPrivadoSelected"
                                        x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                        const sectorOption = selectedOption.getAttribute('data-sector-privado-options');
                                        $wire.set('form.tipoSectorPrivadoSelectedPivot', sectorOption);
                                        "
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'border-2 border-red-500' => $errors->has('form.tipoSectorPrivadoSelected')
                                        ])
                                    >
                                        <option value="" data-sector-privado-options="">{{ __('Seleccione una opción') }}</option>
                                        @foreach($tipoSectorPrivado as $sector)
                                            <option value="{{ $sector->id }}" data-sector-privado-options="{{ $sector->pivotid }}" wire:key='privado-{{ $sector->id }}'>
                                                {{ $sector->nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                <x-input-error :messages="$errors->get('form.tipoSectorPrivadoSelected')"
                                    class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPrivada }} && $wire.form.tipoSectorPrivadoSelected == {{ $form->otroTipoSectorPrivado }}">
                                <x-input-label for="otro_sector_privado">{{ __('Otro:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.otro_sector_privado" id="otro_sector_privado"
                                        name="otro_sector_privado" type="text"
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.otro_sector_privado')])
                                        />
                                </div>
                                <x-input-error :messages="$errors->get('form.otro_sector_privado')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3" x-data="" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPrivada }}">
                                <x-input-label for="origenEmpresaPrivadaSelected">{{ __('Origen de la empresa del
                                    sector
                                    privado:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="tiposectorprivado" wire:model="form.origenEmpresaPrivadaSelected"
                                        x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                        const sectorOption = selectedOption.getAttribute('data-sector-origen-privado-options');
                                        $wire.set('form.origenEmpresaPrivadaSelectedPivot', sectorOption);
                                        "
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'border-2 border-red-500' => $errors->has('form.origenEmpresaPrivadaSelected')
                                        ])
                                    >
                                        <option value="" data-sector-origen-privado-options="">{{ __('Seleccione una opción') }}</option>
                                        @foreach($origenEmpresaPrivada as $sector)
                                            <option value="{{ $sector->id }}" data-sector-origen-privado-options="{{ $sector->pivotid }}" wire:key='origen-privado-{{ $sector->id }}'>
                                                {{ $sector->nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <x-input-error :messages="$errors->get('form.origenEmpresaPrivadaSelected')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>
                            <div class="sm:col-span-3" x-data="" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorPrivada }}">
                                <x-input-label for="tamanoEmpresaPrivadaSelected">{{ __('Tamaño de la empresa del sector
                                    privado:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="tamanoEmpresaPrivadaSelected" wire:model="form.tamanoEmpresaPrivadaSelected"
                                        x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                        const sectorOption = selectedOption.getAttribute('data-sector-tamano-privado-options');
                                        $wire.set('form.tamanoEmpresaPrivadaSelectedPivot', sectorOption);
                                        "
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'border-2 border-red-500' => $errors->has('form.tamanoEmpresaPrivadaSelected')
                                        ])
                                    >
                                        <option value="" data-sector-tamano-privado-options="">{{ __('Seleccione una opción') }}</option>
                                        @foreach($tamanoEmpresaPrivada as $sector)
                                            <option value="{{ $sector->id }}" data-sector-tamano-privado-options="{{ $sector->pivotid }}" wire:key='tamano-privado-{{ $sector->id }}'>
                                                {{ $sector->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('form.tamanoEmpresaPrivadaSelected')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3" x-data=""x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorComunitaria }}">
                                <x-input-label for="tipoSectorComunitariaSelected">{{ __('Comunitaria:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="tipoSectorComunitariaSelected" wire:model="form.tipoSectorComunitariaSelected"
                                        x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                        const sectorOption = selectedOption.getAttribute('data-sector-comunitaria-options');
                                        $wire.set('form.tipoSectorComunitariaSelectedPivot', sectorOption);
                                        "
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'border-2 border-red-500' => $errors->has('form.tipoSectorComunitariaSelected')
                                        ])
                                    >
                                        <option value="" data-sector-comunitaria-options="">{{ __('Seleccione una opción') }}</option>
                                        @foreach($tipoSectorComunitaria as $sector)
                                            <option value="{{ $sector->id }}" data-sector-comunitaria-options="{{ $sector->pivotid }}" wire:key='comunitaria-{{ $sector->id }}'>
                                                {{ $sector->nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- <x-forms.single-select name="tipoSectorComunitariaSelected"
                                        wire:model.live='form.tipoSectorComunitariaSelected'
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        id="tipoSectorComunitariaSelected'" :options="$tipoSectorComunitaria"
                                        selected="Seleccione una opción"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.tipoSectorComunitariaSelected')])
                                        /> --}}
                                        <x-input-error
                                            :messages="$errors->get('form.tipoSectorComunitariaSelected')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>
                            <div class="sm:col-span-3" x-data="" x-show="$wire.form.tipoSectorSelected == {{ $form->tipoSectorAcademica }}">
                                <x-input-label for="tipoSectorAcademicaSelected">{{ __('Acádemia y de
                                    Investigación:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="tipoSectorAcademicaSelected" wire:model="form.tipoSectorAcademicaSelected"
                                        x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                        const sectorOption = selectedOption.getAttribute('data-sector-academica-options');
                                        $wire.set('form.tipoSectorAcademicaSelectedPivot', sectorOption);
                                        "
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.tipoSectorAcademicaSelected')
                                        ])
                                    >
                                        <option value="" data-sector-academica-options="">{{ __('Seleccione una opción') }}</option>
                                        @foreach($tipoSectorAcademica as $sector)
                                            <option value="{{ $sector->id }}" data-sector-academica-options="{{ $sector->pivotid }}" wire:key='academica-{{ $sector->id }}'>
                                                {{ $sector->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('form.tipoSectorAcademicaSelected')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="nombre_beneficiario">{{ __('Nombre del punto de
                                    contacto de la organización:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.nombre_contacto" id="nombre_contacto"
                                        name="nombre_contacto" type="text"
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.nombre_contacto')])
                                        />
                                </div>
                                <x-input-error :messages="$errors->get('form.nombre_contacto')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="cargo-contacto">{{ __('Cargo del punto de contacto de la organización:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.cargo_contacto" id="cargo_contacto"
                                        name="cargo_contacto" type="text"
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.cargo_contacto')])
                                        />
                                </div>
                                <x-input-error :messages="$errors->get('form.cargo_contacto')" class="mt-2" />
                            </div>
                            <div class="sm:col-span-3">
                                <x-input-label for="tipoContacto">{{ __('Clasificación del tipo de contacto:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">

                                    <select name="tipo_contacto" id="tipoContacto" wire:model="form.tipo_contacto"
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.tipo_contacto')
                                        ])
                                    >
                                        <option value="">{{ __('Seleccione una opción') }}</option>
                                        @foreach(collect(["1" => "Lobby", "2" => "Primario", "3" => "Secundario", "4" => "No definidio"]) as $key => $value)
                                            <option value="{{ $key }}" wire:key='tipo-contacto-{{ $key }}'>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <x-input-error :messages="$errors->get('form.tipo_contacto')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="correo_email">{{ __('Correo electronico del contacto:')
                                    }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.contacto_email" id="correo_email"
                                        name="contacto_email" type="email"
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.contacto_email')])
                                        />
                                </div>
                                <x-input-error :messages="$errors->get('form.contacto_email')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="departamentoSelected">{{ __('Teléfono de la organización:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.contacto_telefono" id="contacto_telefono"
                                        name="contacto_telefono" type="text"
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.contacto_telefono')])
                                        />
                                        <x-input-error :messages="$errors->get('form.contacto_telefono')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="responsable_glasswing">{{ __('Responsable de Glasswing:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.responsable_glasswing" id="responsable_glasswing"
                                        name="responsable_glasswing" type="text"
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.responsable_glasswing')])
                                        />
                                </div>
                                <x-input-error :messages="$errors->get('form.responsable_glasswing')" class="mt-2" />
                            </div>

                            <div class="col-span-full">

                                <x-input-label for="consideracions-generales">{{ __('Consideraciones Generales:') }}
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="consideracions-generales"
                                        id="consideracions-generales" {{ $form->readonly ? 'disabled' : '' }}
                                    wire:model="form.consideraciones_generales" rows="3"
                                    @class([
                                        'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                        'border-0 border-slate-300'=> $errors->missing('form.consideraciones_generales'),
                                        'border-2 border-red-500' => $errors->has('form.consideraciones_generales'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])
                                    @error('form.consideraciones_generales')
                                        aria-invalid="true"
                                        aria-description="{{ $message }}"
                                    @enderror
                                    ></textarea>

                                    <x-input-error
                                        :messages="$errors->get('form.consideraciones_generales')"
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
                    <p class="mt-1 text-sm leading-6 text-gray-600">Alianza</p>
                </div>

                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                            {{--<div class="sm:col-span-3">
                                <x-input-label for="tipoAlianza">{{ __('Tipo de alianza:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="tipoAlianzaSelected" wire:model="form.tipoAlianzaSelected"
                                        x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                        const sectorOption = selectedOption.getAttribute('data-tipo-alianza-options');
                                        $wire.set('form.tipoAlianzaSelectedPivot', sectorOption); console.log($wire.form.tipoAlianzaSelected, $wire.form.tipoAlianzaSelectedPivot);
                                        "
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.tipoAlianzaSelected')
                                        ])
                                    >
                                        <option value="" data-tipo-alianza-options="">{{ __('Seleccione una opción') }}</option>
                                        @foreach($tipoAlianza as $sector)
                                            <option value="{{ $sector->id }}" data-tipo-alianza-options="{{ $sector->pivotid }}" wire:key='tipo-alianza-{{ $sector->id }}'>
                                                {{ $sector->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                        <x-input-error :messages="$errors->get('form.tipoAlianzaSelected')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <div x-show="$wire.form.tipoAlianzaSelected == {{  $form->tipoAlianzaOtro }}">
                                    <x-input-label for="otros_tipo_alianza">{{ __('Otros:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.otros_tipo_alianza" id="otros_tipo_alianza"
                                            name="otros_tipo_alianza" type="text"
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.otros_tipo_alianza')])
                                            />
                                            <x-input-error :messages="$errors->get('form.otros_tipo_alianza')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                                </div>
                            </div> --}}

                            <div class="sm:col-span-3">
                                <x-input-label for="cobertura_geografica">{{ __('Seleccione la cobertura geográfica:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="cobertura_geografica" wire:model.live="form.cobertura_geografica"
                                    x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                    const sectorOption = selectedOption.getAttribute('data-option');
                                    $wire.set('form.coberturaGeograficaSelectedPivot', sectorOption);
                                    "
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.cobertura_geografica')
                                        ])
                                    >
                                        <option value="" >{{ __('Seleccione una opción') }}</option>
                                        @foreach($coberturaGeografica as $cobertura)
                                            <option value="{{ $cobertura->id }}" data-option="{{ $cobertura->pivotid }}" wire:key='cobertura-geografica-{{ $key }}'>
                                                {{ $cobertura->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                        <x-input-error :messages="$errors->get('form.cobertura_geografica')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full" x-show="
                            $wire.form.cobertura_geografica == {{  \App\Models\CoberturaGeografica::INTERNACIONAL }} ||
                            $wire.form.cobertura_geografica == {{  \App\Models\CoberturaGeografica::NACIONAL_INTERNACIONAL }}"
                            >
                                    <x-input-label for="cobertura_internacional">{{ __('Internacional:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.cobertura_internacional" id="cobertura_internacional"
                                            name="cobertura_internacional" type="text"
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.cobertura_internacional')])
                                            />
                                            <x-input-error :messages="$errors->get('form.cobertura_internacional')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                            </div>

                            <div class="col-span-full" x-cloak x-show="
                            $wire.form.cobertura_geografica == {{  \App\Models\CoberturaGeografica::NACIONAL }} ||
                            $wire.form.cobertura_geografica == {{  \App\Models\CoberturaGeografica::NACIONAL_INTERNACIONAL }}"
                            >
                                <x-input-label for="coberturaNacionalSelected">{{ __('Nacional:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <div wire:ignore
                                        x-data
                                        x-init="
                                            $nextTick(() => {
                                                const choices = new Choices($refs.newselectNacional, {
                                                    removeItems: true,
                                                    removeItemButton: true,
                                                    placeholderValue: 'Seleccione una o más areas de cobertura nacional',
                                                })
                                        })"
                                    >
                                        <select
                                            x-ref="newselectNacional"
                                            wire:change="$set('form.coberturaNacionalSelected', [...$event.target.options].filter(option => option.selected).map(option => option.value))"
                                            multiple
                                            {{ $form->readonly ? 'disabled' : '' }} id="coberturaNacionalSelected"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.coberturaNacionalSelected')])
                                        >
                                            @foreach($form->departamentos as $key => $value)
                                                <option value="{{ $key }}" @selected(in_array($key, $form->coberturaNacionalSelected))>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-input-error :messages="$errors->get('form.coberturaNacionalSelected')" class="mt-2" aria-live="assertive" />

                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="capacidadOperativa">{{ __('Seleccione la capacidad operativa:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="capacidad_operativa" id="capacidadOperativa" wire:model="form.capacidad_operativa"
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.capacidad_operativa')
                                        ])
                                    >
                                        <option value="">{{ __('Seleccione una opción') }}</option>
                                        @foreach(collect(["1" => "Si", "2" => "No", "3" => "No aplica"]) as $key => $value)
                                            <option value="{{ $key }}" wire:key='capacidad-operativa-{{ $key }}'>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                        <x-input-error :messages="$errors->get('form.capacidad_operativa')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>
                            <div class="col-span-full">
                                <x-input-label for="NivelInversion">{{ __('Escriba el nivel de inversión por parte de la iniciativa:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">

                                    <x-text-input wire:model.live="form.nivel_inversion" id="nivel_inversion"
                                    name="nivel_inversion" type="number" step="0.01" min="0"
                                    disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.nivel_inversion')])
                                    />

                                    <x-input-error :messages="$errors->get('form.nivel_inversion')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="tipoActor">{{ __('Seleccione el tipo de actor:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <div class="max-w-2xl space-y-10">
                                        <fieldset>
                                            <div class="flex flex-wrap gap-4 mt-6">
                                                @foreach ($form->tipoActores as $tipoActor)
                                                    <div class="relative flex gap-x-3 w-[45%]">
                                                        <div class="flex items-center h-6">
                                                            <x-text-input type="checkbox" name="tipo-actor-{{ $tipoActor->value }}"
                                                                wire:key='tipo-actor{{ $tipoActor->value }}'
                                                                wire:model="form.tipo_actor"
                                                                value="{{ $tipoActor->value }}"
                                                                disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                                @class([
                                                                    'w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600',
                                                                ])
                                                                id="tipo-actor-{{ $tipoActor->value }}"
                                                            />
                                                        </div>
                                                        <div class="text-sm leading-6">
                                                            <label for="tipo-actor-{{ $tipoActor->value }}" class="font-medium text-gray-900">{{ $tipoActor->label() }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </fieldset>
                                    </div>

                                    <x-input-error :messages="$errors->get('form.tipo_actor')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <x-input-label for="sector_productivo">{{ __('Seleccione el sector productivo:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">

                                    <select name="sector_productivo" id="sector_productivo" wire:model="form.sector_productivo"
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.sector_productivo')
                                        ])
                                    >
                                        <option value="">{{ __('Seleccione una opción') }}</option>
                                        @foreach($form->sectorProductivos as $key => $value)
                                            <option value="{{ $key }}" wire:key='sector-productivo-{{ $key }}'>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <x-input-error :messages="$errors->get('form.sector_productivo')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="pertenece_cpa">{{ __('Pertenece a PCA:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">

                                    <select name="pertenece_cpa" id="pertenece_cpa" wire:model="form.pertenece_cpa"
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.pertenece_cpa')
                                        ])
                                    >
                                        <option value="">{{ __('Seleccione una opción') }}</option>
                                        @foreach(collect(["1" => "Si", "2" => "No", "3" => "No definido"]) as $key => $value)
                                            <option value="{{ $key }}" wire:key='pertenece_cpa-{{ $key }}'>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <x-input-error :messages="$errors->get('form.pertenece_cpa')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 3</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Colaboración y Servicios</p>
                </div>

                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                            <div class="sm:col-span-3">
                                <x-input-label for="nivelColaboracion">{{ __('Seleccione el nivel de  interés de colaboración:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="nivelColaboracion" wire:model="form.nivel_colaboracion"
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.nivel_colaboracion')
                                        ])
                                    >
                                        <option value="">{{ __('Seleccione una opción') }}</option>
                                        @foreach(collect(["1" => "Mucho", "2" => "Moderado", "3" => "Poco", "4" => "No definido"]) as $key => $value)
                                            <option value="{{ $key }}" wire:key='nivel-colaboracion-{{ $key }}'>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                        <x-input-error :messages="$errors->get('form.nivel_colaboracion')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                    <x-input-label for="servicios_posibles">{{ __('Escribe los servicios posibles:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="servicios_posibles" id="servicios_posibles" {{
                                            $form->readonly ? 'disabled' : '' }}
                                        wire:model="form.servicios_posibles" rows="3"
                                        @class([
                                            'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.servicios_posibles'),
                                            'border-2 border-red-500' => $errors->has('form.servicios_posibles'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                        ])
                                        @error('form.servicios_posibles')
                                            aria-invalid="true"
                                            aria-description="{{ $message }}"
                                        @enderror
                                        ></textarea>
                                            <x-input-error :messages="$errors->get('form.servicios_posibles')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.impactoPotencialSelected">{{ __('Impacto potencial de la alianza') }} <x-required-label /></x-input-label>
                                <div class="px-4">
                                    <div class="max-w-2xl space-y-10">
                                        <fieldset>
                                            <div class="flex flex-wrap gap-4 mt-6">
                                                @foreach ($impactoPotenciales as $key => $value)
                                                    <div class="relative flex gap-x-3 w-[45%]">
                                                        <div class="flex items-center h-6">
                                                            <x-text-input type="checkbox" name="impacto-potencial-{{ $key }}"
                                                                wire:key='impacto-potencial-{{ $key }}'
                                                                wire:model="form.impactoPotencialSelected"
                                                                value="{{ $key }}"
                                                                disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                                                @class([
                                                                    'w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600',
                                                                ])
                                                                id="impacto-potencial-{{ $key }}"
                                                            />
                                                        </div>
                                                        <div class="text-sm leading-6">
                                                            <label for="impacto-potencial-{{ $key }}" class="font-medium text-gray-900">{{ $value }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <x-input-error :messages="$errors->get('form.impactoPotencialSelected')" class="mt-2" />
                                        </fieldset>
                                    </div>
                                </div>
                            </div>



                            <div class="sm:col-span-3">
                                <x-input-label for="espera_de_alianza">{{ __('¿Qué se espera de esta alianza?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="espera_de_alianza" id="espera_de_alianza" wire:model="form.espera_de_alianza"
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.espera_de_alianza')
                                        ])
                                    >
                                        <option value="">{{ __('Seleccione una opción') }}</option>
                                        @foreach(collect(["1" => "Costshare", "2" => "Leverage", "3" => "Ambas"]) as $key => $value)
                                            <option value="{{ $key }}" wire:key='esperar-alianza-{{ $key }}'>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                        <x-input-error :messages="$errors->get('form.espera_de_alianza')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="aporte_espera_alianza">{{ __('¿Qué tipo de aporte se espera de esta alianza?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="aporte_espera_alianza" id="aporte_espera_alianza" wire:model="form.aporte_espera_alianza"
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.aporte_espera_alianza')
                                        ])
                                    >
                                        <option value="">{{ __('Seleccione una opción') }}</option>
                                        @foreach(collect(["1" => "En efectivo", "2" => "En especie", "3" => "Ambas"]) as $key => $value)
                                            <option value="{{ $key }}" wire:key='esperar-alianza-{{ $key }}'>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                        <x-input-error :messages="$errors->get('form.aporte_espera_alianza')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>


                            <div class="col-span-full" x-show="$wire.form.aporte_espera_alianza == 1 || $wire.form.aporte_espera_alianza == 3">
                                    <x-input-label for="monto_esperado">{{ __('Especifique el monto (USD)') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.monto_esperado" id="monto_esperado"
                                            name="monto_esperado" type="number" step="0.01" min="0"
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.monto_esperado')])
                                            />
                                            <x-input-error :messages="$errors->get('form.monto_esperado')"
                                                class="mt-2" aria-live="assertive" />
                                    </div>
                            </div>

                            <div class="col-span-full" x-show="$wire.form.aporte_espera_alianza == 2 || $wire.form.aporte_espera_alianza == 3">
                                <x-input-label for="monto_especie">{{ __('Especifique el monto de Especie (USD)') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.monto_especie" id="monto_especie"
                                        name="monto_especie" type="number" step="0.01" min="0"
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                        $form->readonly,
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.monto_especie')])
                                        />
                                        <x-input-error :messages="$errors->get('form.monto_especie')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="impacto_pontencial">{{ __('Escriba la cantidad del impacto potencial:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model.live="form.impacto_pontencial" id="impacto_pontencial"
                                            name="impacto_pontencial" type="number" step="0.01" max="100" min="0"
                                            disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                            $form->readonly,
                                            'block w-full mt-1','border-2 border-red-500' =>
                                            $errors->has('form.impacto_pontencial')])
                                            />
                                        <small>En porcentaje (%)</small>
                                        <x-input-error :messages="$errors->get('form.impacto_pontencial')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="col-span-full">
                                    <x-input-label for="tipo_impacto_potencial">{{ __('Escriba el tipo del impacto potencial:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="tipo_impacto_potencial" id="tipo_impacto_potencial" {{
                                            $form->readonly ? 'disabled' : '' }}
                                        wire:model="form.tipo_impacto_potencial" rows="3"
                                        @class([
                                            'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.tipo_impacto_potencial'),
                                            'border-2 border-red-500' => $errors->has('form.tipo_impacto_potencial'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                        ])
                                        @error('form.tipo_impacto_potencial')
                                            aria-invalid="true"
                                            aria-description="{{ $message }}"
                                        @enderror
                                        ></textarea>

                                        <x-input-error
                                        :messages="$errors->get('form.tipo_impacto_potencial')"
                                        class="mt-2" aria-live="assertive" />
                                    </div>
                            </div>

                            <div class="col-span-full">
                                    <x-input-label for="resultados_esperados">{{ __('Escriba los resultados esperados:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <textarea name="resultados_esperados" id="resultados_esperados" {{
                                            $form->readonly ? 'disabled' : '' }}
                                        wire:model="form.resultados_esperados" rows="3"
                                        @class([
                                            'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                            'border-0 border-slate-300'=> $errors->missing('form.resultados_esperados'),
                                            'border-2 border-red-500' => $errors->has('form.resultados_esperados'),
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                        ])
                                        @error('form.resultados_esperados')
                                            aria-invalid="true"
                                            aria-description="{{ $message }}"
                                        @enderror
                                        ></textarea>

                                        <x-input-error
                                        :messages="$errors->get('form.resultados_esperados')"
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
                    <p class="mt-1 text-sm leading-6 text-gray-600">Prioridad y Tiempos</p>
                </div>

                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                            <div class="sm:col-span-3">
                                <x-input-label for="anio_fiscal_firma">{{ __('Seleccione el año fiscal aproximado para firma:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="anio_fiscal_firma" wire:model="form.anio_fiscal_firma"
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.anio_fiscal_firma')
                                        ])
                                    >
                                        <option value="" >{{ __('Seleccione una opción') }}</option>
                                        @php
                                            $currentYear = now()->year;
                                            $years = range($currentYear, $currentYear + 5);
                                        @endphp

                                        @foreach($years as $year)
                                            <option value="{{ $year }}" wire:key='anio-fiscal-{{ $sector->id }}'>FY{{ substr($year, -2) }}</option>
                                        @endforeach
                                    </select>
                                        <x-input-error :messages="$errors->get('form.anio_fiscal_firma')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>


                            <div class="sm:col-span-3">
                                <x-input-label for="trimestre_aproximado_firma">{{ __('Seleccione el trimestre aproximado para firma:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="perfiles" id="trimestre_aproximado_firma" wire:model="form.trimestre_aproximado_firma"
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.trimestre_aproximado_firma')
                                        ])
                                    >
                                        <option value="" >{{ __('Seleccione una opción') }}</option>
                                        @foreach(collect(['1' => 'Q1', '2' => 'Q2', '3' => 'Q3', '4' => 'Q4']) as $key => $value)
                                            <option value="{{ $key }}" wire:key='anio-fiscal-firma-{{ $value }}'>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                        <x-input-error :messages="$errors->get('form.trimestre_aproximado_firma')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="estado_prealianza">{{ __('Seleccione el Estatus de la Alianza:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <select name="estado_prealianza" id="estado_prealianza" wire:model="form.estado_prealianza"
                                        @class([
                                            'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=> $form->readonly,
                                            'border-2 border-red-500' => $errors->has('form.estado_prealianza')
                                        ])
                                    >
                                        <option value="" >{{ __('Seleccione una opción') }}</option>
                                        @foreach(collect(['1' => 'Atrasado', '2' => 'Cierto nivel de atraso', '3' => 'En tiempo']) as $key => $value)
                                            <option value="{{ $key }}" wire:key='estado-prealianza-{{ $value }}'>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                        <x-input-error :messages="$errors->get('form.estado_prealianza')"
                                            class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="fecha_estado_alianza">{{ __('Fecha en que se actualiza el estatus de la alianza:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.fecha_estado_alianza" id="form.fecha_estado_alianza"
                                    name="form.fecha_estado_alianza" type="date" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                       @class([
                                           'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                           'block w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_estado_alianza')
                                       ])
                                   />
                                   <x-input-error :messages="$errors->get('form.fecha_estado_alianza')" class="mt-2" />
                                </div>
                            </div>


                            <div class="col-span-full">

                                <x-input-label for="proximos_pasos">{{ __('Escriba los proximos pasos:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="proximos_pasos" id="proximos_pasos" {{
                                        $form->readonly ? 'disabled' : '' }}
                                    wire:model="form.proximos_pasos" rows="3"
                                    @class([
                                        'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                        'border-0 border-slate-300'=> $errors->missing('form.proximos_pasos'),
                                        'border-2 border-red-500' => $errors->has('form.proximos_pasos'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])
                                    @error('form.proximos_pasos')
                                        aria-invalid="true"
                                        aria-description="{{ $message }}"
                                    @enderror
                                    ></textarea>

                                    <x-input-error
                                        :messages="$errors->get('form.proximos_pasos')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>
                            <div class="col-span-full">

                                <x-input-label for="observaciones">{{ __('Observaciones:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea name="observaciones" id="observaciones" {{
                                        $form->readonly ? 'disabled' : '' }}
                                    wire:model="form.observaciones" rows="3"
                                    @class([
                                        'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                        'border-0 border-slate-300'=> $errors->missing('form.observaciones'),
                                        'border-2 border-red-500' => $errors->has('form.observaciones'),
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $form->readonly,
                                    ])
                                    @error('form.observaciones')
                                        aria-invalid="true"
                                        aria-description="{{ $message }}"
                                    @enderror
                                    ></textarea>

                                    <x-input-error
                                        :messages="$errors->get('form.observaciones')"
                                        class="mt-2" aria-live="assertive" />
                                </div>
                            </div>

                        </div>
                    </div>

                    <div
                        class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
                        <button type="submit" @disabled($form->readonly)
                            class="relative w-full px-8 py-3 font-medium text-white bg-blue-500 rounded-lg disabled:cursor-not-allowed disabled:opacity-75">
                            {{ $saveLabel }}

                            <div wire:loading.flex wire:target="save"
                                class="absolute top-0 bottom-0 right-0 flex items-center pr-4">
                                <svg class="w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </button>
                    </div>

                </div>
            </div>




        </div>
    </form>

     <!-- Success Indicator... -->
     <x-notifications.success-text-notification message="Successfully saved!" />

     <!-- Error Indicator... -->
     <x-notifications.error-text-notification message="Han habido errores en el formulario" />

     <!-- Success Alert... -->
     <x-notifications.alert-success-notification>
         <p class="text-sm font-medium text-gray-900">¡Guardado exitosamente!</p>
         <p class="mt-1 text-sm text-gray-500">El registro fue guardado exitosamente y los cambios aparecerán en la ficha de registro.</p>
     </x-notifications.alert-success-notification>

     <!-- Error Alert... -->
     <x-notifications.alert-error-notification>
       <p class="text-sm font-medium text-red-900">¡Errores en el formulario!</p>
       <p class="mt-1 text-sm text-gray-500">Han habido problemas para guardar los cambios, corrija cualquier error en el formulario e intente nuevamente.</p>
     </x-notifications.alert-error-notification>

</div>
