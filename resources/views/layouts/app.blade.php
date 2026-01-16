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

        {{-- logo --}}
        <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">

        <!-- chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased relative" x-data="{ sidebarOpen: false }">
        <!-- Sidebar (fixed on the left) -->
        <livewire:layout.sidebar />

         <!-- Main Content Area (push right when sidebar visible) -->
        <div class="min-h-screen bg-gray-50 lg:ml-64 transition-all">
            <livewire:layout.navbar />

            <!-- Page Heading -->
            @if (isset($header))
                <header>
                    <div class="max-w-7xl mx-auto mt-32 lg:mt-16 py-6 px-4 sm:px-6 lg:px-8 md:flex md:items-center md:justify-between">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="px-4 sm:px-6 lg:px-8 pb-6">
                @if (session()->has('success'))
                    <div x-data="{ show: true }" x-show="show"
                        x-init="setTimeout(() => show = false, 4000)"
                        class="fixed top-4 right-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded shadow-lg z-50">
                        {{ session('success') }}
                    </div>
                @endif
        
                @if (session()->has('error'))
                    <div x-data="{ show: true }" x-show="show"
                        x-init="setTimeout(() => show = false, 4000)"
                        class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg z-50">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
