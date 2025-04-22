<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional custom fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite (for JS or additional styles if needed) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="font-family: 'Figtree', sans-serif; background-color: #f8f9fa;">
    <div class="min-vh-100">

        {{-- Only show navigation if the user is authenticated --}}
        @auth
            @include('layouts.navigation')
        @endauth

        <!-- Page Header -->
        @hasSection('header')
            <header class="bg-white shadow-sm border-bottom">
                <div class="container py-4">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="container my-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS Bundle (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
