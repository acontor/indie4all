<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * Admin Routes
 */

// Logros
Route::get('/admin/logros', [App\Http\Controllers\Administrador\LogrosController::class, 'index'])->name('logros.index');
Route::post('/admin/logros', [App\Http\Controllers\Administrador\LogrosController::class, 'store'])->name('logros.store');
Route::patch('/admin/logros/{id}/update', [App\Http\Controllers\Administrador\LogrosController::class, 'update'])->name('logros.update');
Route::delete('/admin/logros/{id}/delete', [App\Http\Controllers\Administrador\LogrosController::class, 'destroy'])->name('logros.destroy');

// Géneros
Route::get('/admin/generos', [App\Http\Controllers\Administrador\GenerosController::class, 'index'])->name('generos.index');
Route::post('/admin/generos', [App\Http\Controllers\Administrador\GenerosController::class, 'store'])->name('generos.store');
Route::PATCH('/admin/generos/{id}/update', [App\Http\Controllers\Administrador\GenerosController::class, 'update'])->name('generos.update');
Route::delete('/admin/generos/{id}/delete', [App\Http\Controllers\Administrador\GenerosController::class, 'destroy'])->name('generos.destroy');
