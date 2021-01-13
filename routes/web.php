<?php

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

Auth::routes(['verify' => true]);

Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [App\Http\Controllers\Auth\FacebookController::class, 'redirectToProvider']);
Route::get('auth/facebook/callback', [App\Http\Controllers\Auth\FacebookController::class, 'handleProviderCallback']);

/**
 * Admin Routes
 */

// Inicio
Route::get('/admin', [App\Http\Controllers\Administrador\HomeController::class, 'index'])->name('admin.index');
Route::get('/actualizacion/diaria', [App\Http\Controllers\Administrador\HomeController::class, 'actualizacionDiaria'])->name('admin.actualizacion.diaria');

// Noticias
Route::get('/admin/noticias', [App\Http\Controllers\Administrador\NoticiasController::class, 'index'])->name('admin.noticias.index');
Route::get('/admin/noticia/nueva', [App\Http\Controllers\Administrador\NoticiasController::class, 'create'])->name('admin.noticias.create');
Route::post('/admin/noticia/upload', [App\Http\Controllers\Administrador\NoticiasController::class, 'upload'])->name('admin.noticias.upload');
Route::post('/admin/noticia/nueva', [App\Http\Controllers\Administrador\NoticiasController::class, 'store'])->name('admin.noticias.store');
Route::get('/admin/noticia/{id}/edit', [App\Http\Controllers\Administrador\NoticiasController::class, 'edit'])->name('admin.noticias.edit');
Route::patch('/admin/noticia/{id}/update', [App\Http\Controllers\Administrador\NoticiasController::class, 'update'])->name('admin.noticias.update');
Route::delete('/admin/noticia/{id}/delete', [App\Http\Controllers\Administrador\NoticiasController::class, 'destroy'])->name('admin.noticias.destroy');
Route::patch('/admin/noticia/{id}/destacar', [App\Http\Controllers\Administrador\NoticiasController::class, 'destacar'])->name('admin.noticias.destacar');

// Usuarios
Route::get('/admin/usuarios', [App\Http\Controllers\Administrador\UsuariosController::class, 'index'])->name('admin.usuarios.index');
Route::get('/admin/usuario/nuevo', [App\Http\Controllers\Administrador\UsuariosController::class, 'create'])->name('admin.usuarios.create');
Route::post('/admin/usuario/nuevo', [App\Http\Controllers\Administrador\UsuariosController::class, 'store'])->name('admin.usuarios.store');
Route::get('/admin/usuario/{id}/edit', [App\Http\Controllers\Administrador\UsuariosController::class, 'edit'])->name('admin.usuarios.edit');
Route::patch('/admin/usuario/{id}/update', [App\Http\Controllers\Administrador\UsuariosController::class, 'update'])->name('admin.usuarios.update');
Route::delete('/admin/usuario/{id}/delete', [App\Http\Controllers\Administrador\UsuariosController::class, 'destroy'])->name('admin.usuarios.destroy');
Route::post('/admin/usuario/{id}/ban', [App\Http\Controllers\Administrador\UsuariosController::class, 'ban'])->name('admin.usuarios.ban');
Route::post('/admin/usuario/{id}/unban', [App\Http\Controllers\Administrador\UsuariosController::class, 'unban'])->name('admin.usuarios.unban');

// Desarrolladoras
Route::get('/admin/desarrolladoras', [App\Http\Controllers\Administrador\DesarrolladorasController::class, 'index'])->name('admin.desarrolladoras.index');
Route::post('/admin/desarrolladora/{id}/ban', [App\Http\Controllers\Administrador\DesarrolladorasController::class, 'ban'])->name('admin.desarrolladora.ban');
Route::post('/admin/desarrolladora/{id}/unban', [App\Http\Controllers\Administrador\DesarrolladorasController::class, 'unban'])->name('admin.desarrolladora.unban');

// Juegos
Route::get('/admin/juegos', [App\Http\Controllers\Administrador\JuegosController::class, 'index'])->name('admin.juegos.index');
Route::post('/admin/juego/{id}/ban', [App\Http\Controllers\Administrador\JuegosController::class, 'ban'])->name('admin.juego.ban');
Route::post('/admin/juego/{id}/unban', [App\Http\Controllers\Administrador\JuegosController::class, 'unban'])->name('admin.juego.unban');

// Campañas
Route::get('/admin/campanias', [App\Http\Controllers\Administrador\CampaniasController::class, 'index'])->name('admin.campanias.index');
Route::post('/admin/campania/{id}/ban', [App\Http\Controllers\Administrador\CampaniasController::class, 'ban'])->name('admin.campania.ban');
Route::post('/admin/campania/{id}/unban', [App\Http\Controllers\Administrador\CampaniasController::class, 'unban'])->name('admin.campania.unban');

