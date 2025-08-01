<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Laravel Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100">
    @include('layouts.nav')

    <div class="flex">
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 container mx-auto">
            @yield('content')
            
        </main>
    </div>

    @stack('scripts')
</body>
</html>