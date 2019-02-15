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

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('/', [
//    'uses' => 'HomeController@home',
//    'as' => 'home_path',
//]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', [
    'uses' => 'HomeController@index',
    'as' => 'home_path',
]);
Route::get('/admin', [
    'uses' => 'adminController@index',
    'as' => 'admin_index_path',
]);
Route::get('/admin/comunidad/nuevo', [
    'uses' => 'ComunidadController@nuevo',
    'as' => 'comunidad_nuevo_path',
]);
Route::post('/admin/comunidad/nuevo', [
    'uses' => 'ComunidadController@store',
    'as' => 'comunidad_store_path',
]);
Route::get('/admin/comunidad/lista', [
    'uses' => 'ComunidadController@getComunidades',
    'as' => 'comunidad_lista_path',
]);
Route::post('admin/comunidad/mostrar-provincias', [
    'uses' => 'ComunidadController@mostrarProvincias',
    'as' => 'comunidad_mostrar_provincias_path',
]);
Route::post('admin/comunidad/mostrar-distritos', [
    'uses' => 'ComunidadController@mostrarDistritos',
    'as' => 'comunidad_mostrar_distritos_path',
]);
Route::post('/admin/comunidad/editar', [
    'uses' => 'ComunidadController@editar',
    'as' => 'comunidad_editar_path',
]);
Route::get('/admin/comunidad/editar/imagen/{filename}', [
    'uses' => 'ComunidadController@getFoto',
    'as' => 'comunidad_editar_imagen_path',
]);
Route::get('/admin/comunidad/delete/{id}', [
    'uses' => 'ComunidadController@getDelete',
    'as' => 'comunidad.lista.delete',
]);

// rutas para actividades
Route::get('/admin/actividad/nuevo', [
    'uses' => 'ActividadController@nuevo',
    'as' => 'actividad_nuevo_path',
]);
Route::post('/admin/actividad/nuevo', [
    'uses' => 'ActividadController@store',
    'as' => 'actividad_store_path',
]);
Route::get('/admin/actividad/lista', [
    'uses' => 'ActividadController@getActividades',
    'as' => 'actividad_lista_path',
]);
Route::get('/admin/actividad/delete/{id}', [
    'uses' => 'ActividadController@getDelete',
    'as' => 'actividad.lista.delete',
]);
