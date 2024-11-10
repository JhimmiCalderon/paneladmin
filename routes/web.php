<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProcesoController;
use App\Http\Controllers\ProcesosController;
use App\Http\Controllers\CajeroController;
use App\Http\Controllers\ServicioController;
use App\Models\Cajero;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\Servicio;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});


Route::post('/login', [LoginController::class,'ingreso'])->name('ingreso');
Route::get('/login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('/logout', [LoginController::class,'logout'])->name('logout');


Route::group(['middleware' => ['auth:web']], function () {
    Route::resource('superadmin',AdminController::class);
    Route::get('/superadmin/buscador', 'AdminController@buscador')->name('superadmin.buscador');
    Route::post('/admins/{id}/cambiar-estado', [AdminController::class, 'cambiarEstado'])->name('superadmin.cambiarEstado');

   
});Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('/historial/show/{empleadoId}', 'EmpleadoController@show')->name('historial.show');
    Route::get('/historialcajero/show/{cajeroId}', 'cajeroController@show')->name('historialcajero.show');
    Route::get('/historialservicio/show/{procesosId}', 'ProcesoController@show')->name('historialservicio.show');
    Route::get('/probarwha',[AdminController::class, 'pruebawhatsapp'])->name('pruebawhatsapp');
  

    route::get('/contraseña',[AdminController::class, 'cambiocontraseña'] )->name('cambiocontraseña');
    route::put('/changepassword/{idadmin}',[AdminController::class, 'changepassword']);
    Route::resource('admin',EmpleadoController::class);
    Route::resource('cajero',CajeroController::class);
    Route::resource('procesos',ProcesoController::class); 
    Route::resource('servicios',ServicioController::class); 
     Route::get('/cajero', [CajeroController::class, 'index'])->name('cajero.index');
    Route::post('/empleados/{id}/cambiar-estado', [EmpleadoController::class, 'cambiarEstado'])->name('admin.cambiarEstado');
    Route::post('/cajeros/{id}/cambiar-estado', [CajeroController::class, 'cambiarEstado'])->name('cajero.cambiarEstado');
});

Route::group(['middleware' => ['auth:empleado']], function () {
    Route::get('/historialpersona/show/{personaId}', 'PersonaController@show')->name('historialpersona.show');
route::get('/contraseñaemple',[EmpleadoController::class, 'cambiocontraseñaempleado'])->name('cambiocontraseñaempleado');
route::put('/changepasswordempleado/{idempleado}',[EmpleadoController::class,'changepasswordempleado']);
    Route::resource('/empleado',PersonaController::class)->except('create');
    Route::get('/index/empleado', [PersonaController::class, 'index'])->name('empleado'); 
    Route::resource('proceso',PersonaController::class); 
    Route::post('/proceso/persona/completo/{procesoId}/{personaId}', [PersonaController::class, 'Completo'])->name('proceso.persona.Completo');;
    Route::post('/proceso/persona/rechazado/{procesoId}/{personaId}', [PersonaController::class, 'Rechazado'])->name('proceso.persona.Rechazado');;

    Route::put('/proceso/agregar-persona/{id}', 'App\Http\Controllers\PersonaController@agregarPersona')->name('proceso.agregarPersona');
    Route::post('/proceso/{procesoId}/persona/{personaId}', 'App\Http\Controllers\PersonaController@detachPersonaFromProceso')->name('proceso.persona.detach');
 


});


Route::group(['middleware' => ['auth:cajero']], function () {
    route::get('/contraseñacajero',[CajeroController::class, 'cambiocontraseñacajero'])->name('cambiocontraseñacajero');
route::put('/changepasswordcajero/{idcajero}',[CajeroController::class,'changepasswordcajero']);
Route::get('/Finalizar', [PersonaController::class, 'Finalizar'])->name('persona.Finalizar');
Route::get('/entregar/{id}', [PersonaController::class, 'entregar'])->name('persona.entregar');

    Route::get('/persona', [PersonaController::class,'indexcajero'])->name('persona.index');
   Route::get('/persona/create', [PersonaController::class, 'create'])->name('persona.create');
    Route::post('/empleado/store', [PersonaController::class, 'store'])->name('empleado.store');
});



 Route::put('/actualizar/{id}', [EmpleadoController::class,'actualizaresta'])->name('actualizarestado');




