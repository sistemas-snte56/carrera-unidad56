<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Consulta de inscripción</title>
</head>

<body>

    <h1>Consulta de inscripción</h1>

    <p>
        <strong>Folio:</strong>
        {{ $participante->folio }}
    </p>

    <p>
        <strong>Nombre:</strong>
        {{ $participante->nombre }}
        {{ $participante->apellido_paterno }}
        {{ $participante->apellido_materno }}
    </p>

    <p>
        <strong>Edad:</strong>
        {{ $participante->fecha_nacimiento->age }} años
    </p>

    <p>
        <strong>Rama:</strong>
        {{ ucfirst($participante->rama) }}
    </p>

    <p>
        <strong>Distancia:</strong>
        {{ $participante->distancia }}
    </p>

    <p>
        <strong>Tipo de corredor:</strong>
        {{ $participante->tipo_corredor === 'agremiado'
            ? 'Agremiado'
            : 'Público en general'
        }}
    </p>

    @if ($participante->tipo_corredor === 'agremiado')

        <p>
            <strong>Región:</strong>
            {{ $participante->delegacion?->region?->nombre }}
        </p>

        <p>
            <strong>Delegación:</strong>
            {{ $participante->delegacion?->delegacion }}
        </p>

    @endif

    <p>
        <strong>Número de corredor:</strong>
        {{ str_pad($participante->numero_corredor, 5, '0', STR_PAD_LEFT) }}
    </p>

    <p>
        <strong>Fecha de registro:</strong>
        {{ $participante->created_at->format('d/m/Y H:i') }}
    </p>

    <p>
        <strong>Estatus:</strong>
        {{ ucfirst($participante->estatus) }}
    </p>

</body>
</html>