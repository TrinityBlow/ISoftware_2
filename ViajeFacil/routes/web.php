<?php

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


Route::get('/try', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home','HomeController@index')->name('home');

Route::get('/mi_usuario','MiUsuarioController@index');

Route::post('/mi_usuario/modificar','MiUsuarioController@modificar');

Route::get('/mi_usuario/agregarVehiculo','MiUsuarioController@agregarVehiculo');

Route::get('/mi_usuario/verPassword','MiUsuarioController@verPassword');

Route::post('/mi_usuario/cambiarPassword','MiUsuarioController@cambiarPassword');

Route::get('/viajes/buscarViajes','Viajes@buscarViajes')->name('buscarViajes');

Route::get('/viajes/verDetallesGrupo/{id_grupo}','GruposController@verDetallesGrupo');

Route::get('/viajes/verDetallesViaje/{id_viaje}','Viajes@verDetallesViaje');

Route::post('/pregunta/publicarPregunta','PreguntaController@publicarPregunta');

Route::post('/pregunta/responderPregunta','PreguntaController@responderPregunta');

Route::get('/viajes/crearViaje','Viajes@crearViaje')->name('crearViaje');

Route::post('/viajes/publicarViaje','Viajes@publicarViaje');

Route::post('/viajes/manejarPostulacion','PostulacionesController@manejarPostulacion');

Route::get('/viajes/postularmeViaje/{id}','PostulacionesController@postularmeViaje');

Route::get('/viajes/cancelarPostulacion/{id}','PostulacionesController@cancelarPostulacion');

Route::post('/viajes/rechazarPostulacionViajante','PostulacionesController@rechazarPostulacionViajante');

Route::get('/viajes/eliminarPostulacion/{id}','PostulacionesController@eliminarPostulacion');

Route::get('/viajes/verPostulacionesViaje/{id}','PostulacionesController@verPostulaciones');

Route::get('/postulaciones/misPostulaciones','PostulacionesController@misPostulaciones')->name('misPostulaciones');

Route::post('/postulaciones/calificarViaje','PostulacionesController@calificarViaje');

Route::get('/postulaciones/verViajeros/{id}','PostulacionesController@verViajeros');

Route::post('/postulaciones/calificarViajero','PostulacionesController@calificarViajero');

Route::get('/viajes/misViajes','Viajes@misViajes')->name('misViajes');

Route::get('/viajes/modificarViaje/{id}','GruposController@modificarGrupoId');

Route::post('/viajes/modificarViaje','GruposController@modificarGrupo');

Route::post('/viajes/eliminarViaje','GruposController@eliminarGrupo');

Route::post('/viajes/finalizarViaje','Viajes@finalizarViaje');

Route::get('/viajes/verViajesDetalle/{id}','GruposController@verViajesDetalle');

Route::get('/vehiculos/modificarVehiculo/{id}','VehiculosController@modificarVehiculo');

Route::post('/vehiculos/modificarVehiculo','VehiculosController@modificarVehiculoPorId');

Route::post('/vehiculos/eliminarVehiculo','VehiculosController@eliminarVehiculo');

Route::post('/vehiculo/agregarVehiculo','VehiculosController@agregarVehiculo');

Route::post('/password/resetEmail','Auth\ForgotPasswordController@customResetLink');
