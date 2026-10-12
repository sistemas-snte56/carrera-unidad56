<div class="min-h-screen bg-gray-50 flex flex-col justify-between">
    {{-- HEADER INSTITUCIONAL --}}
    <header>
        <div class="bg-[#9d2449] flex items-center h-[80px] md:h-[90px]">
            <div class="bg-white flex items-center px-4 self-stretch">
                <img src="{{ asset('images/logosnte56@4x-8.png') }}" alt="SNTE Sección 56 Veracruz" class="h-14 md:h-16 w-auto">
            </div>
            <img src="{{ asset('images/division@4x-8.png') }}" alt="" class="h-[80px] md:h-[90px] w-auto flex-shrink-0">
            <div class="flex-1"></div>
            <div class="hidden md:flex items-center px-6 flex-shrink-0">
                <img src="{{ asset('images/logounidad@4x-8.png') }}" alt="La Unidad - Nuestra Fortaleza" class="h-14 w-auto">
            </div>
        </div>
        <div class="bg-[#f18c21] h-3"></div>
    </header>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="max-w-4xl mx-auto px-4 py-16 w-full flex-grow flex items-center justify-center">
        <div class="bg-white border border-[#1E2D45]/20 rounded-2xl p-8 md:p-12 shadow-xl text-center w-full">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-emerald-100 text-emerald-600 mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 uppercase tracking-tight mb-3">
                1ra Carrera Atlética del Educador Físico
            </h1>
            
            <p class="text-base font-semibold text-[#9d2449] uppercase tracking-widest mb-6">
                El periodo de registro ha concluido
            </p>

            <p class="text-gray-600 max-w-xl mx-auto mb-8 text-base">
                Agradecemos la entusiasta participación de todos los compañeros docentes. El sistema de registro en línea se encuentra cerrado formalmente.
            </p>

            <div class="flex justify-center">
                <a href="https://www.snte56.org.mx/" 
                    class="inline-flex items-center justify-center px-8 py-4 bg-[#f18c21] hover:bg-[#d97a19] text-white text-base font-bold uppercase tracking-wider rounded-xl shadow-md transition-colors">
                    Ir al sitio principal
                </a>
            </div>
        </div>
    </main>

    {{-- FOOTER INSTITUCIONAL --}}
    <footer class="bg-[#9d2449] mt-12">
        <div class="bg-[#f18c21] h-3"></div>
        <div class="py-4 px-6 text-center">
            <p class="text-white text-sm">
                Sindicato Nacional de Trabajadores de la Educación &mdash; Sección 56 Veracruz
            </p>
            <p class="text-white/70 text-xs mt-1">
                &copy; {{ date('Y') }} Todos los derechos reservados
            </p>
        </div>
    </footer>
</div>