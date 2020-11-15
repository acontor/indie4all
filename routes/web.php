<?php

use App\Models\Desarrolladora;
use App\Models\Juego;
use App\Models\Master;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
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
Route::get('/admin', [App\Http\Controllers\Administrador\HomeController::class, 'index'])->name('admin.index');

// Noticias
Route::get('/admin/noticias', [App\Http\Controllers\Administrador\NoticiasController::class, 'index'])->name('admin.noticias.index');
Route::get('/admin/noticias/nueva', [App\Http\Controllers\Administrador\NoticiasController::class, 'create'])->name('admin.noticias.create');
Route::post('/admin/noticias/upload', [App\Http\Controllers\Administrador\NoticiasController::class, 'upload'])->name('admin.noticias.upload');
Route::post('/admin/noticias/nueva', [App\Http\Controllers\Administrador\NoticiasController::class, 'store'])->name('admin.noticias.store');
Route::post('/admin/noticias/{id}/edit', [App\Http\Controllers\Administrador\NoticiasController::class, 'edit'])->name('admin.noticias.edit');
Route::patch('/admin/noticias/{id}/update', [App\Http\Controllers\Administrador\NoticiasController::class, 'update'])->name('admin.noticias.update');
Route::delete('/admin/noticias/{id}/delete', [App\Http\Controllers\Administrador\NoticiasController::class, 'destroy'])->name('admin.noticias.destroy');

// Usuarios
Route::get('/admin/usuarios', [App\Http\Controllers\Administrador\UsuariosController::class, 'index'])->name('admin.usuarios.index');
Route::get('/admin/usuarios/nuevo', [App\Http\Controllers\Administrador\UsuariosController::class, 'create'])->name('admin.usuarios.create');
Route::post('/admin/usuarios/nuevo', [App\Http\Controllers\Administrador\UsuariosController::class, 'store'])->name('admin.usuarios.store');
Route::post('/admin/usuarios/{id}/edit', [App\Http\Controllers\Administrador\UsuariosController::class, 'edit'])->name('admin.usuarios.edit');
Route::patch('/admin/usuarios/{id}/update', [App\Http\Controllers\Administrador\UsuariosController::class, 'update'])->name('admin.usuarios.update');
Route::delete('/admin/usuarios/{id}/delete', [App\Http\Controllers\Administrador\UsuariosController::class, 'destroy'])->name('admin.usuarios.destroy');

// Desarrolladoras
Route::get('/admin/desarrolladoras', [App\Http\Controllers\Administrador\DesarrolladorasController::class, 'index'])->name('admin.desarrolladoras.index');

//Juegos
Route::get('/admin/juegos', [App\Http\Controllers\Administrador\JuegosController::class, 'index'])->name('admin.juegos.index');

// Logros
Route::get('/admin/logros', [App\Http\Controllers\Administrador\LogrosController::class, 'index'])->name('admin.logros.index');
Route::get('/admin/logros/nuevo', [App\Http\Controllers\Administrador\LogrosController::class, 'create'])->name('admin.logros.create');
Route::post('/admin/logros', [App\Http\Controllers\Administrador\LogrosController::class, 'store'])->name('admin.logros.store');
Route::post('/admin/logros/{id}/edit', [App\Http\Controllers\Administrador\LogrosController::class, 'edit'])->name('admin.logros.edit');
Route::patch('/admin/logros/{id}/update', [App\Http\Controllers\Administrador\LogrosController::class, 'update'])->name('admin.logros.update');
Route::delete('/admin/logros/{id}/delete', [App\Http\Controllers\Administrador\LogrosController::class, 'destroy'])->name('admin.logros.destroy');

// Géneros
Route::get('/admin/generos', [App\Http\Controllers\Administrador\GenerosController::class, 'index'])->name('admin.generos.index');
Route::get('/admin/generos/nuevo', [App\Http\Controllers\Administrador\GenerosController::class, 'create'])->name('admin.generos.create');
Route::post('/admin/generos', [App\Http\Controllers\Administrador\GenerosController::class, 'store'])->name('admin.generos.store');
Route::post('/admin/generos/{id}/edit', [App\Http\Controllers\Administrador\GenerosController::class, 'edit'])->name('admin.generos.edit');
Route::patch('/admin/generos/{id}/update', [App\Http\Controllers\Administrador\GenerosController::class, 'update'])->name('admin.generos.update');
Route::delete('/admin/generos/{id}/delete', [App\Http\Controllers\Administrador\GenerosController::class, 'destroy'])->name('admin.generos.destroy');

// Solicitudes
Route::get('/admin/solicitudes', [App\Http\Controllers\Administrador\SolicitudesController::class, 'index'])->name('admin.solicitudes.index');
Route::post('/admin/solicitudes/{id}', [App\Http\Controllers\Administrador\SolicitudesController::class, 'aceptarDesarrolladora'])->name('admin.solicitudes.aceptarDesarrolladora');
Route::delete('/admin/solicitudes/{id}', [App\Http\Controllers\Administrador\SolicitudesController::class, 'rechazarDesarrolladora'])->name('admin.solicitudes.rechazarDesarrolladora');

/**
 * Cm Routes
 */

// Inicio
Route::get('/cm', [App\Http\Controllers\Cm\HomeController::class, 'index'])->name('cm.index');

// Desarrolladora
Route::get('/cm/desarrolladora', [App\Http\Controllers\Cm\DesarrolladoraController::class, 'index'])->name('cm.desarrolladora.index');

// Sorteos
Route::get('/cm/sorteos', [App\Http\Controllers\Cm\SorteosController::class, 'index'])->name('cm.sorteos.index');
Route::get('/cm/sorteos/nuevo', [App\Http\Controllers\Cm\SorteosController::class, 'create'])->name('cm.sorteos.create');
Route::post('/cm/sorteos', [App\Http\Controllers\Cm\SorteosController::class, 'store'])->name('cm.sorteos.store');

// Juegos
Route::get('/cm/juegos', [App\Http\Controllers\Cm\JuegosController::class, 'index'])->name('cm.juegos.index');

// Campañas
Route::get('/cm/campanias', [App\Http\Controllers\Cm\CampaniasController::class, 'index'])->name('cm.campanias.index');

// Encuestas
Route::get('/cm/encuestas', [App\Http\Controllers\Cm\EncuestasController::class, 'index'])->name('cm.encuestas.index');
Route::get('/cm/encuestas/nuevo', [App\Http\Controllers\Cm\EncuestasController::class, 'create'])->name('cm.encuestas.create');
Route::post('/cm/encuestas', [App\Http\Controllers\Cm\EncuestasController::class, 'store'])->name('cm.encuestas.store');
Route::delete('/admin/encuestas/{id}/delete', [App\Http\Controllers\Cm\EncuestasController::class, 'destroy'])->name('cm.encuestas.destroy');

// Sorteos
Route::get('/cm/sorteos', [App\Http\Controllers\Cm\SorteosController::class, 'index'])->name('cm.sorteos.index');

/**
 * User Routes
 */

// Mi cuenta
Route::get('/cuenta', [App\Http\Controllers\Usuario\CuentaController::class, 'index'])->name('usuario.cuenta.index');

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
