<x-slot:header>
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Sesiones - Titulos') }}
    </h2>
</x-slot>

<div class="overflow-hidden py-6 bg-white shadow-sm sm:rounded-lg">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Titulo de Sesiones</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Lista de todos las sesiones, titulos y niveles.</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            </div>
        </div>

        <div class="flex pt-6 min-h-full">
            <div class="flex flex-col pt-3 w-48">
                <div class="flex overflow-y-auto flex-col gap-y-5 px-6 grow">
                    <nav class="flex flex-col flex-1">
                        <ul role="list" class="flex flex-col flex-1 gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    <li>
                                        <!-- Current: "bg-gray-50 text-indigo-600", Default: "text-gray-700 hover:text-indigo-600 hover:bg-gray-50" -->
                                        <a href="{{ route('admin.admin.sesiones') }}"
                                            class="flex gap-x-3 p-2 font-semibold text-gray-700 rounded-md group text-sm/6 hover:bg-gray-50 hover:text-indigo-600">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                            </svg>
                                            Sesiones
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.admin.sesiones.titulos') }}"
                                            class="flex gap-x-3 p-2 font-semibold text-indigo-600 bg-gray-50 rounded-md group text-sm/6">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-article">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                <path d="M7 8h10" />
                                                <path d="M7 12h10" />
                                                <path d="M7 16h10" />
                                            </svg>
                                            Titulos
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.admin.sesiones.actividad') }}" title="Actividad"
                                            class="flex gap-x-3 p-2 font-semibold text-gray-700 rounded-md group text-sm/6 hover:bg-gray-50 hover:text-indigo-600">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-box-multiple-1">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M7 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                                <path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                                <path d="M14 14v-8l-2 2" />
                                            </svg>
                                            Nivel 1
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.admin.sesiones.subactividad') }}" title="Subactividad"
                                            class="flex gap-x-3 p-2 font-semibold text-gray-700 rounded-md group text-sm/6 hover:bg-gray-50 hover:text-indigo-600">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-box-multiple-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M7 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                                <path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                                <path d="M12 8a2 2 0 1 1 4 0c0 .591 -.417 1.318 -.816 1.858l-3.184 4.143l4 0" />
                                            </svg>
                                            Nivel 2
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.admin.sesiones.modulo') }}" title="Modulo"
                                            class="flex gap-x-3 p-2 font-semibold text-gray-700 rounded-md group text-sm/6 hover:bg-gray-50 hover:text-indigo-600">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-box-multiple-3">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M7 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                                <path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                                <path d="M14 10a2 2 0 1 0 -2 -2" />
                                                <path d="M12 12a2 2 0 1 0 2 -2" />
                                            </svg>
                                            Nivel 3
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.admin.sesiones.submodulo') }}"  title="Submodulo"
                                            class="flex gap-x-3 p-2 font-semibold text-gray-700 rounded-md group text-sm/6 hover:bg-gray-50 hover:text-indigo-600">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-box-multiple-4">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M7 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                                                <path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
                                                <path d="M15 14v-8l-4 6h5" />
                                            </svg>
                                            Nivel 4
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="flex flex-col flex-1">
                <main class="flex-1 py-5 pb-8">
                    <livewire:admin.sesiones.titulo.table>
                </main>
            </div>

        </div>
    </div>
</div>
