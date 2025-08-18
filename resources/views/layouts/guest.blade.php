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

        <main class="flex-grow flex justify-center items-center px-4 py-8">
            @if(request()->routeIs('register'))
                <!-- 新規登録画面：固定高さ + 内部スクロール -->
                <div class="bg-white max-w-md w-full sm:w-[400px] lg:w-[420px] h-[75vh] sm:h-[70vh] lg:h-[65vh] shadow-lg rounded-xl overflow-hidden flex flex-col">
                    <div class="px-6 py-6 sm:px-8 sm:py-8 overflow-y-auto flex-grow">
                        {{ $slot }}
                    </div>
                </div>
            @else
                <!-- ログイン・パスワードリセット画面：コンテンツサイズに応じた高さ -->
                <div class="bg-white max-w-md w-full sm:w-[400px] lg:w-[420px] shadow-lg rounded-xl overflow-hidden">
                    <div class="px-6 py-6 sm:px-8 sm:py-8">
                        {{ $slot }}
                    </div>
                </div>
            @endif
        </main>

        @include('components.my-footer')
    </body>
</html>
