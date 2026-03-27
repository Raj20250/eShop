<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Shop')</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    @include('layouts.admin.admin-partials.admin-header')

    <main class="grow">
        @yield('content')
    </main>

    @include('layouts.admin.admin-partials.admin-footer')

    @stack('scripts')
</body>
</html>