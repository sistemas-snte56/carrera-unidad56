<div>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f3f5f7;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }

        .registro-container {
            width: 100%;
            max-width: 850px;
            margin: 30px auto;
            padding: 0 15px;
        }

        .encabezado {
            background: #f18c21;
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 14px 14px 0 0;
        }

        .encabezado h1 {
            margin: 0;
            font-size: 28px;
        }

        .encabezado p {
            margin: 8px 0 0;
            font-size: 16px;
        }

        .formulario,
        .exito {
            background: white;
            padding: 30px;
            box-shadow: 0 3px 15px rgba(0,0,0,.08);
        }

        .seccion {
            margin-bottom: 30px;
        }

        .seccion h2 {
            margin: 0 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
            font-size: 20px;
            color: #f18c21;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .campo {
            display: flex;
            flex-direction: column;
        }

        .campo-completo {
            grid-column: 1 / -1;
        }

        label {
            margin-bottom: 7px;
            font-weight: bold;
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 15px;
            background: white;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #f18c21;
            box-shadow: 0 0 0 2px rgba(0,59,113,.1);
        }

        input[type="file"] {
            padding: 9px;
        }

        .error {
            margin-top: 5px;
            color: #dc2626;
            font-size: 13px;
        }

        .boton {
            width: 100%;
            border: none;
            border-radius: 8px;
            padding: 14px;
            background: #f18c21;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .boton:hover {
            background: #002d55;
        }

        .exito {
            text-align: center;
            border-radius: 14px;
            margin-bottom: 20px;
        }

        .exito h2 {
            color: #15803d;
            margin-top: 0;
        }

        .dato-exito {
            margin: 12px auto;
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            max-width: 400px;
        }

        .enlace {
            display: inline-block;
            margin-top: 15px;
            padding: 11px 18px;
            background: #003b71;
            color: white;
            text-decoration: none;
            border-radius: 7px;
        }

        .aviso {
            font-size: 13px;
            color: #64748b;
            margin-top: 8px;
        }

        @media (max-width: 650px) {

            .registro-container {
                margin: 0 auto;
                padding: 0;
            }

            .encabezado {
                border-radius: 0;
                padding: 25px 15px;
            }

            .encabezado h1 {
                font-size: 22px;
            }

            .formulario,
            .exito {
                padding: 20px 15px;
                border-radius: 0;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .campo-completo {
                grid-column: auto;
            }
        }
    </style>

    <div class="registro-container">

        <div class="encabezado">
            <h1>1ra Carrera Atlética del Educador Físico</h1>
            <p>Registro de participantes</p>
        </div>

        @if ($registroExitoso)

            <div class="exito">

                <h2>¡Registro exitoso!</h2>

                <p>
                    Tu inscripción ha sido registrada correctamente.
                </p>

                <div class="dato-exito">
                    <strong>Folio</strong><br>
                    {{ $folioGenerado }}
                </div>

                <div class="dato-exito">
                    <strong>Número de corredor</strong><br>
                    {{ $numeroCorredorGenerado }}
                </div>

                <a
                    class="enlace"
                    href="{{ url('/acuse/' . $acuseTokenGenerado) }}"
                    target="_blank"
                >
                    Descargar acuse de registro
                </a>

            </div>

        @endif

        <form class="formulario" wire:submit="continuar">

            <div class="seccion">

                <h2>Datos personales</h2>

                <div class="grid">

                    <div class="campo">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" wire:model="nombre">
                        @error('nombre')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="campo">
                        <label for="apellido_paterno">Apellido paterno</label>
                        <input type="text" id="apellido_paterno" wire:model="apellido_paterno">
                        @error('apellido_paterno')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="campo">
                        <label for="apellido_materno">Apellido materno</label>
                        <input type="text" id="apellido_materno" wire:model="apellido_materno">
                        @error('apellido_materno')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="campo">
                        <label for="fecha_nacimiento">Fecha de nacimiento</label>
                        <input type="date" id="fecha_nacimiento" wire:model="fecha_nacimiento">
                        @error('fecha_nacimiento')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="campo">
                        <label for="rama">Rama</label>
                        <select id="rama" wire:model="rama">
                            <option value="">Seleccione una opción</option>
                            <option value="femenil">Femenil</option>
                            <option value="varonil">Varonil</option>
                        </select>
                        @error('rama')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="campo">
                        <label for="distancia">Distancia</label>
                        <select id="distancia" wire:model="distancia">
                            <option value="">Seleccione una opción</option>
                            <option value="3K">3 km</option>
                            <option value="5K">5 km</option>
                            <option value="10K">10 km</option>
                        </select>
                        @error('distancia')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="campo campo-completo">
                        <label for="tipo_corredor">Tipo de participante</label>
                        <select id="tipo_corredor" wire:model.live="tipo_corredor">
                            <option value="">Seleccione una opción</option>
                            <option value="agremiado">Agremiado</option>
                            <option value="publico">Público en general</option>
                        </select>
                        @error('tipo_corredor')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($tipo_corredor === 'agremiado')

                        <div class="campo">
                            <label for="region_id">Región</label>

                            <select id="region_id" wire:model.live="region_id">
                                <option value="">Seleccione una región</option>

                                @foreach ($regiones as $region)
                                    <option value="{{ $region->id }}">
                                        {{ $region->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            @error('region_id')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="campo">
                            <label for="delegacion_id">Delegación</label>

                            <select id="delegacion_id" wire:model="delegacion_id">
                                <option value="">Seleccione una delegación</option>

                                @foreach ($delegaciones as $delegacion)
                                    <option value="{{ $delegacion->id }}">
                                        {{ $delegacion->delegacion_completa }}
                                    </option>
                                @endforeach
                            </select>

                            @error('delegacion_id')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                    @endif

                </div>

            </div>


            <div class="seccion">

                <h2>Datos de contacto</h2>

                <div class="grid">

                    <div class="campo">
                        <label for="correo">Correo electrónico</label>

                        <input type="email" id="correo" wire:model="correo">

                        @error('correo')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="campo">
                        <label for="telefono">Teléfono</label>

                        <input type="tel" id="telefono" wire:model="telefono">

                        @error('telefono')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

            </div>


            <div class="seccion">

                <h2>Documentos</h2>

                <div class="grid">

                    <div class="campo">
                        <label for="ine">INE o credencial de elector</label>

                        <input
                            type="file"
                            id="ine"
                            wire:model="ine"
                            accept=".jpg,.jpeg,.png,.pdf"
                        >

                        <div class="aviso">
                            JPG, PNG o PDF. Máximo 5 MB.
                        </div>

                        @error('ine')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="campo">
                        <label for="voucher">Comprobante de pago</label>

                        <input
                            type="file"
                            id="voucher"
                            wire:model="voucher"
                            accept=".jpg,.jpeg,.png,.pdf"
                        >

                        <div class="aviso">
                            JPG, PNG o PDF. Máximo 5 MB.
                        </div>

                        @error('voucher')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

            </div>


            <button class="boton" type="submit">
                Continuar
            </button>

        </form>

    </div>

</div>