<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Eduplor - Lead Management</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white text-gray-900">

        <div class="flex flex-col items-center justify-center min-h-screen">
            
            <div class="mb-10">
                <img src="{{ asset('images/eduplor-logo.png') }}" alt="Eduplor Logo" class="w-64 md:w-80 lg:w-96 drop-shadow-sm">
            </div>

            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6">
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-white px-8 py-3 rounded-lg shadow-md text-gray-700 font-medium hover:shadow-lg hover:bg-gray-50 transition-all duration-200 border border-gray-100 text-center min-w-[140px]">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-white px-8 py-3 rounded-lg shadow-md text-gray-700 font-medium hover:shadow-lg hover:bg-gray-50 transition-all duration-200 border border-gray-100 text-center min-w-[140px]">
                        Log In
                    </a>
                    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-white px-8 py-3 rounded-lg shadow-md text-gray-700 font-medium hover:shadow-lg hover:bg-gray-50 transition-all duration-200 border border-gray-100 text-center min-w-[140px]">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
            
        </div>

    </body>
</html>