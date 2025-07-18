<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Resultado 4: {{ $titulo }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
</x-slot>
<div>
    <form >
        <div x-data="form" class="space-y-10 divide-y divide-gray-900/10">


            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 1</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Datos generales del participante</p>
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
                            <div class="col-span-full">
                                <x-input-label for="form.medio_vida_id">
                                    {{ __('¿Cómo accedió al medio de vida?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.medio_vida_id"
                                        wire:model='form.medio_vida_id'
                                        disabled="disabled"
                                        id="form.medio_vida_id"
                                        :options="$medios_vida" selected="Seleccione una opción"
                                        @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.medio_vida_id')]) />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 pt-10 gap-x-8 gap-y-8 md:grid-cols-3">
                <div class="px-4 sm:px-0">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">PARTE 2</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">EMPRENDIMIENTOS</p>
                </div>
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                            <div class="sm:col-span-3">
                                <x-input-label for="form.nombre">
                                    {{ __('Nombre de emprendimiento') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.nombre" id="form.nombre"
                                        name="form.nombre" type="text" disabled="disabled"
                                        @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        'block text-sm w-full mt-1','border-2 border-red-500' => $errors->has('form.nombre')
                                        ]) />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.rubro_emprendimiento_id">
                                    {{ __('Seleccione el Rubro del emprendimiento') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.rubro_emprendimiento_id"
                                        wire:model='form.rubro_emprendimiento_id'
                                        disabled="disabled"
                                        id="form.rubro_emprendimiento_id"
                                        :options="$rubros" selected="Seleccione una opción"
                                        @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.rubro_emprendimiento_id')]) />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.fecha_inicio_emprendimiento">
                                    {{ __('Fecha de inicio del emprendimiento') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.fecha_inicio_emprendimiento" id="form.fecha_inicio_emprendimiento"
                                        name="form.fecha_inicio_emprendimiento" type="date" disabled="disabled"
                                        min="{{ $form->minDate }}" max="{{ $form->maxDate }}"
                                        @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        'block text-sm w-full mt-1','border-2 border-red-500' => $errors->has('form.fecha_inicio_emprendimiento')
                                        ]) />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.etapa_emprendimiento_id">
                                    {{ __('Seleccione la Etapa del emprendimiento') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.etapa_emprendimiento_id"
                                        wire:model='form.etapa_emprendimiento_id'
                                        disabled="disabled"
                                        id="form.etapa_emprendimiento_id"
                                        :options="$etapas" selected="Seleccione una opción"
                                        @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.etapa_emprendimiento_id')]) />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.tiene_capital_semilla">
                                    {{ __('¿Ha recibido capital semilla?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.tiene_capital_semilla"
                                        wire:model='form.tiene_capital_semilla'
                                        disabled="disabled"
                                        id="form.tiene_capital_semilla"
                                        :options="$tiene_capital_semilla"
                                        selected="Seleccione una opción"
                                        x-on:change="changeTieneCapitalSemilla"
                                        @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.tiene_capital_semilla')]) />
                                </div>
                            </div>

                            <div class="sm:col-span-3" x-show="tiene_capital_semilla">
                                <x-input-label for="form.capital_semilla_id">
                                    {{ __('¿De quién?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.capital_semilla_id"
                                        wire:model='form.capital_semilla_id'
                                        disabled="disabled"
                                        id="form.capital_semilla_id"
                                        :options="$capital_semillas"
                                        selected="Seleccione una opción"
                                        x-on:change="changeCapitalSemilla"
                                        @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.capital_semilla_id')]) />
                                </div>
                            </div>

                            <div class="sm:col-span-3" x-show="tiene_capital_semilla">
                                <div x-show="capital_semilla_otros">
                                    <x-input-label for="form.capital_semilla_otros">
                                        {{ __('Especifique:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input wire:model="form.capital_semilla_otros" id="form.capital_semilla_otros"
                                                      disabled="disabled"
                                            name="form.capital_semilla_otros" type="text" disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                            @class([
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                            'block text-sm w-full mt-1','border-2 border-red-500' => $errors->has('form.capital_semilla_otros')
                                            ]) />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3" x-show="tiene_capital_semilla">
                                <x-input-label for="form.monto_local">
                                    {{ __('Escriba el monto de capital semilla recibido (moneda local)') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.monto_local" id="form.monto_local"
                                        name="form.monto_local" type="number" min="0" step="0.01"
                                        disabled="{{ $form->readonly ? 'disabled' : '' }}"
                                        @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        'block text-sm w-full mt-1','border-2 border-red-500' => $errors->has('form.monto_local')
                                        ]) />
                                </div>
                            </div>

                            <div class="sm:col-span-3" x-show="tiene_capital_semilla">
                                <x-input-label for="form.monto_dolar">
                                    {{ __('Escriba el monto de capital semilla recibido (Dólares)') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-text-input wire:model="form.monto_dolar" id="form.monto_dolar"
                                        name="form.monto_dolar" type="number" min="0" step="0.01"
                                        disabled="disabled"
                                        @class([
                                        'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        'block text-sm w-full mt-1','border-2 border-red-500' => $errors->has('form.monto_dolar')
                                        ]) />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.ingresos_promedio_id">
                                    {{ __('Los ingresos promedios generados por el emprendimiento son:') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.ingresos_promedio_id"
                                        wire:model='form.ingresos_promedio_id'
                                        disabled="disabled"
                                        id="form.ingresos_promedio_id"
                                        :options="$ingresos_promedios"
                                        selected="Seleccione una opción"
                                        @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.ingresos_promedio_id')]) />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.tiene_red_emprendimiento">
                                    {{ __('¿Forma parte de una red de emprendedores?') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <x-forms.single-select name="form.tiene_red_emprendimiento"
                                        wire:model='form.tiene_red_emprendimiento'
                                        disabled="disabled"
                                        id="form.tiene_red_emprendimiento"
                                        :options="$tiene_red_emprendimiento"
                                        selected="Seleccione una opción"
                                        x-on:change="changeTieneRedEmprendimiento"
                                        @class(['disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                        'block w-full mt-1','border-2 border-red-500' =>
                                        $errors->has('form.tiene_red_emprendimiento')]) />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <div x-show="red_emprendimiento_otros">
                                    <x-input-label for="form.red_empredimiento">
                                        {{ __('Especifique:') }}
                                        <x-required-label />
                                    </x-input-label>
                                    <div class="mt-2">
                                        <x-text-input disabled="disabled" wire:model="form.red_empredimiento" id="form.red_empredimiento"
                                            name="form.red_empredimiento" type="text" disabled="disabled"
                                            @class([
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                            'block text-sm w-full mt-1','border-2 border-red-500' => $errors->has('form.red_empredimiento')
                                            ]) />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="form.emprendimiento_medio_verificaciones">
                                    {{ __('Seleccione los Medios de verificación del enlace a medio de vida') }}
                                    <x-required-label />
                                </x-input-label>
                                <div class="mt-2">
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-1">
                                        @foreach ($medios_verificacion as $key => $value)
                                        <div class="relative flex gap-x-3">
                                            <div class="flex items-center h-6">
                                                <x-text-input type="checkbox"
                                                              disabled="disabled"
                                                    wire:key='medio_verificacion{{$key}}'
                                                    wire:model="form.emprendimiento_medio_verificaciones"
                                                    value="{{ $key}}"
                                                    x-on:change="medioVerificacion"
                                                    data-value="{{ $value }}"
                                                    class="w-5 h-5 text-indigo-600 border-gray-400 focus:ring-indigo-600"
                                                    id="medio_verificacion-{{$key}}"
                                                    name="form.emprendimiento_medio_verificaciones"
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
                                            name="form.medio_verificacion_otros" type="text" disabled="disabled"
                                            @class([
                                            'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none',
                                            'block w-full mt-1','border-2 border-red-500' => $errors->has('form.medio_verificacion_otros')
                                            ]) />

                                    </div>
                                </div>
                            </div>

                            <div class="col-span-full">
                                @if ($form->medio_verificacion_upload)
                                    <div class="mt-2">
                                        <a href="{{ Storage::disk('s3')->temporaryUrl($form->medio_verificacion_upload, \Carbon\Carbon::now()->addHour()) }}"
                                            target="_blank" class="text-blue-500 underline">
                                            {{ __('Ver archivo de medio de verificación') }}
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="col-span-full">
                                <x-input-label for="form.informacion_adicional">
                                    {{ __('Información adicional que desee mencionar sobre el emprendimiento de la o el joven:') }}
                                </x-input-label>
                                <div class="mt-2">
                                    <textarea wire:model="form.informacion_adicional"
                                              disabled="disabled"
                                        id="form.informacion_adicional" name="form.informacion_adicional" rows="3"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6
                                        disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none">
                                    </textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <livewire:resultadocuatro.gestor.visualizador.forms.comentario :$pais :$proyecto :model="$ficha_emprendimiento"  />
    <livewire:resultadocuatro.gestor.visualizador.estado-registro.index :model="$ficha_emprendimiento" />
</div>

@script
<script>
    Alpine.data('form', () => ({
        tiene_capital_semilla: false,
        capital_semilla_otros: false,
        red_emprendimiento_otros: false,
        medio_verificacion_otros: false,

        changeTieneCapitalSemilla(event) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            this.tiene_capital_semilla = selectedOption.text.includes("Si");
        },

        changeCapitalSemilla(event) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            this.capital_semilla_otros = selectedOption.text.includes("Otros");

            if (this.capital_semilla_otros) {
                setTimeout(() => {
                    $el.querySelector('[name="form.capital_semilla_otros"]').focus();
                }, 200);
            }
        },

        changeTieneRedEmprendimiento(event) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            this.red_emprendimiento_otros = selectedOption.text.includes("Si");

            if (this.red_emprendimiento_otros) {
                setTimeout(() => {
                    $el.querySelector('[name="form.red_empredimiento"]').focus();
                }, 200);
            }
        },

        medioVerificacion(event) {
            const options = $el.querySelectorAll("[name='form.emprendimiento_medio_verificaciones']");

            options.forEach(element => {
                const key = element.value;
                const value = element.dataset.value;
                const isChecked = element.checked;

                this.medio_verificacion_otros = value.includes("Otros") && isChecked;
            });
        },

        init() {
            if ($wire.form.tiene_capital_semilla == 1) {
                this.tiene_capital_semilla = true;
            }

            if ($wire.form.tiene_red_emprendimiento == 1) {
                this.red_emprendimiento_otros = true;
            }

            if ($wire.form.capital_semilla_id) {
                const capitalSemillaDropdown = $el.querySelector('select[id="form.capital_semilla_id"]');

                if (capitalSemillaDropdown) {
                    const option = capitalSemillaDropdown.querySelector(`option[value="${$wire.form.capital_semilla_id}"]`);

                    if (option.text.includes("Otros")) {
                        this.capital_semilla_otros = true;
                    }
                }
            }

            if ($wire.form.emprendimiento_medio_verificaciones) {
                const checkboxes = $el.querySelector(`[name="form.emprendimiento_medio_verificaciones"][value=""]`);

                for (const id of Object.values($wire.form.emprendimiento_medio_verificaciones)) {
                    const medioVerificacionCheckbox = $el.querySelector(`[name="form.emprendimiento_medio_verificaciones"][value="${id}"]`);

                    if (medioVerificacionCheckbox.dataset.value.includes("Otros")) {
                        this.medio_verificacion_otros = true;
                    }
                }
            }
        },
    }));
</script>
@endscript
