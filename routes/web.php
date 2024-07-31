<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/receber-numero-romano', [\App\Http\Controllers\NumerosRomanosArabicosController::class, 'receberNumeroRomano'])->name('receber.numero.romano');

Route::post('/receber-numero-arabico', [\App\Http\Controllers\NumerosRomanosArabicosController::class, 'receberNumeroArabico'])->name('receber.numero.arabico');

