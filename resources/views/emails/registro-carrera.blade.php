<h2>Registro confirmado</h2>

<p>Hola <strong>{{ $participante->nombre }}</strong>,</p>

<p>Tu registro a la <strong>1ra Carrera Atlética del Educador Físico</strong> se realizó correctamente.</p>

<p>
    <strong>Folio:</strong> {{ $participante->folio }}<br>
    <strong>Número de corredor:</strong> {{ str_pad($participante->numero_corredor, 5, '0', STR_PAD_LEFT) }}<br>
    <strong>Rama:</strong> {{ ucfirst($participante->rama) }}<br>
    <strong>Distancia:</strong> {{ $participante->distancia }}<br>
</p>

<p>
    Puedes subir tu comprobante de pago y tu vaucher de inscripción por este medio.
</p>

<p>
    <a href="{{ url('/acuse/' . $participante->acuse_token) }}">
        Descargar mi acuse de registro
    </a>
</p>

<p>
    <a href="{{ url('/consulta/' . $participante->acuse_token) }}">
        Consultar mi registro
    </a>
</p>

<p>Guarda este correo para futuras consultas.</p>

<p>Saludos.</p>