// Logros
Route::get('/admin/logros', [App\Http\Controllers\Administrador\LogrosController::class, 'index'])->name('admin.logros.index');
Route::get('/admin/logro/nuevo', [App\Http\Controllers\Administrador\LogrosController::class, 'create'])->name('admin.logros.create');
Route::post('/admin/logro/nuevo', [App\Http\Controllers\Administrador\LogrosController::class, 'store'])->name('admin.logros.store');
Route::post('/admin/logro/{id}/edit', [App\Http\Controllers\Administrador\LogrosController::class, 'edit'])->name('admin.logros.edit');
Route::patch('/admin/logro/{id}/update', [App\Http\Controllers\Administrador\LogrosController::class, 'update'])->name('admin.logros.update');
Route::delete('/admin/logro/{id}/delete', [App\Http\Controllers\Administrador\LogrosController::class, 'destroy'])->name('admin.logros.destroy');

// Géneros
Route::get('/admin/generos', [App\Http\Controllers\Administrador\GenerosController::class, 'index'])->name('admin.generos.index');
Route::get('/admin/genero/nuevo', [App\Http\Controllers\Administrador\GenerosController::class, 'create'])->name('admin.generos.create');
Route::post('/admin/genero/nuevo', [App\Http\Controllers\Administrador\GenerosController::class, 'store'])->name('admin.generos.store');
Route::get('/admin/genero/{id}/edit', [App\Http\Controllers\Administrador\GenerosController::class, 'edit'])->name('admin.generos.edit');
Route::patch('/admin/genero/{id}/update', [App\Http\Controllers\Administrador\GenerosController::class, 'update'])->name('admin.generos.update');
Route::delete('/admin/genero/{id}/delete', [App\Http\Controllers\Administrador\GenerosController::class, 'destroy'])->name('admin.generos.destroy');

// Solicitudes
Route::get('/admin/solicitudes', [App\Http\Controllers\Administrador\SolicitudesController::class, 'index'])->name('admin.solicitudes.index');
Route::post('/admin/solicitud/desarrolladora/aceptar', [App\Http\Controllers\Administrador\SolicitudesController::class, 'aceptarDesarrolladora'])->name('admin.solicitud.aceptarDesarrolladora');
Route::delete('/admin/solicitud/desarrolladora/rechazar', [App\Http\Controllers\Administrador\SolicitudesController::class, 'rechazarDesarrolladora'])->name('admin.solicitud.rechazarDesarrolladora');
Route::post('/admin/solicitud/master/aceptar', [App\Http\Controllers\Administrador\SolicitudesController::class, 'aceptarMaster'])->name('admin.solicitud.aceptarMaster');
Route::delete('/admin/solicitud/master/rechazar', [App\Http\Controllers\Administrador\SolicitudesController::class, 'rechazarMaster'])->name('admin.solicitud.rechazarMaster');

// Reportes
Route::get('/admin/reportes', [App\Http\Controllers\Administrador\ReportesController::class, 'index'])->name('admin.reportes.index');
Route::get('/admin/reporte', [App\Http\Controllers\Administrador\ReportesController::class, 'show'])->name('admin.reporte.show');
Route::get('/admin/reporte/cancelar', [App\Http\Controllers\Administrador\ReportesController::class, 'cancelar'])->name('admin.reporte.cancelar');
Route::get('/admin/reporte/aceptar', [App\Http\Controllers\Administrador\ReportesController::class, 'aceptar'])->name('admin.reporte.aceptar');

/**
 * Cm Routes
 */

// Inicio
Route::get('/cm', [App\Http\Controllers\Cm\HomeController::class, 'index'])->name('cm.index');

// Desarrolladora
Route::get('/cm/desarrolladora', [App\Http\Controllers\Cm\DesarrolladoraController::class, 'index'])->name('cm.desarrolladora.index');
Route::patch('/cm/desarrolladora/{id}/update', [App\Http\Controllers\Cm\DesarrolladoraController::class, 'update'])->name('cm.desarrolladora.update');
Route::post('/cm/desarrolladora/upload', [App\Http\Controllers\Cm\DesarrolladoraController::class, 'upload'])->name('cm.desarrolladora.upload');

