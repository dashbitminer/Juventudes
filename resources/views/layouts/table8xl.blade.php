<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <script defer src="http://alpine.test/packages/ui/dist/cdn.js"></script> --}}
    {{-- <script defer src="https://unpkg.com/@alpinejs/ui@3.13.3-beta.4/dist/cdn.min.js"></script> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    @fluxStyles
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">



        @if(auth()->user()->hasRole('Admin'))
            <livewire:layout.navigation-admin />
        @elseif(auth()->user()->hasRole('Coordinador'))
            <livewire:layout.navigation-coordinador :cohorte="$cohorte ?? null" :proyecto="$proyecto ?? null" :pais="$pais ?? null"/>
        @else
            <livewire:layout.navigation
                :cohorte="$cohorte ?? null"
                :proyecto="$proyecto ?? null"
                :pais="$pais ?? null"
                :alianza="$alianza ?? null"
            />
            {{-- <livewire:layout.navigation/> --}}
        @endif

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="px-4 py-6 mx-auto max-w-8xl sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <div class="py-12">
            <div class="mx-auto max-w-8xl sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    {{-- <div class="p-6 text-gray-900"> --}}
                        <main>
                            {{ $slot }}
                        </main>
                        {{--
                    </div> --}}
                </div>
            </div>
        </div>

    </div>
    {{-- <script defer src="https://unpkg.com/@alpinejs/ui@3.14.1-beta.0/dist/cdn.min.js"></script> --}}
    @fluxScripts
</body>

</html>
