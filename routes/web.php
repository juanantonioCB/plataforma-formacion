<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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

/* Route::get('/', function () {
    return view('index');
}); */

Route::get('cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('route:clear');
	$exitCode = Artisan::call('route:cache');
});

Route::get('stor', function () {
    $exitCode = Artisan::call('storage:link');
});

Route::get('autoload', function () {
    $exitCode = Artisan::call('package:discover --ansi');
});

Route::get('/', [Controller::class, 'index'])->name('index');
Route::get('/curso/{uuid}', [Controller::class, 'curso'])->name('curso');
Route::post('/enviarRegistro', [Controller::class, 'enviarRegistro'])->name('enviarRegistro');
Route::get('/perfil', [Controller::class, 'modalPerfil'])->name('modalPerfil');
Route::post('/guardarPerfil', [Controller::class, 'guardarPerfil'])->name('guardarPerfil');
Route::post('/inscripcionCurso', [Controller::class, 'inscripcionCurso'])->name('inscripcionCurso');
Route::get('/terminos-uso', [Controller::class, 'terminos'])->name('terminos');
Route::get('/politica-privacidad', [Controller::class, 'politica'])->name('politica');

Route::post('/cerrarSesion', [Controller::class, 'cerrarSesion'])->name('cerrarSesion');
Route::post('/obtenerMedalla', [Controller::class, 'obtenerMedalla'])->name('obtenerMedalla');
Route::get('/irAlCurso', [Controller::class, 'irAlCurso'])->name('irAlCurso');
Route::get('/irAlForo', [Controller::class, 'irAlForo'])->name('irAlForo');
Route::get('/salirOut', [Controller::class, 'salirOut'])->name('salirOut');

/* Route::get('/admin', [Controller::class, 'test'])->middleware(['keycloak-web'])->name('test');
Route::get('/admin12', [Controller::class, 'test12'])->middleware(['keycloak-web'])->name('test12');
Route::get('/admin13', [Controller::class, 'test13'])->name('test13'); */





