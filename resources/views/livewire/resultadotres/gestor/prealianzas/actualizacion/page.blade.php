<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('PreAlianzas') }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - PreAlianzas</small>
    </x-slot>

    <div class="py-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">PRE ALIANZAS</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Lista de todos las pre alianzas en su cuenta incluyendo su nombre, ciudad, DNI, estado y
                        fecha de registro.</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <a href="{{ route('pre.alianza.create', [$pais, $proyecto]) }}" role="button"
                        class="block px-3 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        wire:navigate>
                        Registrar Pre Alianza
                    </a>
                </div>
            </div>
            <div x-data="{ tab: 'registro' }" class="flex">
                <!-- Vertical Tabs -->
                <div class="flex flex-col w-1/4 border-r border-gray-200">
                    <button @click="tab = 'registro'" :class="{ 'bg-indigo-400 text-white': tab === 'registro' }"
                        class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-indigo-100">Registro
                    </button>
                    <button @click="tab = 'historial'" :class="{ 'bg-indigo-400 text-white': tab === 'historial' }"
                        class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-indigo-100">Historial
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="w-3/4 p-4">
                    <div x-show="tab === 'registro'">
                        <!-- Content for Registro tab -->
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
                                                        class="block text-sm font-medium leading-6 text-gray-900">Origen
                                                        de la gestión
                                                        de la Alianza:
                                                        {{ $prealianza->socioImplementador->nombre }}
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
                                                        <x-text-input wire:model="nombre_organizacion"
                                                            id="nombre_organizacion"
                                                            name="nombre_organizacion" type="text"
                                                            disabled="{{ $readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.nombre_organizacion')
                                                            ])
                                                            />
                                                            <x-input-error
                                                                :messages="$errors->get('nombre_organizacion')"
                                                                class="mt-2" />
                                                    </div>
                                                </div>



                                                {{-- <div class="sm:col-span-3" x-data="">
                                                    <x-input-label for="tipoSectorSelected">{{ __('Tipo de sector:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="tipoSectorSelected" id="perfilSelected"
                                                            wire:model.live="form.tipoSectorSelected"
                                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                                                const sectorOption = selectedOption.getAttribute('data-sector-options');
                                                                $wire.set('form.tipoSectorSelectedPivot', sectorOption);"
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'border-2 border-red-500'=>
                                                            $errors->has('form.tipoSectorSelected')
                                                            ])
                                                            >

                                                            <option value="">{{ __('Seleccione un perfil') }}</option>
                                                            @foreach($tiposector as $sector)
                                                            <option value="{{ $sector->id }}"
                                                                data-sector-options="{{ $sector->pivotid }}"
                                                                wire:key='perfil-{{ $sector->id }}'>
                                                                {{ $sector->nombre }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error
                                                            :messages="$errors->get('form.tipoSectorSelected')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>


                                                <div class="sm:col-span-3" x-data=""
                                                    x-show="$wire.tipoSectorSelected == {{ $tipoSectorPublica }}">
                                                    <x-input-label for="tipoSectorPublicoSelected">{{ __('Publico:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="tipoSectorPublicoSelected"
                                                            wire:model.live="form.tipoSectorPublicoSelected"
                                                            x-on:change="const selectedOption2 = event.target.options[event.target.selectedIndex];
                                                            const sectorOption2 = selectedOption2.getAttribute('data-sector-publico-options');
                                                            $wire.set('form.tipoSectorPublicoSelectedPivot', sectorOption2);
                                                            console.log($wire.tipoSectorPublicoSelected, $wire.tipoSectorPublicoSelected);
                                                            "
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'border-2 border-red-500'=>
                                                            $errors->has('form.tipoSectorPublicoSelected')
                                                            ])
                                                            >

                                                            <option value="" data-sector-publico-options="">{{
                                                                __('Seleccione un perfil') }}</option>
                                                            @foreach($tipoSectorPublico as $sector)
                                                            <option value="{{ $sector->id }}"
                                                                data-sector-publico-options="{{ $sector->pivotid }}"
                                                                wire:key='publico-{{ $sector->id }}'>
                                                                {{ $sector->nombre }}
                                                            </option>
                                                            @endforeach
                                                        </select>

                                                        <x-input-error
                                                            :messages="$errors->get('form.tipoSectorPublicoSelected')"
                                                            class="mt-2" aria-live="assertive" />

                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3" x-data=""
                                                    x-show="$wire.tipoSectorSelected == {{ $tipoSectorPrivada }}">
                                                    <x-input-label for="tiposectorprivado">{{ __('Privado:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="tiposectorprivado"
                                                            wire:model.live="form.tipoSectorPrivadoSelected"
                                                            x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                                            const sectorOption = selectedOption.getAttribute('data-sector-privado-options');
                                                            $wire.set('form.tipoSectorPrivadoSelectedPivot', sectorOption);
                                                            "
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'border-2 border-red-500'=>
                                                            $errors->has('form.tipoSectorPrivadoSelected')
                                                            ])
                                                            >
                                                            <option value="" data-sector-privado-options="">{{
                                                                __('Seleccione una opción') }}</option>
                                                            @foreach($tipoSectorPrivado as $sector)
                                                            <option value="{{ $sector->id }}"
                                                                data-sector-privado-options="{{ $sector->pivotid }}"
                                                                wire:key='privado-{{ $sector->id }}'>
                                                                {{ $sector->nombre }}
                                                            </option>
                                                            @endforeach
                                                        </select>

                                                        <x-input-error
                                                            :messages="$errors->get('form.tipoSectorPrivadoSelected')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div> --}}

                                                {{-- <div class="col-span-full"
                                                    x-show="$wire.tipoSectorPrivadoSelected == {{ $otroTipoSectorPrivado }}">
                                                    <x-input-label for="otro_sector_privado">{{ __('Otro:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.otro_sector_privado"
                                                            id="otro_sector_privado" name="otro_sector_privado"
                                                            type="text"
                                                            disabled="{{ $readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.otro_sector_privado')])
                                                            />
                                                    </div>
                                                    <x-input-error :messages="$errors->get('form.otro_sector_privado')"
                                                        class="mt-2" />
                                                </div>

                                                <div class="sm:col-span-3" x-data=""
                                                    x-show="$wire.tipoSectorSelected == {{ $tipoSectorPrivada }}">
                                                    <x-input-label for="origenEmpresaPrivadaSelected">{{ __('Origen de
                                                        la empresa del
                                                        sector
                                                        privado:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="tiposectorprivado"
                                                            wire:model="form.origenEmpresaPrivadaSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                                            const sectorOption = selectedOption.getAttribute('data-sector-origen-privado-options');
                                                            $wire.set('form.origenEmpresaPrivadaSelectedPivot', sectorOption);
                                                            "
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'border-2 border-red-500'=>
                                                            $errors->has('form.origenEmpresaPrivadaSelected')
                                                            ])
                                                            >
                                                            <option value="" data-sector-origen-privado-options="">{{
                                                                __('Seleccione una opción') }}</option>
                                                            @foreach($origenEmpresaPrivada as $sector)
                                                            <option value="{{ $sector->id }}"
                                                                data-sector-origen-privado-options="{{ $sector->pivotid }}"
                                                                wire:key='origen-privado-{{ $sector->id }}'>
                                                                {{ $sector->nombre }}
                                                            </option>
                                                            @endforeach
                                                        </select>

                                                        <x-input-error
                                                            :messages="$errors->get('form.origenEmpresaPrivadaSelected')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>
                                                <div class="sm:col-span-3" x-data=""
                                                    x-show="$wire.tipoSectorSelected == {{ $tipoSectorPrivada }}">
                                                    <x-input-label for="tamanoEmpresaPrivadaSelected">{{ __('Tamaño de
                                                        la empresa del sector
                                                        privado:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="tamanoEmpresaPrivadaSelected"
                                                            wire:model="form.tamanoEmpresaPrivadaSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                                            const sectorOption = selectedOption.getAttribute('data-sector-tamano-privado-options');
                                                            $wire.set('form.tamanoEmpresaPrivadaSelectedPivot', sectorOption);
                                                            "
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'border-2 border-red-500'=>
                                                            $errors->has('form.tamanoEmpresaPrivadaSelected')
                                                            ])
                                                            >
                                                            <option value="" data-sector-tamano-privado-options="">{{
                                                                __('Seleccione una opción') }}</option>
                                                            @foreach($tamanoEmpresaPrivada as $sector)
                                                            <option value="{{ $sector->id }}"
                                                                data-sector-tamano-privado-options="{{ $sector->pivotid }}"
                                                                wire:key='tamano-privado-{{ $sector->id }}'>
                                                                {{ $sector->nombre }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error
                                                            :messages="$errors->get('form.tamanoEmpresaPrivadaSelected')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div> --}}
{{--
                                                <div class="sm:col-span-3" x-data=""
                                                    x-show="$wire.tipoSectorSelected == {{ $tipoSectorComunitaria }}">
                                                    <x-input-label for="tipoSectorComunitariaSelected">{{
                                                        __('Comunitaria:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="tipoSectorComunitariaSelected"
                                                            wire:model="form.tipoSectorComunitariaSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                                            const sectorOption = selectedOption.getAttribute('data-sector-comunitaria-options');
                                                            $wire.set('form.tipoSectorComunitariaSelectedPivot', sectorOption);
                                                            "
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'border-2 border-red-500'=>
                                                            $errors->has('form.tipoSectorComunitariaSelected')
                                                            ])
                                                            >
                                                            <option value="" data-sector-comunitaria-options="">{{
                                                                __('Seleccione una opción') }}</option>
                                                            @foreach($tipoSectorComunitaria as $sector)
                                                            <option value="{{ $sector->id }}"
                                                                data-sector-comunitaria-options="{{ $sector->pivotid }}"
                                                                wire:key='comunitaria-{{ $sector->id }}'>
                                                                {{ $sector->nombre }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                            <x-input-error
                                                                :messages="$errors->get('form.tipoSectorComunitariaSelected')"
                                                                class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>
                                                <div class="sm:col-span-3" x-data=""
                                                    x-show="$wire.tipoSectorSelected == {{ $tipoSectorAcademica }}">
                                                    <x-input-label for="tipoSectorAcademicaSelected">{{ __('Acádemia y
                                                        de
                                                        Investigación:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="tipoSectorAcademicaSelected"
                                                            wire:model="form.tipoSectorAcademicaSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                                            const sectorOption = selectedOption.getAttribute('data-sector-academica-options');
                                                            $wire.set('form.tipoSectorAcademicaSelectedPivot', sectorOption);
                                                            "
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' =>
                                                            $errors->has('form.tipoSectorAcademicaSelected')
                                                            ])
                                                            >
                                                            <option value="" data-sector-academica-options="">{{
                                                                __('Seleccione una opción') }}</option>
                                                            @foreach($tipoSectorAcademica as $sector)
                                                            <option value="{{ $sector->id }}"
                                                                data-sector-academica-options="{{ $sector->pivotid }}"
                                                                wire:key='academica-{{ $sector->id }}'>
                                                                {{ $sector->nombre }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error
                                                            :messages="$errors->get('form.tipoSectorAcademicaSelected')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="col-span-full">
                                                    <x-input-label for="nombre_beneficiario">{{ __('Nombre del punto de
                                                        contacto de la organización:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.nombre_contacto"
                                                            id="nombre_contacto" name="nombre_contacto" type="text"
                                                            disabled="{{ $readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.nombre_contacto')])
                                                            />
                                                    </div>
                                                    <x-input-error :messages="$errors->get('form.nombre_contacto')"
                                                        class="mt-2" />
                                                </div> --}}

                                                <div class="col-span-full">
                                                    <x-input-label for="cargo-contacto">{{ __('Cargo del punto de
                                                        contacto de la organización:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.cargo_contacto"
                                                            id="cargo_contacto" name="cargo_contacto" type="text"
                                                            disabled="{{ $readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.cargo_contacto')])
                                                            />
                                                    </div>
                                                    <x-input-error :messages="$errors->get('form.cargo_contacto')"
                                                        class="mt-2" />
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="correo_email">{{ __('Correo electronico del
                                                        contacto:')
                                                        }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.contacto_email" id="correo_email"
                                                            name="contacto_email" type="email"
                                                            disabled="{{ $readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.contacto_email')])
                                                            />
                                                    </div>
                                                    <x-input-error :messages="$errors->get('form.contacto_email')"
                                                        class="mt-2" />
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="departamentoSelected">{{ __('Teléfono de la
                                                        organización:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.contacto_telefono"
                                                            id="contacto_telefono" name="contacto_telefono" type="text"
                                                            disabled="{{ $readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.contacto_telefono')])
                                                            />
                                                            <x-input-error
                                                                :messages="$errors->get('form.contacto_telefono')"
                                                                class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="col-span-full">
                                                    <x-input-label for="responsable_glasswing">{{ __('Responsable de
                                                        Glasswing:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.responsable_glasswing"
                                                            id="responsable_glasswing" name="responsable_glasswing"
                                                            type="text"
                                                            disabled="{{ $readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.responsable_glasswing')])
                                                            />
                                                    </div>
                                                    <x-input-error
                                                        :messages="$errors->get('form.responsable_glasswing')"
                                                        class="mt-2" />
                                                </div>

                                                <div class="col-span-full">

                                                    <x-input-label for="consideracions-generales">{{ __('Consideraciones
                                                        Generales:') }}
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <textarea name="consideracions-generales"
                                                            id="consideracions-generales" {{ $readonly ? 'disabled' : '' }}
                                                        wire:model="form.consideraciones_generales" rows="3"
                                                        @class([
                                                            'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                                            'border-0 border-slate-300'=> $errors->missing('form.consideraciones_generales'),
                                                            'border-2 border-red-500' => $errors->has('form.consideraciones_generales'),
                                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $readonly,
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

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="tipoAlianza">{{ __('Tipo de alianza:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="tipoAlianzaSelected"
                                                            wire:model="form.tipoAlianzaSelected" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                                            const sectorOption = selectedOption.getAttribute('data-tipo-alianza-options');
                                                            $wire.set('form.tipoAlianzaSelectedPivot', sectorOption); console.log($wire.tipoAlianzaSelected, $wire.tipoAlianzaSelectedPivot);
                                                            "
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' =>
                                                            $errors->has('form.tipoAlianzaSelected')
                                                            ])
                                                            >
                                                            <option value="" data-tipo-alianza-options="">{{
                                                                __('Seleccione una opción') }}</option>
                                                            @foreach($tipoAlianza as $sector)
                                                            <option value="{{ $sector->id }}"
                                                                data-tipo-alianza-options="{{ $sector->pivotid }}"
                                                                wire:key='tipo-alianza-{{ $sector->id }}'>
                                                                {{ $sector->nombre }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error
                                                            :messages="$errors->get('form.tipoAlianzaSelected')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <div
                                                        x-show="$wire.tipoAlianzaSelected == {{  $tipoAlianzaOtro }}">
                                                        <x-input-label for="otros_tipo_alianza">{{ __('Otros:') }}
                                                            <x-required-label />
                                                        </x-input-label>
                                                        <div class="mt-2">
                                                            <x-text-input wire:model="form.otros_tipo_alianza"
                                                                id="otros_tipo_alianza" name="otros_tipo_alianza"
                                                                type="text"
                                                                disabled="{{ $readonly ? 'disabled' : '' }}"
                                                                @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                                $readonly,
                                                                'block w-full mt-1','border-2 border-red-500' =>
                                                                $errors->has('form.otros_tipo_alianza')])
                                                                />
                                                                <x-input-error
                                                                    :messages="$errors->get('form.otros_tipo_alianza')"
                                                                    class="mt-2" aria-live="assertive" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="cobertura_geografica">{{ __('Seleccione la
                                                        cobertura geográfica:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="cobertura_geografica"
                                                            wire:model.live="form.cobertura_geografica" x-on:change="const selectedOption = event.target.options[event.target.selectedIndex];
                                                        const sectorOption = selectedOption.getAttribute('data-option');
                                                        $wire.set('form.coberturaGeograficaSelectedPivot', sectorOption);
                                                        " @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' =>
                                                            $errors->has('form.cobertura_geografica')
                                                            ])
                                                            >
                                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                                            @foreach($coberturaGeografica as $cobertura)
                                                            <option value="{{ $cobertura->id }}"
                                                                data-option="{{ $cobertura->pivotid }}"
                                                                wire:key='cobertura-geografica-{{ $key }}'>
                                                                {{ $cobertura->nombre }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error
                                                            :messages="$errors->get('form.cobertura_geografica')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="col-span-full"
                                                    x-show="
                                                $wire.cobertura_geografica == {{  \App\Models\CoberturaGeografica::INTERNACIONAL }} ||
                                                $wire.cobertura_geografica == {{  \App\Models\CoberturaGeografica::NACIONAL_INTERNACIONAL }}">
                                                    <x-input-label for="cobertura_internacional">{{ __('Internacional:')
                                                        }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.cobertura_internacional"
                                                            id="cobertura_internacional" name="cobertura_internacional"
                                                            type="text"
                                                            disabled="{{ $readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.cobertura_internacional')])
                                                            />
                                                            <x-input-error
                                                                :messages="$errors->get('form.cobertura_internacional')"
                                                                class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="col-span-full" x-cloak
                                                    x-show="
                                                $wire.cobertura_geografica == {{  \App\Models\CoberturaGeografica::NACIONAL }} ||
                                                $wire.cobertura_geografica == {{  \App\Models\CoberturaGeografica::NACIONAL_INTERNACIONAL }}">
                                                    <x-input-label for="coberturaNacionalSelected">{{ __('Nacional:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <div wire:ignore x-data x-init="
                                                                $nextTick(() => {
                                                                    const choices = new Choices($refs.newselectNacional, {
                                                                        removeItems: true,
                                                                        removeItemButton: true,
                                                                        placeholderValue: 'Seleccione una o más areas de cobertura nacional',
                                                                    })
                                                            })">
                                                            <select x-ref="newselectNacional"
                                                                wire:change="$set('form.coberturaNacionalSelected', [...$event.target.options].filter(option => option.selected).map(option => option.value))"
                                                                multiple {{ $readonly ? 'disabled' : '' }}
                                                                id="coberturaNacionalSelected"
                                                                @class([ 'disabled:bg-slate-50 disabled:text-slate-500
                                                                disabled:border-slate-200 disabled:shadow-none'=>
                                                                $readonly,
                                                                'block w-full mt-1','border-2 border-red-500' =>
                                                                $errors->has('form.coberturaNacionalSelected')])
                                                                >
                                                                @foreach($departamentos as $key => $value)
                                                                <option value="{{ $key }}" @selected(in_array($key,
                                                                    $coberturaNacionalSelected))>{{ $value }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <x-input-error
                                                            :messages="$errors->get('form.coberturaNacionalSelected')"
                                                            class="mt-2" aria-live="assertive" />

                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="capacidadOperativa">{{ __('Seleccione la
                                                        capacidad operativa:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="capacidad_operativa" id="capacidadOperativa"
                                                            wire:model="form.capacidad_operativa"
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' =>
                                                            $errors->has('form.capacidad_operativa')
                                                            ])
                                                            >
                                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                                            @foreach(collect(["1" => "Si", "2" => "No", "3" => "No
                                                            aplica"]) as $key => $value)
                                                            <option value="{{ $key }}"
                                                                wire:key='capacidad-operativa-{{ $key }}'>
                                                                {{ $value }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error
                                                            :messages="$errors->get('form.capacidad_operativa')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>
                                                <div class="sm:col-span-3">
                                                    <x-input-label for="NivelInversion">{{ __('Escriba el nivel de
                                                        inversión:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">

                                                        <x-text-input wire:model="form.nivel_inversion"
                                                            id="nivel_inversion" name="nivel_inversion" type="number"
                                                            step="0.01"
                                                            disabled="{{ $readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.nivel_inversion')])
                                                            />

                                                            <x-input-error
                                                                :messages="$errors->get('form.nivel_inversion')"
                                                                class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="tipoActor">{{ __('Seleccione el tipo de actor:')
                                                        }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">

                                                        <select name="tipo_actor" id="tipoActor"
                                                            wire:model="form.tipo_actor"
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' => $errors->has('form.tipo_actor')
                                                            ])
                                                            >
                                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                                            @foreach(collect(["1" => "Lobby", "2" => "Primario", "3" =>
                                                            "Secundario", "4" => "No definidio"]) as $key => $value)
                                                            <option value="{{ $key }}" wire:key='tipo-actor-{{ $key }}'>
                                                                {{ $value }}
                                                            </option>
                                                            @endforeach
                                                        </select>

                                                        <x-input-error :messages="$errors->get('form.tipo_actor')"
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
                                                    <x-input-label for="nivelColaboracion">{{ __('Seleccione el nivel de
                                                        la colaboración:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="nivelColaboracion"
                                                            wire:model="form.nivel_colaboracion"
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' =>
                                                            $errors->has('form.nivel_colaboracion')
                                                            ])
                                                            >
                                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                                            @foreach(collect(["1" => "Alto", "2" => "Medio", "3" =>
                                                            "Bajo", "4" => "No definido"]) as $key => $value)
                                                            <option value="{{ $key }}"
                                                                wire:key='nivel-colaboracion-{{ $key }}'>
                                                                {{ $value }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error
                                                            :messages="$errors->get('form.nivel_colaboracion')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="col-span-full">
                                                    <x-input-label for="servicios_posibles">{{ __('Escribe los servicios
                                                        posibles:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <textarea name="servicios_posibles" id="servicios_posibles" {{
                                                            $readonly ? 'disabled' : '' }}
                                                            wire:model="form.servicios_posibles" rows="3"
                                                            @class([
                                                                'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                                                'border-0 border-slate-300'=> $errors->missing('form.servicios_posibles'),
                                                                'border-2 border-red-500' => $errors->has('form.servicios_posibles'),
                                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $readonly,
                                                            ])
                                                            @error('form.servicios_posibles')
                                                                aria-invalid="true"
                                                                aria-description="{{ $message }}"
                                                            @enderror
                                                            ></textarea>
                                                        <x-input-error
                                                            :messages="$errors->get('form.servicios_posibles')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="sector">{{ __('Seleccione el sector:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="sector"
                                                            wire:model.live="form.sector"
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' => $errors->has('form.sector')
                                                            ])
                                                            >
                                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                                            @foreach(collect(["1" => "Gobierno", "2" => "Asociación",
                                                            "3" => "Organización"]) as $key => $value)
                                                            <option value="{{ $key }}"
                                                                wire:key='sector-item-{{ $key }}'>
                                                                {{ $value }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error :messages="$errors->get('form.sector')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                {{-- <div class="sm:col-span-3">
                                                    <x-input-label for="sector_actor">{{ __('Seleccione el sector
                                                        actor:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="sector_actor"
                                                            wire:model.live="form.sector_actor"
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' =>
                                                            $errors->has('form.sector_actor')
                                                            ])
                                                            >
                                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                                            @foreach(collect([]) as $key => $value)
                                                            <option value="{{ $key }}"
                                                                wire:key='sector-actor-{{ $key }}'>
                                                                {{ $value }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error :messages="$errors->get('form.sector_actor')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="sector_productivo">{{ __('Seleccione el sector
                                                        productivo:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="sector_productivo"
                                                            wire:model.live="form.sector_productivo"
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' =>
                                                            $errors->has('form.sector_productivo')
                                                            ])
                                                            >
                                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                                            @foreach(collect([]) as $key => $value)
                                                            <option value="{{ $key }}"
                                                                wire:key='sector-actor-{{ $key }}'>
                                                                {{ $value }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error
                                                            :messages="$errors->get('form.sector_productivo')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div> --}}



                                                <div class="sm:col-span-3">
                                                    <x-input-label for="espera_de_alianza">{{ __('¿Qué se espera de esta
                                                        alianza?') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="espera_de_alianza" id="espera_de_alianza"
                                                            wire:model="form.espera_de_alianza"
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' =>
                                                            $errors->has('form.espera_de_alianza')
                                                            ])
                                                            >
                                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                                            @foreach(collect(["1" => "Costshare", "2" => "Leverage", "3"
                                                            => "Ambas"]) as $key => $value)
                                                            <option value="{{ $key }}"
                                                                wire:key='esperar-alianza-{{ $key }}'>
                                                                {{ $value }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error
                                                            :messages="$errors->get('form.espera_de_alianza')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="aporte_espera_alianza">{{ __('¿Qué tipo de
                                                        aporte se espera de esta alianza?') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="aporte_espera_alianza" id="aporte_espera_alianza"
                                                            wire:model="form.aporte_espera_alianza"
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' =>
                                                            $errors->has('form.aporte_espera_alianza')
                                                            ])
                                                            >
                                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                                            @foreach(collect(["1" => "En efectivo", "2" => "En especie",
                                                            "3" => "Ambas"]) as $key => $value)
                                                            <option value="{{ $key }}"
                                                                wire:key='esperar-alianza-{{ $key }}'>
                                                                {{ $value }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error
                                                            :messages="$errors->get('form.aporte_espera_alianza')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>


                                                <div class="col-span-full"
                                                    x-show="$wire.aporte_espera_alianza == 1">
                                                    <x-input-label for="monto_esperado">{{ __('Especifique el monto
                                                        (USD)') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.monto_esperado"
                                                            id="monto_esperado" name="monto_esperado" type="number"
                                                            step="0.01"
                                                            disabled="{{ $readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.monto_esperado')])
                                                            />
                                                            <x-input-error
                                                                :messages="$errors->get('form.monto_esperado')"
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
                                        <p class="mt-1 text-sm leading-6 text-gray-600">Impacto y Resultados</p>
                                    </div>

                                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                                        <div class="px-4 py-6 sm:p-8">
                                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="impacto_pontencial">{{ __('Escriba la cantidad
                                                        del impacto potencial:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <x-text-input wire:model="form.impacto_pontencial"
                                                            id="impacto_pontencial" name="impacto_pontencial"
                                                            type="number" step="0.01" max="100" min="0"
                                                            disabled="{{ $readonly ? 'disabled' : '' }}"
                                                            @class([ 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'block w-full mt-1','border-2 border-red-500' =>
                                                            $errors->has('form.impacto_pontencial')])
                                                            />
                                                            <small>En porcentaje (%)</small>
                                                            <x-input-error
                                                                :messages="$errors->get('form.impacto_pontencial')"
                                                                class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                                <div class="col-span-full">
                                                    <x-input-label for="tipo_impacto_potencial">{{ __('Escriba el tipo
                                                        del impacto potencial:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <textarea name="tipo_impacto_potencial"
                                                            id="tipo_impacto_potencial" {{ $readonly ? 'disabled' : '' }}
                                                            wire:model="form.tipo_impacto_potencial" rows="3"
                                                            @class([
                                                                'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                                                'border-0 border-slate-300'=> $errors->missing('form.tipo_impacto_potencial'),
                                                                'border-2 border-red-500' => $errors->has('form.tipo_impacto_potencial'),
                                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $readonly,
                                                            ])
                                                            @error('form.tipo_impacto_potencial')
                                                                aria-invalid="true"
                                                                aria-description="{{ $message }}"
                                                            @enderror
                                                            ></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-span-full">
                                                    <x-input-label for="resultados_esperados">{{ __('Escriba los
                                                        resultados esperados:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <textarea name="resultados_esperados" id="resultados_esperados"
                                                            {{ $readonly ? 'disabled' : '' }}
                                                            wire:model="form.resultados_esperados" rows="3"
                                                            @class([
                                                                'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                                                'border-0 border-slate-300'=> $errors->missing('form.resultados_esperados'),
                                                                'border-2 border-red-500' => $errors->has('form.resultados_esperados'),
                                                                'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $readonly,
                                                            ])
                                                            @error('form.resultados_esperados')
                                                                aria-invalid="true"
                                                                aria-description="{{ $message }}"
                                                            @enderror
                                                            ></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                                    <div class="px-4 sm:px-0">
                                        <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 5</h2>
                                        <p class="mt-1 text-sm leading-6 text-gray-600">Prioridad y Tiempos</p>
                                    </div>

                                    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                                        <div class="px-4 py-6 sm:p-8">
                                            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                                <div class="sm:col-span-3">
                                                    <x-input-label for="anio_fiscal_firma">{{ __('Seleccione el año
                                                        fiscal aproximado para firma:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="anio_fiscal_firma"
                                                            wire:model="form.anio_fiscal_firma"
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' =>
                                                            $errors->has('form.anio_fiscal_firma')
                                                            ])
                                                            >
                                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                                            @php
                                                            $currentYear = now()->year;
                                                            $years = range($currentYear, $currentYear + 5);
                                                            @endphp

                                                            @foreach($years as $year)
                                                            <option value="{{ $year }}"
                                                                wire:key='anio-fiscal-{{ $sector->id }}'>FY{{
                                                                substr($year, -2) }}</option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error
                                                            :messages="$errors->get('form.anio_fiscal_firma')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>


                                                <div class="sm:col-span-3">
                                                    <x-input-label for="trimestre_aproximado_firma">{{ __('Seleccione el
                                                        trimestre aproximado para firma:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <select name="perfiles" id="trimestre_aproximado_firma"
                                                            wire:model="form.trimestre_aproximado_firma"
                                                            @class([ 'block w-full rounded-md sm:text-sm sm:leading-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                                            , 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none'=>
                                                            $readonly,
                                                            'border-2 border-red-500' =>
                                                            $errors->has('form.trimestre_aproximado_firma')
                                                            ])
                                                            >
                                                            <option value="">{{ __('Seleccione una opción') }}</option>
                                                            @foreach(collect(['1' => 'Q1', '2' => 'Q2', '3' => 'Q3', '4'
                                                            => 'Q4']) as $key => $value)
                                                            <option value="{{ $key }}"
                                                                wire:key='anio-fiscal-firma-{{ $value }}'>{{ $value }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error
                                                            :messages="$errors->get('form.trimestre_aproximado_firma')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>


                                                <div class="col-span-full">

                                                    <x-input-label for="proximos_pasos">{{ __('Escriba los proximos
                                                        pasos:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <textarea name="proximos_pasos" id="proximos_pasos" {{ $readonly ? 'disabled' : '' }}
                                                        wire:model="form.proximos_pasos" rows="3"
                                                        @class([
                                                            'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                                            'border-0 border-slate-300'=> $errors->missing('form.proximos_pasos'),
                                                            'border-2 border-red-500' => $errors->has('form.proximos_pasos'),
                                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $readonly,
                                                        ])
                                                        @error('form.proximos_pasos')
                                                            aria-invalid="true"
                                                            aria-description="{{ $message }}"
                                                        @enderror
                                                        ></textarea>

                                                        <x-input-error :messages="$errors->get('form.proximos_pasos')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>
                                                <div class="col-span-full">

                                                    <x-input-label for="observaciones">{{ __('Observaciones:') }}
                                                        <x-required-label />
                                                    </x-input-label>
                                                    <div class="mt-2">
                                                        <textarea name="observaciones" id="observaciones" {{ $readonly ? 'disabled' : '' }}
                                                        wire:model="form.observaciones" rows="3"
                                                        @class([
                                                            'block w-full rounded-md  py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                                                            'border-0 border-slate-300'=> $errors->missing('form.observaciones'),
                                                            'border-2 border-red-500' => $errors->has('form.observaciones'),
                                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none' => $readonly,
                                                        ])
                                                        @error('form.observaciones')
                                                            aria-invalid="true"
                                                            aria-description="{{ $message }}"
                                                        @enderror
                                                        ></textarea>

                                                        <x-input-error :messages="$errors->get('form.observaciones')"
                                                            class="mt-2" aria-live="assertive" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div
                                            class="flex items-center justify-end px-4 py-4 border-t gap-x-6 border-gray-900/10 sm:px-8">
                                            <button type="submit" @disabled($readonly)
                                                class="relative w-full px-8 py-3 font-medium text-white bg-blue-500 rounded-lg disabled:cursor-not-allowed disabled:opacity-75">
                                                {{ $saveLabel }}

                                                <div wire:loading.flex wire:target="save"
                                                    class="absolute top-0 bottom-0 right-0 flex items-center pr-4">
                                                    <svg class="w-5 h-5 text-white animate-spin"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                            stroke="currentColor" stroke-width="4"></circle>
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
                    </div>
                    <div x-show="tab === 'historial'">
                        <!-- Content for Historial tab -->
                        tab historial
                    </div>
                </div>
            </div>
        </div>
    </div>
