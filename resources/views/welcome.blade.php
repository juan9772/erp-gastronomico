<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ERP Gastronómico - Control Total de Costos</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:500,700,800&display=swap" rel="stylesheet" />
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
            h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
            
            .gradient-bg {
                background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            }
            .text-gradient {
                background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
        </style>
    </head>
    <body class="antialiased bg-gray-50 text-gray-800 selection:bg-blue-500 selection:text-white">
        
        <!-- Navbar -->
        <nav class="absolute top-0 w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-white font-bold text-2xl tracking-tight" style="font-family: 'Outfit', sans-serif;">ERP Gastronómico</span>
                    </div>
                    @if (Route::has('login'))
                        <div class="hidden md:flex items-center space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-white hover:text-blue-100 font-medium transition duration-150">Panel de Control</a>
                            @else
                                <a href="{{ route('login') }}" class="text-white hover:text-blue-100 font-medium transition duration-150">Iniciar Sesión</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-gray-100 hover:scale-105 px-5 py-2 rounded-full font-semibold transition transform duration-200 shadow-lg">Regístrate Gratis</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative overflow-hidden gradient-bg pb-32 pt-40 sm:pt-48 sm:pb-40 lg:pb-48 xl:pb-64 lg:pt-56">
            <div class="absolute inset-x-0 bottom-0 transform-gpu overflow-hidden blur-3xl" aria-hidden="true">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"></div>
            </div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-white tracking-tight mb-8 drop-shadow-sm">
                    Revoluciona la Gestión <br> de tu Restaurante
                </h1>
                <p class="mt-4 text-xl sm:text-2xl text-blue-100 max-w-3xl mx-auto mb-10 font-light leading-relaxed">
                    Controla tus <span class="font-semibold text-white">insumos</span>, arma tus <span class="font-semibold text-white">recetas</span> y calcula automáticamente tus <span class="font-semibold text-white">márgenes de ganancia</span> en tiempo real. Todo en una sola plataforma.
                </p>
                <div class="mt-10 flex justify-center gap-x-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="rounded-full bg-white px-8 py-4 text-lg font-bold text-blue-600 shadow-xl hover:bg-gray-50 hover:scale-105 hover:shadow-2xl transition-all duration-300">
                            Ir a tu Panel
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="rounded-full bg-white px-8 py-4 text-lg font-bold text-blue-600 shadow-xl hover:scale-105 hover:shadow-2xl transition-all duration-300">
                            Comienza Ahora
                        </a>
                        <a href="{{ route('login') }}" class="rounded-full px-8 py-4 text-lg font-semibold text-white border border-white/30 hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
                            Ya tengo cuenta <span aria-hidden="true">→</span>
                        </a>
                    @endauth
                </div>
            </div>
            
            <!-- Diagonal Divider -->
            <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-10">
                <svg class="relative block w-full h-12 md:h-24" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M1200 120L0 16.48V0h1200v120z" class="fill-gray-50"></path>
                </svg>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-24 bg-gray-50 sm:py-32 relative z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <h2 class="text-lg font-semibold text-blue-600 tracking-wide uppercase">Potencia tu Negocio</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl text-gradient">
                        Herramientas diseñadas para rentabilidad
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                        Automatiza el control financiero de tu cocina. Olvídate de los excels desactualizados y los errores humanos.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 lg:gap-8">
                    
                    <!-- Feature 1 -->
                    <div class="relative bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 group">
                        <div class="absolute -top-6 left-8 bg-blue-500 rounded-2xl p-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-2xl font-bold text-gray-900 mb-4 tracking-tight">Gestión de Insumos</h3>
                        <p class="text-gray-600 h-24">Mantén un inventario detallado de tus materias primas. Registra costos unitarios y unidades de medida (kg, lt, u) con facilidad.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 group">
                        <div class="absolute -top-6 left-8 bg-emerald-500 rounded-2xl p-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-2xl font-bold text-gray-900 mb-4 tracking-tight">Escandallos Precisos</h3>
                        <p class="text-gray-600 h-24">Arma tus recetas combinando "N" cantidad de insumos. Conoce el impacto económico exacto de preparar cada plato de tu menú.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 group">
                        <div class="absolute -top-6 left-8 bg-purple-500 rounded-2xl p-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-2xl font-bold text-gray-900 mb-4 tracking-tight">Costos Automáticos</h3>
                        <p class="text-gray-600 h-24">Si el precio de la harina sube un 10%, todos los productos que usen la receta de pan ajustarán su rentabilidad reportada de inmediato.</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
                <div class="flex justify-center space-x-6 md:order-2">
                    <a href="https://github.com/juan9772/erp-gastronomico" target="_blank" class="text-gray-400 hover:text-gray-500 transition-colors">
                        <span class="sr-only">GitHub</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
                <div class="mt-8 md:mt-0 md:order-1">
                    <p class="text-center text-base text-gray-400 font-medium">
                        &copy; {{ date('Y') }} ERP Gastronómico. Desarrollado con 💙 utilizando Laravel y TailwindCSS.
                    </p>
                </div>
            </div>
        </footer>

    </body>
</html>
