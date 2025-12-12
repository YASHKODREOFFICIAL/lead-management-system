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
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            {{-- TOP NAVIGATION --}}
            @include('layouts.navigation')

            {{-- CUSTOM NAVBAR LINKS (Dashboard + Leads) --}}
            <nav class="bg-white shadow mb-4">
                <div class="max-w-7xl mx-auto px-4 py-3 flex gap-6">

                    <a href="{{ route('dashboard') }}" 
                       class="text-gray-600 hover:text-black font-medium">
                        Dashboard
                    </a>

                    <a href="{{ route('leads.index') }}" 
                       class="text-gray-600 hover:text-black font-medium">
                        Leads
                    </a>

                    @role('Admin')
                        <a href="{{ route('leads.create') }}" 
                           class="text-gray-600 hover:text-black font-medium">
                            + Create Lead
                        </a>
                    @endrole
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')

            </main>
        </div>
    </body>
</html>
