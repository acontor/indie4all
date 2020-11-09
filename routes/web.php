<?php

use Illuminate\Support\Facades\Route;
use App\Models\Desarrolladora;
use App\Models\Juego;
use App\Models\Master;
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
    $juegos = Juego::has('usuarios')->inRandomOrder()->take(5)->get();
    $desarrolladoras = Desarrolladora::all()->take(5);
    $masters = Master::all()->take(5);
    return view('welcome', ['noticias' => $noticias, 'juegos' => $juegos, 'desarrolladoras' => $desarrolladoras, 'masters' => $masters]);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\Usuario\HomeController::class, 'index'])->name('home');

/**
 * Admin Routes
 */

// Inicio
Route::get('/admin', [App\Http\Controllers\Administrador\HomeController::class, 'index'])->name('admin.index')->middleware('auth');

// Noticias
Route::get('/admin/noticias', [App\Http\Controllers\Administrador\NoticiasController::class, 'index'])->name('admin.noticias.index')->middleware('auth');
Route::get('/admin/noticias/nueva', [App\Http\Controllers\Administrador\NoticiasController::class, 'create'])->name('admin.noticias.create')->middleware('auth');
Route::post('/admin/noticias/upload', [App\Http\Controllers\Administrador\NoticiasController::class, 'upload'])->name('admin.noticias.upload');
Route::post('/admin/noticias/nueva', [App\Http\Controllers\Administrador\NoticiasController::class, 'store'])->name('admin.noticias.store')->middleware('auth');
Route::post('/admin/noticias/{id}/edit', [App\Http\Controllers\Administrador\NoticiasController::class, 'edit'])->name('admin.noticias.edit')->middleware('auth');
Route::patch('/admin/noticias/{id}/update', [App\Http\Controllers\Administrador\NoticiasController::class, 'update'])->name('admin.noticias.update')->middleware('auth');
Route::delete('/admin/noticias/{id}/delete', [App\Http\Controllers\Administrador\NoticiasController::class, 'destroy'])->name('admin.noticias.destroy')->middleware('auth');

// Usuarios
Route::get('/admin/usuarios', [App\Http\Controllers\Administrador\UsuariosController::class, 'index'])->name('admin.usuarios.index')->middleware('auth');
Route::patch('/admin/usuarios/{id}/update', [App\Http\Controllers\Administrador\UsuariosController::class, 'update'])->name('admin.usuarios.update')->middleware('auth');
Route::delete('/admin/usuarios/{id}/delete', [App\Http\Controllers\Administrador\UsuariosController::class, 'destroy'])->name('admin.usuarios.destroy')->middleware('auth');

// Desarrolladoras
Route::get('/admin/desarrolladoras', [App\Http\Controllers\Administrador\DesarrolladorasController::class, 'index'])->name('admin.desarrolladoras.index')->middleware('auth');

//Juegos
Route::get('/admin/juegos', [App\Http\Controllers\Administrador\JuegosController::class, 'index'])->name('admin.juegos.index')->middleware('auth');

// Logros
Route::get('/admin/logros', [App\Http\Controllers\Administrador\LogrosController::class, 'index'])->name('admin.logros.index')->middleware('auth');
Route::post('/admin/logros', [App\Http\Controllers\Administrador\LogrosController::class, 'store'])->name('admin.logros.store')->middleware('auth');
Route::patch('/admin/logros/{id}/update', [App\Http\Controllers\Administrador\LogrosController::class, 'update'])->name('admin.logros.update')->middleware('auth');
Route::delete('/admin/logros/{id}/delete', [App\Http\Controllers\Administrador\LogrosController::class, 'destroy'])->name('admin.logros.destroy')->middleware('auth');

// Géneros
Route::get('/admin/generos', [App\Http\Controllers\Administrador\GenerosController::class, 'index'])->name('admin.generos.index')->middleware('auth');
Route::post('/admin/generos', [App\Http\Controllers\Administrador\GenerosController::class, 'store'])->name('admin.generos.store')->middleware('auth');
Route::patch('/admin/generos/{id}/update', [App\Http\Controllers\Administrador\GenerosController::class, 'update'])->name('admin.generos.update')->middleware('auth');
Route::delete('/admin/generos/{id}/delete', [App\Http\Controllers\Administrador\GenerosController::class, 'destroy'])->name('admin.generos.destroy')->middleware('auth');

