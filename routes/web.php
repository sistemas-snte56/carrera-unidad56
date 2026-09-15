<?php

use App\Livewire\Registro;
use Illuminate\Support\Facades\Route;
use App\Models\Participante;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// Route::get('/', function () {
//     return view('registro');
// });

Route::get('/', Registro::class);


Route::get('/consulta/{acuse_token}', function ($acuse_token) {
    $participante = Participante::where('acuse_token', $acuse_token)
        ->with('delegacion.region')
        ->firstOrFail();

    $consulta = [
        'folio' => $participante->folio,

        'nombre' => trim(
            $participante->nombre . ' ' .
            $participante->apellido_paterno . ' ' .
            ($participante->apellido_materno ?? '')
        ),

        'edad' => $participante->fecha_nacimiento->age,
        'rama' => $participante->rama,
        'distancia' => $participante->distancia,
        'tipo_corredor' => $participante->tipo_corredor,

        'numero_corredor' => str_pad(
            $participante->numero_corredor,
            5,
            '0',
            STR_PAD_LEFT
        ),

        'fecha_registro' => $participante->created_at->format('d/m/Y H:i'),

        'estatus' => $participante->estatus,
    ];

    if ($participante->tipo_corredor === 'agremiado') {
        $consulta['region'] = $participante->delegacion?->region?->nombre;
        $consulta['delegacion'] = $participante->delegacion?->delegacion;
    }

    // return $consulta;

    return view('consulta', [
        'participante' => $participante,
    ]);   
});

Route::get('/acuse/{acuse_token}', function ($acuse_token) {
    $participante = Participante::where('acuse_token', $acuse_token)
        ->with('delegacion.region')
        ->firstOrFail();

    $urlConsulta = url('/consulta/' . $participante->acuse_token);

    $qr = base64_encode(
        QrCode::format('svg')
            ->size(200)
            ->generate($urlConsulta)
    );

    $pdf = Pdf::loadView('acuse', [
        'participante' => $participante,
        'qr' => $qr,
    ]);

    return $pdf->stream(
        'acuse-' . $participante->folio . '.pdf'
    );
});