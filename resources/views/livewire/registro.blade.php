<div class="min-h-screen bg-gray-50 flex flex-col justify-between">

    {{-- ═══════════════ HEADER INSTITUCIONAL ═══════════════ --}}
    <header>
        <div class="bg-[#9d2449] flex items-center h-[80px] md:h-[90px]">
            <div class="bg-white flex items-center px-4 self-stretch">
                <img src="{{ asset('images/logosnte56@4x-8.png') }}" alt="SNTE Sección 56 Veracruz"
                    class="h-14 md:h-16 w-auto">
            </div>

            <img src="{{ asset('images/division@4x-8.png') }}" alt="" class="h-[80px] md:h-[90px] w-auto flex-shrink-0">

            <div class="flex-1"></div>

            <div class="hidden md:flex items-center px-6 flex-shrink-0">
                <img src="{{ asset('images/logounidad@4x-8.png') }}" alt="La Unidad - Nuestra Fortaleza"
                    class="h-14 w-auto">
            </div>
        </div>

        <div class="bg-[#f18c21] h-3"></div>
    </header>

    {{-- ═══════════════ CONTENIDO PRINCIPAL ═══════════════ --}}
    <main class="max-w-6xl mx-auto px-4 py-8 w-full">

        <div class="text-center mb-8">
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 uppercase tracking-tight">
                1ra Carrera Atlética del Educador Físico
            </h1>
            <p class="text-base font-semibold text-[#9d2449] uppercase tracking-widest mt-1">
                Registro de participantes
            </p>
        </div>

        {{-- ═══════════════ MODAL DE ÉXITO ═══════════════ --}}
        @if ($registroExitoso)
            <div x-data="{ open: true }" x-show="open"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100">

                <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-100 transform transition-all relative"
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100">

                    <div class="text-center">
                        <div
                            class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 text-emerald-600 mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        <h3 class="text-2xl font-extrabold text-gray-900 uppercase tracking-tight">
                            ¡Registro Exitoso!
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Tu inscripción se ha completado correctamente en el sistema.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 my-6 bg-gray-50 p-4 rounded-xl border border-gray-100 text-center">
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm">
                            <span class="block text-xs font-bold text-gray-400 uppercase">Folio de Registro</span>
                            <span class="text-xl font-mono font-bold text-gray-800">{{ $folioGenerado }}</span>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm">
                            <span class="block text-xs font-bold text-gray-400 uppercase">Número de Corredor</span>
                            <span class="text-xl font-mono font-bold text-[#9d2449]">{{ $numeroCorredorGenerado }}</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ url('/acuse/' . $acuseTokenGenerado) }}" target="_blank"
                            class="w-full inline-flex items-center justify-center px-6 py-3.5 bg-[#f18c21] hover:bg-[#d97a19] text-white text-base font-bold uppercase tracking-wider rounded-xl shadow-md transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Descargar acuse de registro
                        </a>

                        <button type="button" wire:click="$set('registroExitoso', false)"
                            class="w-full py-2.5 text-sm text-gray-500 hover:text-gray-700 font-semibold uppercase tracking-wider">
                            Cerrar ventana
                        </button>
                    </div>

                </div>
            </div>
        @endif

        {{-- ═══════════════ LAYOUT GRID: FORMULARIO + ASIDE ═══════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- COLUMNA IZQUIERDA: FORMULARIO (2 COLUMNAS) --}}
            <form wire:submit="continuar" class="lg:col-span-2 space-y-6">

                {{-- SECCIÓN: DATOS PERSONALES --}}
                <div class="bg-white border border-[#1E2D45]/20 rounded-xl p-6 shadow-sm">
                    <h2
                        class="text-lg font-bold text-[#9d2449] uppercase tracking-wider mb-6 border-b border-gray-100 pb-2">
                        Datos personales
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label for="nombre"
                                class="block text-sm font-bold text-gray-700 uppercase mb-1.5">Nombre</label>
                            <input type="text" id="nombre" wire:model="nombre"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-base text-gray-800 focus:ring-2 focus:ring-[#9d2449] focus:border-transparent outline-none transition-all">
                            @error('nombre') <span class="text-xs text-red-600 font-semibold mt-1 block">{{ $message
                                }}</span> @enderror
                        </div>

                        <div>
                            <label for="apellido_paterno"
                                class="block text-sm font-bold text-gray-700 uppercase mb-1.5">Apellido paterno</label>
                            <input type="text" id="apellido_paterno" wire:model="apellido_paterno"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-base text-gray-800 focus:ring-2 focus:ring-[#9d2449] focus:border-transparent outline-none transition-all">
                            @error('apellido_paterno') <span class="text-xs text-red-600 font-semibold mt-1 block">{{
                                $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="apellido_materno"
                                class="block text-sm font-bold text-gray-700 uppercase mb-1.5">Apellido materno</label>
                            <input type="text" id="apellido_materno" wire:model="apellido_materno"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-base text-gray-800 focus:ring-2 focus:ring-[#9d2449] focus:border-transparent outline-none transition-all">
                            @error('apellido_materno') <span class="text-xs text-red-600 font-semibold mt-1 block">{{
                                $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="fecha_nacimiento"
                                class="block text-sm font-bold text-gray-700 uppercase mb-1.5">Fecha de
                                nacimiento</label>
                            <input type="date" id="fecha_nacimiento" wire:model="fecha_nacimiento"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-base text-gray-800 focus:ring-2 focus:ring-[#9d2449] focus:border-transparent outline-none transition-all">
                            @error('fecha_nacimiento') <span class="text-xs text-red-600 font-semibold mt-1 block">{{
                                $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="rama"
                                class="block text-sm font-bold text-gray-700 uppercase mb-1.5">Rama</label>
                            <select id="rama" wire:model="rama"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-base text-gray-800 focus:ring-2 focus:ring-[#9d2449] focus:border-transparent outline-none transition-all">
                                <option value="">Seleccione una opción</option>
                                <option value="femenil">Femenil</option>
                                <option value="varonil">Varonil</option>
                            </select>
                            @error('rama') <span class="text-xs text-red-600 font-semibold mt-1 block">{{ $message
                                }}</span> @enderror
                        </div>

                        <div>
                            <label for="distancia"
                                class="block text-sm font-bold text-gray-700 uppercase mb-1.5">Distancia</label>
                            <select id="distancia" wire:model="distancia"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-base text-gray-800 focus:ring-2 focus:ring-[#9d2449] focus:border-transparent outline-none transition-all">
                                <option value="">Seleccione una opción</option>
                                <option value="3K">3 km</option>
                                <option value="5K">5 km</option>
                                <option value="10K">10 km</option>
                            </select>
                            @error('distancia') <span class="text-xs text-red-600 font-semibold mt-1 block">{{ $message
                                }}</span> @enderror
                        </div>

                        <div class="md:col-span-3">
                            <label for="tipo_corredor"
                                class="block text-sm font-bold text-gray-700 uppercase mb-1.5">Tipo de
                                participante</label>
                            <select id="tipo_corredor" wire:model.live="tipo_corredor"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-base text-gray-800 focus:ring-2 focus:ring-[#9d2449] focus:border-transparent outline-none transition-all">
                                <option value="">Seleccione una opción</option>
                                <option value="agremiado">Agremiado</option>
                                <option value="publico">Público en general</option>
                            </select>
                            @error('tipo_corredor') <span class="text-xs text-red-600 font-semibold mt-1 block">{{
                                $message }}</span> @enderror
                        </div>

                        @if ($tipo_corredor === 'agremiado')
                        <div
                            class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-200 mt-2">
                            <div>
                                <label for="region_id"
                                    class="block text-sm font-bold text-gray-700 uppercase mb-1.5">Región</label>
                                <select id="region_id" wire:model.live="region_id"
                                    class="w-full bg-white border border-gray-300 rounded-lg p-3 text-base text-gray-800 focus:ring-2 focus:ring-[#9d2449] focus:border-transparent outline-none transition-all">
                                    <option value="">Seleccione una región</option>
                                    @foreach ($regiones as $region)
                                    <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('region_id') <span class="text-xs text-red-600 font-semibold mt-1 block">{{
                                    $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="delegacion_id"
                                    class="block text-sm font-bold text-gray-700 uppercase mb-1.5">Delegación</label>
                                <select id="delegacion_id" wire:model="delegacion_id"
                                    class="w-full bg-white border border-gray-300 rounded-lg p-3 text-base text-gray-800 focus:ring-2 focus:ring-[#9d2449] focus:border-transparent outline-none transition-all">
                                    <option value="">Seleccione una delegación</option>
                                    @foreach ($delegaciones as $delegacion)
                                    <option value="{{ $delegacion->id }}">{{ $delegacion->delegacion_completa }}</option>
                                    @endforeach
                                </select>
                                @error('delegacion_id') <span class="text-xs text-red-600 font-semibold mt-1 block">{{
                                    $message }}</span> @enderror
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- SECCIÓN: DATOS DE CONTACTO --}}
                <div class="bg-white border border-[#1E2D45]/20 rounded-xl p-6 shadow-sm">
                    <h2
                        class="text-lg font-bold text-[#9d2449] uppercase tracking-wider mb-6 border-b border-gray-100 pb-2">
                        Datos de contacto
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="correo" class="block text-sm font-bold text-gray-700 uppercase mb-1.5">Correo
                                electrónico</label>
                            <input type="email" id="correo" wire:model="correo"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-base text-gray-800 focus:ring-2 focus:ring-[#9d2449] focus:border-transparent outline-none transition-all">
                            @error('correo') <span class="text-xs text-red-600 font-semibold mt-1 block">{{ $message
                                }}</span> @enderror
                        </div>

                        <div>
                            <label for="telefono"
                                class="block text-sm font-bold text-gray-700 uppercase mb-1.5">Teléfono</label>
                            <input type="tel" id="telefono" wire:model="telefono"
                                class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-base text-gray-800 focus:ring-2 focus:ring-[#9d2449] focus:border-transparent outline-none transition-all">
                            @error('telefono') <span class="text-xs text-red-600 font-semibold mt-1 block">{{ $message
                                }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN: DOCUMENTOS --}}
                <div class="bg-white border border-[#1E2D45]/20 rounded-xl p-6 shadow-sm">
                    <h2
                        class="text-lg font-bold text-[#9d2449] uppercase tracking-wider mb-6 border-b border-gray-100 pb-2">
                        Documentos
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="ine" class="block text-sm font-bold text-gray-700 uppercase mb-1.5">INE o
                                credencial de elector</label>
                            <input type="file" id="ine" wire:model="ine" accept=".jpg,.jpeg,.png,.pdf"
                                class="w-full text-xs text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer border border-gray-300 rounded-lg">

                            <div wire:loading wire:target="ine" class="text-xs text-[#f18c21] font-semibold mt-1">
                                Cargando archivo...</div>
                            <p class="text-xs text-gray-400 mt-1">Formatos JPG, PNG o PDF. Máximo 5 MB.</p>
                            @error('ine') <span class="text-xs text-red-600 font-semibold mt-1 block">{{ $message
                                }}</span> @enderror
                        </div>

                        <div>
                            <label for="voucher"
                                class="block text-sm font-bold text-gray-700 uppercase mb-1.5">Comprobante de
                                pago</label>
                            <input type="file" id="voucher" wire:model="voucher" accept=".jpg,.jpeg,.png,.pdf"
                                class="w-full text-xs text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer border border-gray-300 rounded-lg">

                            <div wire:loading wire:target="voucher" class="text-xs text-[#f18c21] font-semibold mt-1">
                                Cargando archivo...</div>
                            <p class="text-xs text-gray-400 mt-1">Formatos JPG, PNG o PDF. Máximo 5 MB.</p>
                            @error('voucher') <span class="text-xs text-red-600 font-semibold mt-1 block">{{ $message
                                }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- BOTÓN DE ENVÍO --}}
                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full py-4 px-6 bg-[#9d2449] hover:bg-[#821d3c] text-white font-bold text-base uppercase tracking-wider rounded-xl shadow-md transition-colors flex justify-center items-center">
                        <span wire:loading.remove wire:target="continuar">Continuar</span>
                        <span wire:loading wire:target="continuar" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Procesando registro...
                        </span>
                    </button>
                </div>

            </form>

            {{-- COLUMNA DERECHA: PANEL LATERAL (1 COLUMNA) --}}
            <aside class="space-y-4 lg:sticky lg:top-8">
                <div class="bg-white border border-[#1E2D45]/20 rounded-xl p-5 shadow-sm text-center">
                    <img src="{{ asset('images/cartel-carrera.jpg') }}" alt="Cartel oficial de la carrera"
                        class="w-full h-auto rounded-lg shadow-sm mb-5">

                    <div class="space-y-3">
                        <a href="{{ asset('docs/carrera_atletica_educador_fisico_2026.pdf') }}" target="_blank"
                            class="w-full inline-block py-3 px-4 bg-[#f18c21] hover:bg-[#d97a19] text-white text-xs font-bold uppercase tracking-wider rounded-lg transition-colors shadow-sm">
                            Convocatoria
                        </a>


                        {{-- <p>¿Ya te registraste?</p>
                        <a href="{{ asset('docs/formato-voucher.pdf') }}" target="_blank"
                            class="w-full inline-block py-3 px-4 bg-[#f18c21] hover:bg-[#d97a19] text-white text-xs font-bold uppercase tracking-wider rounded-lg transition-colors shadow-sm">
                            Descarga tu voucher
                        </a> --}}
                    </div>
                </div>

                <div class="bg-white border border-[#1E2D45]/20 rounded-xl p-5 shadow-sm space-y-4">

                    {{-- FECHA --}}
                    <div class="flex items-center space-x-3">
                        <svg class="w-7 h-4 text-[#9d2449] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <span class="block text-sm font-bold text-gray-800 uppercase tracking-wider">Fecha</span>
                            <span class="text-base font-bold text-gray-600">23/10/2026</span>
                        </div>
                    </div>

                    {{-- UBICACIÓN --}}
                    <div class="flex items-center space-x-3">
                        <svg class="w-7 h-4 text-[#9d2449] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div>
                            <span class="block text-sm font-bold text-gray-800 uppercase tracking-wider">Ubicación</span>
                            <span class="text-base font-bold text-gray-600 leading-tight block">Estadio Xalapeño
                                    "Heriberto Jara Corona", Xalapa, Ver.</span>
                        </div>
                    </div>

                    {{-- ORGANIZADOR --}}
                    <div class="flex items-center space-x-3">
                        <svg class="w-7 h-4 text-[#9d2449] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <div>
                            <span class="block text-sm font-bold text-gray-800 uppercase tracking-wider">Organizador</span>
                            <span class="text-base font-bold text-gray-600 leading-tight block">Sección 56 - SNTE</span>
                        </div>
                    </div>

                </div>
            </aside>
        </div>
    </main>

    {{-- ═══════════════ FOOTER INSTITUCIONAL ═══════════════ --}}
    <footer class="bg-[#9d2449] mt-12">
        <div class="bg-[#f18c21] h-3"></div>

        <div class="py-4 px-6 text-center">
            <div class="flex justify-center mb-3 md:hidden">
                <img src="{{ asset('images/logounidad@4x-8.png') }}" alt="La Unidad - Nuestra Fortaleza"
                    class="h-12 w-auto">
            </div>

            <p class="text-white text-sm">
                Sindicato Nacional de Trabajadores de la Educación &mdash; Sección 56 Veracruz
            </p>
            <p class="text-white/70 text-xs mt-1">
                &copy; {{ date('Y') }} Todos los derechos reservados
            </p>
        </div>
    </footer>

</div>