<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\SitioController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\GastronomiaController;
use App\Http\Controllers\HospedajeController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
Route::post('/categoria', [CategoriaController::class, 'store'])->name('categoria.store');




Route::post('/sitio', [SitioController::class, 'store'])->name('sitio.store');
Route::get('/', 'App\Http\Controllers\SitioController@index');



Route::get('/foto', 'App\Http\Controllers\FotoController@index');
Route::post('/foto', [FotoController::class, 'store'])->name('foto.store');





Route::get('/hospedaje', 'App\Http\Controllers\HospedajeController@create');
Route::post('/hospedaje', [HospedajeController::class, 'store'])->name('hospedaje.store');



Route::get('/gastronomia', 'App\Http\Controllers\GastronomiaController@create');
Route::post('/gastronomia', [GastronomiaController::class, 'store'])->name('gastronomia.store');
