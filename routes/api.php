<?php

use App\Http\Controllers\HospedajeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController; // Cambiado de Controller a Controllers
use App\Http\Controllers\SitioController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\GastronomiaController;
use App\Http\Controllers\SliderController;





Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/categorias', [CategoriaController::class, 'index']); // Uso correcto del namespace y la clase del controlador
Route::get('/sliders', [SliderController::class, 'index']); // Uso correcto del namespace y la clase del controlador
Route::get('/sitios', [SitioController::class, 'index2']); // Uso correcto del namespace y la clase del controlador

Route::get('/fotos', [FotoController::class, 'index2']); // Uso correcto del namespace y la clase del controlador


Route::get('/gastronomia', [GastronomiaController::class, 'index']); // Uso correcto del namespace y la clase del controlador
Route::get('/hospedaje', [HospedajeController::class, 'index']); // Uso correcto del namespace y la clase del controlador