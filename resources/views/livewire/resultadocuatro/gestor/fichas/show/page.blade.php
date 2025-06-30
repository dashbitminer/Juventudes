<x-slot:header>
    <h2 class="flex gap-2 text-xl font-semibold leading-tight text-gray-800">
        Resultado 4: {{ __('Fichas') }}
    </h2>
    <small>{{ $proyecto->nombre }} - {{ $pais->nombre }} - {{ $cohorte->nombre }}</small>
    </x-slot>

    <div>
        <div class="px-6 py-6 bg-white rounded">
            <h3 class="text-lg font-bold tracking-tight text-gray-900">Participante: {{ $participante->full_name }}</h3>
            <div class="mx-auto max-w-7xl lg:flex lg:gap-x-16 lg:px-8" x-data="fichas">
                <h1 class="sr-only">Fichas</h1>

                <aside
                    class="flex py-4 overflow-x-auto border-b border-gray-900/5 lg:block lg:w-64 lg:flex-none lg:border-0 lg:py-20">
                    <nav class="flex-none px-4 sm:px-6 lg:px-0">
                        <ul role="list" class="flex gap-x-3 gap-y-1 whitespace-nowrap lg:flex-col">
                            <li>
                                <a href="#" x-on:click="toggle(), voluntariado = true"
                                    :class="voluntariado ? 'flex py-2 pl-2 pr-3 font-semibold text-indigo-600 rounded-md group gap-x-3 bg-gray-50 text-sm/6' : 'flex py-2 pl-2 pr-3 font-semibold text-gray-700 rounded-md group gap-x-3 text-sm/6 hover:bg-gray-50 hover:text-indigo-600'">
                                    <x-icon.fichas />
                                    Ficha de Voluntariado ({{ $voluntariados }})
                                </a>
                            </li>
                            <li>
                                <a href="#" x-on:click="toggle(), empleabilidad = true"
                                :class="empleabilidad ? 'flex py-2 pl-2 pr-3 font-semibold text-indigo-600 rounded-md group gap-x-3 bg-gray-50 text-sm/6' : 'flex py-2 pl-2 pr-3 font-semibold text-gray-700 rounded-md group gap-x-3 text-sm/6 hover:bg-gray-50 hover:text-indigo-600'">
                                    <x-icon.fichas />
                                    Practica para empleabilidad ({{ $empleabilidades }})
                                </a>
                            </li>
                            <li>
                                <a href="#" x-on:click="toggle(), empleo = true"
                                :class="empleo ? 'flex py-2 pl-2 pr-3 font-semibold text-indigo-600 rounded-md group gap-x-3 bg-gray-50 text-sm/6' : 'flex py-2 pl-2 pr-3 font-semibold text-gray-700 rounded-md group gap-x-3 text-sm/6 hover:bg-gray-50 hover:text-indigo-600'">
                                    <x-icon.fichas />
                                    Ficha de empleo ({{ $empleos }})
                                </a>
                            </li>
                            <li>
                                <a href="#" x-on:click="toggle(), formacion = true"
                                :class="formacion ? 'flex py-2 pl-2 pr-3 font-semibold text-indigo-600 rounded-md group gap-x-3 bg-gray-50 text-sm/6' : 'flex py-2 pl-2 pr-3 font-semibold text-gray-700 rounded-md group gap-x-3 text-sm/6 hover:bg-gray-50 hover:text-indigo-600'">
                                    <x-icon.fichas />
                                    Ficha de formación ({{ $formaciones }})
                                </a>
                            </li>
                            <li>
                                <a href="#" x-on:click="toggle(), emprendimiento = true"
                                :class="emprendimiento ? 'flex py-2 pl-2 pr-3 font-semibold text-indigo-600 rounded-md group gap-x-3 bg-gray-50 text-sm/6' : 'flex py-2 pl-2 pr-3 font-semibold text-gray-700 rounded-md group gap-x-3 text-sm/6 hover:bg-gray-50 hover:text-indigo-600'">
                                    <x-icon.fichas />
                                    Ficha de emprendimiento ({{ $emprendimientos }})
                                </a>
                            </li>
                            <li>
                                <a href="#" x-on:click="toggle(), servicio = true"
                                :class="servicio ? 'flex py-2 pl-2 pr-3 font-semibold text-indigo-600 rounded-md group gap-x-3 bg-gray-50 text-sm/6' : 'flex py-2 pl-2 pr-3 font-semibold text-gray-700 rounded-md group gap-x-3 text-sm/6 hover:bg-gray-50 hover:text-indigo-600'">
                                    <x-icon.fichas />
                                    Aprendizaje de servicio ({{ $servicios }})
                                </a>
                            </li>
                        </ul>
                    </nav>
                </aside>

                <main class="px-4 py-6 sm:px-6 lg:flex-auto lg:px-0 lg:py-20">
                    <div class="max-w-2xl mx-auto space-y-16 sm:space-y-20 lg:mx-0 lg:max-w-none" x-show="voluntariado">
                        <livewire:resultadocuatro.gestor.fichas.show.voluntariados :$pais :$proyecto :$cohorte :$participante />
                    </div>

                    <div class="max-w-2xl mx-auto space-y-16 sm:space-y-20 lg:mx-0 lg:max-w-none" x-show="empleabilidad">
                        <livewire:resultadocuatro.gestor.fichas.show.empleabilidad :$pais :$proyecto :$cohorte :$participante />
                    </div>

                    <div class="max-w-2xl mx-auto space-y-16 sm:space-y-20 lg:mx-0 lg:max-w-none" x-show="empleo">
                        <livewire:resultadocuatro.gestor.fichas.show.empleos :$pais :$proyecto :$cohorte :$participante />
                    </div>

                    <div class="max-w-2xl mx-auto space-y-16 sm:space-y-20 lg:mx-0 lg:max-w-none" x-show="formacion">
                        <livewire:resultadocuatro.gestor.fichas.show.formaciones :$pais :$proyecto :$cohorte :$participante />
                    </div>

                    <div class="max-w-2xl mx-auto space-y-16 sm:space-y-20 lg:mx-0 lg:max-w-none" x-show="emprendimiento">
                        <livewire:resultadocuatro.gestor.fichas.show.emprendimiento :$pais :$proyecto :$cohorte :$participante />
                    </div>

                    <div class="max-w-2xl mx-auto space-y-16 sm:space-y-20 lg:mx-0 lg:max-w-none" x-show="servicio">
                        <livewire:resultadocuatro.gestor.fichas.show.servicio :$pais :$proyecto :$cohorte :$participante />
                    </div>
                </main>
            </div>
        </div>
    </div>
    @script
    <script>
        Alpine.data('fichas', () => ({
            voluntariado: true,
            empleabilidad: false,
            empleo: false,
            formacion: false,
            emprendimiento: false,
            servicio: false,

            toggle() {
                this.voluntariado = false;
                this.empleabilidad = false;
                this.empleo = false;
                this.formacion = false;
                this.emprendimiento = false;
                this.servicio = false;
            },
        }));
    </script>
    @endscript
