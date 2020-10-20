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

Route::get("/user/{id}/notificacion", function ($id) {
    $user = App\Models\User::find($id);

    foreach ($user->desarrolladoras as $desarrolladora) {

        echo $desarrolladora->pivot->notificacion . ' ';
    }
});

/**
 * Admin Routes
 */

// Géneros
Route::get('/admin/generos', [App\Http\Controllers\Administrador\GenerosController::class, 'index'])->name('generos.index');
Route::post('/admin/generos', [App\Http\Controllers\Administrador\GenerosController::class, 'store'])->name('generos.store');
Route::PATCH('/admin/generos/{id}/update', [App\Http\Controllers\Administrador\GenerosController::class, 'update'])->name('generos.update');
Route::delete('/admin/generos/{id}/delete', [App\Http\Controllers\Administrador\GenerosController::class, 'destroy'])->name('generos.destroy');