// Sorteos
Route::get('/cm/sorteos', [App\Http\Controllers\Cm\SorteosController::class, 'index'])->name('cm.sorteos.index');
Route::get('/cm/sorteo/nuevo', [App\Http\Controllers\Cm\SorteosController::class, 'create'])->name('cm.sorteo.create');
Route::post('/cm/sorteo/store', [App\Http\Controllers\Cm\SorteosController::class, 'store'])->name('cm.sorteo.store');
Route::get('/cm/sorteo/{id}/edit', [App\Http\Controllers\Cm\SorteosController::class, 'edit'])->name('cm.sorteo.edit');
Route::patch('/cm/sorteo/{id}/update', [App\Http\Controllers\Cm\SorteosController::class, 'update'])->name('cm.sorteo.update');
Route::get('/cm/sorteo/{id}/finish', [App\Http\Controllers\Cm\SorteosController::class, 'finish'])->name('cm.sorteo.finish');

// Noticias
Route::get('/cm/noticias', [App\Http\Controllers\Cm\NoticiasController::class, 'index'])->name('cm.noticias.index');
Route::get('/cm/{tipo}/noticia/{id}/nueva', [App\Http\Controllers\Cm\NoticiasController::class, 'create'])->name('cm.noticia.create');
Route::post('/cm/{tipo}/noticia/{id}/nueva', [App\Http\Controllers\Cm\NoticiasController::class, 'store'])->name('cm.noticia.store');
Route::get('/cm/noticia/{id}/edit', [App\Http\Controllers\Cm\NoticiasController::class, 'edit'])->name('cm.noticia.edit');
Route::patch('/cm/noticia/{id}/update', [App\Http\Controllers\Cm\NoticiasController::class, 'update'])->name('cm.noticia.update');
Route::delete('/cm/noticia/{id}/delete', [App\Http\Controllers\Cm\NoticiasController::class, 'destroy'])->name('cm.noticia.destroy');
Route::post('/cm/noticia/upload', [App\Http\Controllers\Cm\NoticiasController::class, 'upload'])->name('cm.noticia.upload');

// Juegos
Route::get('/cm/juegos', [App\Http\Controllers\Cm\JuegosController::class, 'index'])->name('cm.juegos.index');
Route::get('/cm/juego/{id}', [App\Http\Controllers\Cm\JuegosController::class, 'show'])->name('cm.juego.show');
Route::get('/cm/juego/nuevo', [App\Http\Controllers\Cm\JuegosController::class, 'create'])->name('cm.juego.create');
Route::post('/cm/juego/upload', [App\Http\Controllers\Cm\JuegosController::class, 'upload'])->name('cm.juego.upload');
Route::post('/cm/juego/store', [App\Http\Controllers\Cm\JuegosController::class, 'store'])->name('cm.juego.store');
Route::patch('/cm/juego/{id}/update', [App\Http\Controllers\Cm\JuegosController::class, 'update'])->name('cm.juego.update');
Route::delete('/cm/juego/{id}/delete', [App\Http\Controllers\Cm\JuegosController::class, 'destroy'])->name('cm.juego.destroy');
Route::post('/claves/importar',[App\Http\Controllers\Cm\JuegosController::class, 'importar'])->name('cm.claves.import');
Route::delete('/clave/{id}/delete',[App\Http\Controllers\Cm\JuegosController::class, 'claveDestroy'])->name('cm.clave.destroy');
Route::delete('/claves/{id}/delete',[App\Http\Controllers\Cm\JuegosController::class, 'clavesDestroy'])->name('cm.claves.destroy');

// Campañas
Route::get('/cm/campanias', [App\Http\Controllers\Cm\CampaniasController::class, 'index'])->name('cm.campanias.index');
Route::get('/cm/campania/{id}', [App\Http\Controllers\Cm\CampaniasController::class, 'show'])->name('cm.campania.show');
Route::get('/cm/campania/nuevo', [App\Http\Controllers\Cm\CampaniasController::class, 'create'])->name('cm.campania.create');
Route::post('/cm/campania/store', [App\Http\Controllers\Cm\CampaniasController::class, 'store'])->name('cm.campania.store');
Route::patch('/cm/campania/{id}/update', [App\Http\Controllers\Cm\CampaniasController::class, 'update'])->name('cm.campania.update');
Route::delete('/cm/campania/{id}/delete', [App\Http\Controllers\Cm\CampaniasController::class, 'destroy'])->name('cm.campania.destroy');

