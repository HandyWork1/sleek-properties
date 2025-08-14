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
    <!-- Quill Styles -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet" />

    <!-- Quill Script -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

</head>
<body x-data="{ sidebarExpanded: true, sidebarMobileOpen: false }" class="font-sans antialiased overflow-x-hidden">
    <div class="flex min-h-screen transition-all duration-300 bg-gray-100 dark:bg-gray-900 overflow-x-hidden">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Toast Notifications --}}
        @include('components.toast')


        {{-- Content wrapper --}}
        <div class="flex-1 flex flex-col transition-all duration-300 overflow-x-hidden"
             :class="sidebarExpanded ? 'md:ml-64' : 'md:ml-20'">

            {{-- Topbar --}}
            @include('layouts.topbar')

            <!-- Page Heading -->
            @isset($header)
                <header>
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Main Content --}}
            <main class="flex-1 max-w-7xl sm:px-4 lg:px-6 transition-all duration-300 overflow-x-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    @if (session('toast'))
        <script>
            document.addEventListener('alpine:init', () => {
                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: @json(session('toast'))
                    }));
                }, 50); // Small delay ensures Alpine is ready
            });
        </script>
    @endif


    @if ($errors->any())
        <script>
            document.addEventListener('alpine:init', () => {
                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: 'error',
                            message: @json($errors->first()),
                            timeout: 5000
                        }
                    }));
                }, 50);
            });
        </script>
    @endif



</body>



</html>
