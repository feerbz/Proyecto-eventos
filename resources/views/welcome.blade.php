<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UniEvent | UPIICSA</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='25' fill='%2310b981'/><text x='50%' y='54%' font-family='sans-serif' font-weight='900' font-size='65' fill='white' dominant-baseline='central' text-anchor='middle'>U</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex flex-col relative overflow-x-hidden">
    
    <nav class="w-full p-6 flex justify-between items-center max-w-7xl mx-auto z-10 relative">
        <div class="font-black text-2xl tracking-tighter flex items-center gap-2">
            <span class="text-xs font-bold px-2 py-1 bg-gray-200 dark:bg-gray-800 rounded-md text-gray-500 uppercase tracking-widest hidden sm:inline-block">UPIICSA · IPN</span>
        </div>
        
        @if (Route::has('login'))
            <div class="flex gap-4 items-center">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-bold px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl transition-all shadow-sm">
                        Ir a mi Panel
                    </a>
                @endauth
            </div>
        @endif
    </nav>

    <main class="flex-1 flex flex-col items-center justify-center p-6 z-10 relative mt-[-10vh]">
        <div class="text-center max-w-4xl mx-auto w-full">
            
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800/50 text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-widest mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Sistema Activo
            </div>

            <h1 class="text-[5rem] md:text-[9rem] font-black tracking-tighter mb-12 leading-none">
                Uni<span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-500">Event</span><span class="text-emerald-500">.</span>
            </h1>
            
            @if (!Auth::check())
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-8">
                    <a href="{{ route('login') }}" class="w-full sm:w-64 px-8 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-bold rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all text-center">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="w-full sm:w-64 px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl shadow-lg shadow-emerald-500/30 transition-all active:scale-95 flex items-center justify-center gap-2 group">
                        Crear Cuenta
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                </div>
            @endif
        </div>
    </main>

    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAwIDEwIEwgNDAgMTAgTSAxMCAwIEwgMTAgNDAiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzAwMDAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDUiIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==')] opacity-[0.2] dark:opacity-[0.05] dark:invert"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-400/20 dark:bg-emerald-500/10 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-teal-400/10 dark:bg-teal-500/5 rounded-full blur-[120px] translate-y-1/3 -translate-x-1/4"></div>
    </div>
</body>
</html>