// Encuestas
Route::get('/cm/encuestas', [App\Http\Controllers\Cm\EncuestasController::class, 'index'])->name('cm.encuestas.index');
Route::get('/cm/encuesta/nuevo', [App\Http\Controllers\Cm\EncuestasController::class, 'create'])->name('cm.encuestas.create');
Route::post('/cm/encuesta', [App\Http\Controllers\Cm\EncuestasController::class, 'store'])->name('cm.encuestas.store');
Route::delete('/cm/encuesta/{id}/delete', [App\Http\Controllers\Cm\EncuestasController::class, 'destroy'])->name('cm.encuestas.destroy');
Route::get('/cm/encuesta/{id}/finish', [App\Http\Controllers\Cm\EncuestasController::class, 'finish'])->name('cm.encuesta.finish');

// Sorteos
Route::get('/cm/sorteos', [App\Http\Controllers\Cm\SorteosController::class, 'index'])->name('cm.sorteos.index');

/**
 * Master Routes
 */

// Inicio
Route::get('/master', [App\Http\Controllers\Master\HomeController::class, 'index'])->name('master.index');

// Perfil
Route::get('/master/perfil', [App\Http\Controllers\Master\PerfilController::class, 'index'])->name('master.perfil.index');
Route::patch('/master/perfil/update', [App\Http\Controllers\Master\PerfilController::class, 'update'])->name('master.perfil.update');

// Quitar id al update y encontrarlo en el controller

// Posts
Route::get('/master/analisis', [App\Http\Controllers\Master\AnalisisController::class, 'index'])->name('master.analisis.index');
Route::get('/master/analisis/nueva/{id?}', [App\Http\Controllers\Master\AnalisisController::class, 'create'])->name('master.analisis.create');
Route::post('/master/analisis/upload', [App\Http\Controllers\Master\AnalisisController::class, 'upload'])->name('master.analisis.upload');
Route::post('/master/analisis/nueva', [App\Http\Controllers\Master\AnalisisController::class, 'store'])->name('master.analisis.store');
Route::get('/master/analisis/{id}/edit', [App\Http\Controllers\Master\AnalisisController::class, 'edit'])->name('master.analisis.edit');
Route::patch('/master/analisis/{id}/update', [App\Http\Controllers\Master\AnalisisController::class, 'update'])->name('master.analisis.update');
Route::delete('/master/analisis/{id}/delete', [App\Http\Controllers\Master\AnalisisController::class, 'destroy'])->name('master.analisis.destroy');

// Estado
Route::post('/master/estado/nuevo', [App\Http\Controllers\Master\EstadosController::class, 'store'])->name('master.estado.store');
Route::delete('/master/posts/{id}/delete', [App\Http\Controllers\Master\EstadosController::class, 'destroy'])->name('master.estado.destroy');

// Añadir a la tabla posts un atributo que sea fecha de publicación para programar una publicación futura

/**
 * User Routes
 */

// Inicio
Route::get('/', [App\Http\Controllers\Usuario\HomeController::class, 'index'])->name('index');
Route::get('/home', [App\Http\Controllers\Usuario\HomeController::class, 'home'])->name('home')->middleware('auth');
Route::get('/busqueda', [App\Http\Controllers\Usuario\HomeController::class, 'busqueda'])->name('usuario.busqueda');
Route::get('/acerca', [App\Http\Controllers\Usuario\HomeController::class, 'acerca'])->name('usuario.acerca');
Route::get('/faq', [App\Http\Controllers\Usuario\HomeController::class, 'faq'])->name('usuario.faq');
Route::get('/desarrolladora/solicitud', [App\Http\Controllers\Usuario\HomeController::class, 'desarrolladora'])->name('usuario.desarrolladora');
Route::get('/master/solicitud', [App\Http\Controllers\Usuario\HomeController::class, 'master'])->name('usuario.master');


// Mi cuenta
Route::get('/cuenta/{seccion?}', [App\Http\Controllers\Usuario\CuentaController::class, 'index'])->name('usuario.cuenta.index');
Route::post('/cuenta/generos', [App\Http\Controllers\Usuario\CuentaController::class, 'generos'])->name('usuario.cuenta.generos');
Route::patch('/cuenta/usuario', [App\Http\Controllers\Usuario\CuentaController::class, 'usuario'])->name('usuario.cuenta.usuario');

