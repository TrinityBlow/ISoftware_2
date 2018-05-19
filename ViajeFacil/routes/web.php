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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/mi_usuario', 'MiUsuarioController@index');

Route::post('/mi_usuario/modificar','MiUsuarioController@modificar');


Route::get('/viajes/verDetallesViaje/{id_viaje}','Viajes@verDetallesViaje');

Route::get('/mi_usuario/agregarVehiculo','MiUsuarioController@agregarVehiculo');

Route::get('/viajes/buscarViajes','Viajes@buscarViajes')->name('buscarViajes');

Route::get('/viajes/crearViaje','Viajes@crearViaje')->name('crearViaje');

Route::get('/vehiculos/modificarVehiculo/{id}','VehiculosController@modificarVehiculo');

Route::post('/vehiculos/modificarVehiculo','VehiculosController@modificarVehiculoPorId');

Route::get('/vehiculos/eliminarVehiculo/{id}','VehiculosController@eliminarVehiculo');

Route::post('/vehiculo/agregarVehiculo','VehiculosController@agregarVehiculo');


