<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'UniEvent') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800,900&display=swap" rel="stylesheet" />
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='25' fill='%2310b981'/><text x='50%' y='54%' font-family='sans-serif' font-weight='900' font-size='65' fill='white' dominant-baseline='central' text-anchor='middle'>U</text></svg>">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
        
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-400/10 dark:bg-emerald-500/5 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-teal-400/10 dark:bg-teal-500/5 rounded-full blur-[120px] translate-y-1/3 -translate-x-1/4"></div>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white dark:bg-gray-800/90 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-[2rem] border border-gray-100 dark:border-gray-700 z-10">
            {{ $slot }}
        </div>
        
        <a href="/" class="mt-8 text-sm font-bold text-gray-400 hover:text-emerald-500 transition-colors z-10 flex items-center gap-2 group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Volver al inicio
        </a>
    </body>
</html>