// Desarrolladoras
Route::get('/desarrolladoras', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'index'])->name('usuario.desarrolladoras.index');
Route::get('/desarrolladoras/lista', [App\Http\Controllers\Usuario\BuscadorController::class, 'desarrolladoras'])->name('usuario.desarrolladoras.all');
Route::get('/desarrolladora/{id}', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'show'])->name('usuario.desarrolladora.show');
Route::post('/desarrolladora/{id}/follow', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'follow'])->name('usuario.desarrolladora.follow')->middleware('auth');
Route::post('/desarrolladora/{id}/unfollow', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'unfollow'])->name('usuario.desarrolladora.unfollow')->middleware('auth');
Route::post('/desarrolladora/{id}/{notificacion}', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'notificacion'])->name('usuario.desarrolladora.notificacion')->middleware('auth');
Route::post('/desarrolladoras/sorteo', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'sorteo'])->name('usuario.desarrolladora.sorteo')->middleware('auth');
Route::post('/desarrolladoras/encuesta', [App\Http\Controllers\Usuario\DesarrolladorasController::class, 'encuesta'])->name('usuario.desarrolladora.encuesta')->middleware('auth');

// Solicitudes
Route::get('/solicitud/{tipo}', [App\Http\Controllers\Usuario\SolicitudesController::class, 'create'])->name('usuario.solicitud.create')->middleware('auth', 'solicitud', 'verified');
Route::post('/solicitud/store', [App\Http\Controllers\Usuario\SolicitudesController::class, 'store'])->name('usuario.solicitud.store')->middleware('auth', 'solicitud', 'verified');

// Juegos
Route::get('/juegos', [App\Http\Controllers\Usuario\JuegosController::class, 'index'])->name('usuario.juegos.index');
Route::get('/juegos/lista/{genero?}', [App\Http\Controllers\Usuario\BuscadorController::class, 'juegos'])->name('usuario.juegos.all');
Route::get('/juego/{id}', [App\Http\Controllers\Usuario\JuegosController::class, 'show'])->name('usuario.juego.show');
Route::post('/juego/{id}/follow', [App\Http\Controllers\Usuario\JuegosController::class, 'follow'])->name('usuario.juego.follow')->middleware('auth');
Route::post('/juego/{id}/unfollow', [App\Http\Controllers\Usuario\JuegosController::class, 'unfollow'])->name('usuario.juego.unfollow')->middleware('auth');
Route::post('/juego/{id}/{notificacion}', [App\Http\Controllers\Usuario\JuegosController::class, 'notificacion'])->name('usuario.juego.notificacion')->middleware('auth');
Route::post('/juego/calificar', [App\Http\Controllers\Usuario\JuegosController::class, 'calificar'])->name('usuario.juego.calificar')->middleware('auth');

// Master
Route::get('/masters', [App\Http\Controllers\Usuario\MasterController::class, 'index'])->name('usuario.masters.index');
Route::get('/masters/lista', [App\Http\Controllers\Usuario\BuscadorController::class, 'masters'])->name('usuario.masters.all');
Route::get('/master/{id}', [App\Http\Controllers\Usuario\MasterController::class, 'show'])->name('usuario.master.show');
Route::post('/master/{id}/follow', [App\Http\Controllers\Usuario\MasterController::class, 'follow'])->name('usuario.master.follow')->middleware('auth');
Route::post('/master/{id}/unfollow', [App\Http\Controllers\Usuario\MasterController::class, 'unfollow'])->name('usuario.master.unfollow')->middleware('auth');
Route::post('/master/{id}/{notificacion}', [App\Http\Controllers\Usuario\MasterController::class, 'notificacion'])->name('usuario.master.notificacion')->middleware('auth');

// Campanias
Route::get('/campanias/lista', [App\Http\Controllers\Usuario\BuscadorController::class, 'campanias'])->name('usuario.campanias.all');
Route::get('/campania/{i}', [App\Http\Controllers\Usuario\CampaniasController::class, 'show'])->name('usuario.campania.show');
Route::post('/campania/foro/nuevo', [App\Http\Controllers\Usuario\CampaniasController::class, 'store'])->name('usuario.foro.store');
Route::get('/campania/{id}/actualizacion', [App\Http\Controllers\Usuario\CampaniasController::class, 'actualizacion'])->name('usuario.campania.actualizacion');

// Reportes
Route::post('/reporte', [App\Http\Controllers\Usuario\ReportesController::class, 'reporte'])->name('usuario.reporte');

// Mensajes
Route::post('/mensaje/nuevo', [App\Http\Controllers\Usuario\MensajesController::class, 'store'])->name('usuario.mensaje.store');

// Posts
Route::post('/post', [App\Http\Controllers\Usuario\PostsController::class, 'show'])->name('usuario.post.show');

// Pagos
Route::post('/pago',[App\Http\Controllers\Usuario\PaymentController::class, 'payWithPaypal'])->name('usuario.paypal.pagar');
Route::get('/pago/status',[App\Http\Controllers\Usuario\PaymentController::class, 'paypalStatus'])->name('usuario.paypal.status');
