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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1:wght@100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-beige text-base text-custom-gray min-h-screen flex flex-col">
        @include('components.welcome-header')

        <main class="flex-grow flex justify-center items-start pt-20 px-4">
            <div class="bg-white max-w-md h-[50vh] overflow-hidden shadow-md rounded-xl flex flex-col w-[362px] ">
                <div class="px-6 py-4 overflow-y-auto">
                    {{ $slot }}
                </div>
            </div>
        </main>

        @include('components.my-footer')
    </body>
</html>
