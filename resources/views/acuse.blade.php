<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Acuse de registro</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            color: #222;
        }

        .titulo {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .evento {
            text-align: center;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .dato {
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
        }

        .numero {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            margin: 30px 0;
        }

        .estatus {
            text-align: center;
            font-size: 18px;
            margin-top: 25px;
        }
    </style>
</head>

<body>

    <div class="titulo">
        ACUSE DE REGISTRO
    </div>

    <div class="evento">
        1ra CARRERA ATLÉTICA DEL EDUCADOR FÍSICO
    </div>

    <div class="dato">
        <span class="label">Nombre:</span>
        {{ $participante->nombre }}
        {{ $participante->apellido_paterno }}
        {{ $participante->apellido_materno }}
    </div>

    <div class="dato">
        <span class="label">Edad:</span>
        {{ $participante->fecha_nacimiento->age }} años
    </div>

    <div class="dato">
        <span class="label">Rama:</span>
        {{ ucfirst($participante->rama) }}
    </div>

    <div class="dato">
        <span class="label">Distancia:</span>
        {{ $participante->distancia }}
    </div>

    <div class="dato">
        <span class="label">Tipo de corredor:</span>
        {{ $participante->tipo_corredor === 'agremiado'
            ? 'Agremiado'
            : 'Público en general'
        }}
    </div>

    @if ($participante->tipo_corredor === 'agremiado')

        <div class="dato">
            <span class="label">Región:</span>
            {{ $participante->delegacion?->region?->nombre }}
        </div>

        <div class="dato">
            <span class="label">Delegación:</span>
            {{ $participante->delegacion?->delegacion }}
        </div>

    @endif

    <div class="numero">
        Número de corredor:
        {{ str_pad($participante->numero_corredor, 5, '0', STR_PAD_LEFT) }}
    </div>

    <div class="dato">
        <span class="label">Folio:</span>
        {{ $participante->folio }}
    </div>

    <div class="dato">
        <span class="label">Fecha de registro:</span>
        {{ $participante->created_at->format('d/m/Y H:i') }}
    </div>

    <div class="estatus">
        <strong>Estatus:</strong>
        {{ ucfirst($participante->estatus) }}
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <p><strong>Consulta tu registro</strong></p>

        <img
            src="data:image/svg+xml;base64,{{ $qr }}"
            width="200"
            height="200"
        >
    </div>    

</body>
</html>