<?php

use Illuminate\Support\Facades\Route;
Route::any('{any}', function () {
    return redirect()->away('https://snte56.org.mx/');
})->where('any', '^(?!admin).*$'); // Esto significa: Redirecciona todo lo que NO empiece con "ad