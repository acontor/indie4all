<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;

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
    $noticias = Post::where([['desarrolladora_id', null], ['juego_id', null], ['master_id', null]])->paginate(4);
    return view('welcome', compact('noticias'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * Admin Routes
 */

// Inicio
Route::get('/admin', [App\Http\Controllers\Administrador\HomeController::class, 'index'])->name('admin.index');

// Noticias
Route::get('/admin/noticias', [App\Http\Controllers\Administrador\NoticiasController::class, 'index'])->name('admin.noticias.index');
Route::get('/admin/noticias/nueva', [App\Http\Controllers\Administrador\NoticiasController::class, 'create'])->name('admin.noticias.create');
Route::post('/admin/noticias/nueva', [App\Http\Controllers\Administrador\NoticiasController::class, 'store'])->name('admin.noticias.store');
Route::patch('/admin/noticias/{id}/update', [App\Http\Controllers\Administrador\NoticiasController::class, 'update'])->name('admin.noticias.update');
Route::delete('/admin/noticias/{id}/delete', [App\Http\Controllers\Administrador\NoticiasController::class, 'destroy'])->name('admin.noticias.destroy');

// Usuarios
Route::get('/admin/usuarios', [App\Http\Controllers\Administrador\UsuariosController::class, 'index'])->name('admin.usuarios.index');
Route::patch('/admin/usuarios/{id}/update', [App\Http\Controllers\Administrador\UsuariosController::class, 'update'])->name('admin.usuarios.update');
Route::delete('/admin/usuarios/{id}/delete', [App\Http\Controllers\Administrador\UsuariosController::class, 'destroy'])->name('admin.usuarios.destroy');

// Desarrolladoras
Route::get('/admin/desarrolladoras', [App\Http\Controllers\Administrador\DesarrolladorasController::class, 'index'])->name('admin.desarrolladoras.index');

//Juegos
Route::get('/admin/juegos', [App\Http\Controllers\Administrador\JuegosController::class, 'index'])->name('admin.juegos.index');

// Logros
Route::get('/admin/logros', [App\Http\Controllers\Administrador\LogrosController::class, 'index'])->name('admin.logros.index');
Route::post('/admin/logros', [App\Http\Controllers\Administrador\LogrosController::class, 'store'])->name('admin.logros.store');
Route::patch('/admin/logros/{id}/update', [App\Http\Controllers\Administrador\LogrosController::class, 'update'])->name('admin.logros.update');
Route::delete('/admin/logros/{id}/delete', [App\Http\Controllers\Administrador\LogrosController::class, 'destroy'])->name('admin.logros.destroy');

// Géneros
Route::get('/admin/generos', [App\Http\Controllers\Administrador\GenerosController::class, 'index'])->name('admin.generos.index');
Route::post('/admin/generos', [App\Http\Controllers\Administrador\GenerosController::class, 'store'])->name('admin.generos.store');
Route::patch('/admin/generos/{id}/update', [App\Http\Controllers\Administrador\GenerosController::class, 'update'])->name('admin.generos.update');
Route::delete('/admin/generos/{id}/delete', [App\Http\Controllers\Administrador\GenerosController::class, 'destroy'])->name('admin.generos.destroy');

// Solicitudes
Route::get('/admin/solicitudes', [App\Http\Controllers\Administrador\SolicitudesController::class, 'index'])->name('admin.solicitudes.index');
Route::post('/admin/solicitudes/{id}/{cm}', [App\Http\Controllers\Administrador\SolicitudesController::class, 'aceptarDesarrolladora'])->name('admin.solicitudes.aceptarDesarrolladora');
Route::delete('/admin/solicitudes/{id}', [App\Http\Controllers\Administrador\SolicitudesController::class, 'rechazarDesarrolladora'])->name('admin.solicitudes.rechazarDesarrolladora');

/**
 * User Routes
 */

// Desarrolladoras
Route::get('/desarrolladoras', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'index'])->name('usuario.desarrolladoras.index');
Route::get('/desarrolladora/{id}', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'show'])->name('usuario.desarrolladora.show');
Route::get('/desarrolladora/solicitud', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'create'])->name('usuario.desarrolladora.create');
Route::post('/desarrolladora/solicitud', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'store'])->name('usuario.desarrolladora.store');

// Juegos
Route::get('/juegos', [App\Http\Controllers\Usuario\JuegosController::class, 'index'])->name('usuario.juegos.index');
Route::get('/juego/{id}', [App\Http\Controllers\Usuario\JuegosController::class, 'show'])->name('usuario.juego.show');
