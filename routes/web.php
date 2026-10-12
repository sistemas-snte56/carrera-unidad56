<?php

use App\Livewire\Registro;
use App\Models\Participante;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// 1. Ruta raíz que renderiza el componente de cierre (vista de agradecimiento)
Route::get('/', Registro::class);

// 2. Ruta protegida y firmada para que Filament pueda mostrar los documentos (INE y voucher)
Route::get('/admin/documento/{participante}/{tipo}', function (Participante $participante, $tipo) {
    abort_unless(in_array($tipo, ['ine', 'voucher']), 404);

    $path = $tipo === 'ine'
        ? $participante->ine_path
        : $participante->voucher_path;

    abort_unless($path && Storage::disk('local')->exists($path), 404);

    return response()->file(
        Storage::disk('local')->path($path)
    );
})->middleware([
    \Filament\Http\Middleware\Authenticate::class,
    'signed',
])->name('admin.documento');

// 3. Comodín global al final: redirige cualquier otra URL pública que NO empiece con "admin"
Route::any('{any}', function () {
    return redirect()->away('https://snte56.org.mx/');
})->where('any', '^(?!admin).*$');