// Solicitudes
Route::get('/admin/solicitudes', [App\Http\Controllers\Administrador\SolicitudesController::class, 'index'])->name('admin.solicitudes.index')->middleware('auth');
Route::post('/admin/solicitudes/{id}/{cm}', [App\Http\Controllers\Administrador\SolicitudesController::class, 'aceptarDesarrolladora'])->name('admin.solicitudes.aceptarDesarrolladora')->middleware('auth');
Route::delete('/admin/solicitudes/{id}', [App\Http\Controllers\Administrador\SolicitudesController::class, 'rechazarDesarrolladora'])->name('admin.solicitudes.rechazarDesarrolladora')->middleware('auth');

/**
 * User Routes
 */

// Mi cuenta
Route::get('/cuenta', [App\Http\Controllers\Usuario\CuentaController::class, 'index'])->name('usuario.cuenta.index')->middleware('auth');

// Desarrolladoras
Route::get('/desarrolladoras', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'index'])->name('usuario.desarrolladoras.index')->middleware('auth');
Route::get('/desarrolladora/{id}', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'show'])->name('usuario.desarrolladora.show')->middleware('auth');
Route::post('/desarrolladora/{id}/follow', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'follow'])->name('usuario.desarrolladora.follow')->middleware('auth');
Route::post('/desarrolladora/{id}/unfollow', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'unfollow'])->name('usuario.desarrolladora.unfollow')->middleware('auth');
Route::post('/desarrolladora/{id}/{notificacion}', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'notificacion'])->name('usuario.desarrolladora.notificacion')->middleware('auth');
Route::get('/desarrolladoras/solicitud', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'create'])->name('usuario.desarrolladora.create')->middleware('auth');
Route::post('/desarrolladoras/solicitud', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'store'])->name('usuario.desarrolladora.store')->middleware('auth');

// Juegos
Route::get('/juegos', [App\Http\Controllers\Usuario\JuegosController::class, 'index'])->name('usuario.juegos.index')->middleware('auth');
Route::get('/juego/{id}', [App\Http\Controllers\Usuario\JuegosController::class, 'show'])->name('usuario.juego.show')->middleware('auth');
Route::post('/juego/{id}/follow', [App\Http\Controllers\Usuario\JuegosController::class, 'follow'])->name('usuario.juego.follow')->middleware('auth');
Route::post('/juego/{id}/unfollow', [App\Http\Controllers\Usuario\JuegosController::class, 'unfollow'])->name('usuario.juego.unfollow')->middleware('auth');
Route::post('/juego/{id}/{notificacion}', [App\Http\Controllers\Usuario\JuegosController::class, 'notificacion'])->name('usuario.juego.notificacion')->middleware('auth');

//master
Route::get('/masters', [App\Http\Controllers\Usuario\MasterController::class, 'index'])->name('usuario.masters.index')->middleware('auth');
Route::get('/master/{id}', [App\Http\Controllers\Usuario\MasterController::class, 'show'])->name('usuario.master.show')->middleware('auth');
Route::post('/master/{id}/follow', [App\Http\Controllers\Usuario\MasterController::class, 'follow'])->name('usuario.master.follow')->middleware('auth');
Route::post('/master/{id}/unfollow', [App\Http\Controllers\Usuario\MasterController::class, 'unfollow'])->name('usuario.master.unfollow')->middleware('auth');
Route::post('/master/{id}/{notificacion}', [App\Http\Controllers\Usuario\MasterController::class, 'notificacion'])->name('usuario.master.notificacion')->middleware('auth');

//Testing routes
Route::get('/admin/test', [App\Http\Controllers\Administrador\UsuariosController::class, 'test'])->middleware('auth');
Route::get('/autocomplete-user-search', [App\Http\Controllers\Administrador\UsuariosController::class, 'selectSearch'])->middleware('auth');
