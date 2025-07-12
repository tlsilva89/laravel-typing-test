<?php

use Illuminate\Support\Facades\Route;

// Rota principal para a aplicação Vue
Route::get('/', function () {
    return view('welcome');
});

// Rota alternativa para teste
Route::get('/typing-test', function () {
    return view('welcome');
});

// Rota catch-all para SPA (Single Page Application)
// Esta rota deve ser a ÚLTIMA no arquivo
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
