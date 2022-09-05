<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
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

Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout');
Route::post('/registrar', 'App\Http\Controllers\Auth\RegisterController@register')->middleware('can:admin.user.create');;
//para admin de usuarios
Route::get('/getroles', 'App\Http\Controllers\Admin\UserController@getRoles');
Route::get('/users', 'App\Http\Controllers\Admin\UserController@index')->middleware('can:admin.user.index');
Route::get('/users/{user}/edit', 'App\Http\Controllers\Admin\UserController@edit')->middleware('can:admin.user.edit');
Route::put('/users/{user}', 'App\Http\Controllers\Admin\UserController@update')->middleware('can:admin.user.edit');
Route::delete('/users/{user}', 'App\Http\Controllers\Admin\UserController@destroy')->middleware('can:admin.user.destroy');

Route::get('/roles', 'App\Http\Controllers\Admin\RoleController@index')->middleware('can:admin.role.index');
Route::post('/rolesregist', 'App\Http\Controllers\Admin\RoleController@store')->middleware('can:admin.role.create');
Route::delete('/roles/{role}', 'App\Http\Controllers\Admin\RoleController@destroy')->middleware('can:admin.role.destroy');
Route::get('/roles/{role}/edit', 'App\Http\Controllers\Admin\RoleController@edit')->middleware('can:admin.role.edit');
Route::put('/roles/{role}', 'App\Http\Controllers\Admin\RoleController@update')->middleware('can:admin.role.edit');

Route::get('/institu', 'App\Http\Controllers\Usuario\InstitucionController@index')->middleware('can:insti.user.index');
Route::get('/institu/{id?}/', 'App\Http\Controllers\Usuario\InstitucionController@index')->middleware('can:insti.user.index');
Route::post('/instituregist', 'App\Http\Controllers\Usuario\InstitucionController@store')->middleware('can:insti.user.create');
//Route::delete('/institu/{id}', 'App\Http\Controllers\Usuario\InstitucionController@destroy')->middleware('can:insti.user.destroy');
Route::get('/institu/{id}/edit', 'App\Http\Controllers\Usuario\InstitucionController@edit')->middleware('can:insti.user.edit');
Route::put('/institu/{id}/{acti?}', 'App\Http\Controllers\Usuario\InstitucionController@update')->middleware('can:insti.user.desactivar');

Route::post('/usuinstregist', 'App\Http\Controllers\Admin\UsuInstController@store')->middleware('can:asiginsti.admin.desactivar');

Route::get('/programa', 'App\Http\Controllers\Usuario\ProgramacionController@index')->middleware('can:program.user.index');
Route::post('/programaregist', 'App\Http\Controllers\Usuario\ProgramacionController@store')->middleware('can:program.user.create');
//Route::delete('/programa/{id}', 'App\Http\Controllers\Usuario\ProgramacionController@destroy')->middleware('can:program.user.destroy');
Route::get('/programa/{flo?}/', 'App\Http\Controllers\Usuario\ProgramacionController@index')->middleware('can:program.user.edit');
Route::get('/programa/{id}/edit', 'App\Http\Controllers\Usuario\ProgramacionController@edit')->middleware('can:program.user.edit');
Route::put('/programa/{progra}/{acti?}', 'App\Http\Controllers\Usuario\ProgramacionController@update')->middleware('can:program.user.desactivar');

Route::get('/progrflota/{insti}/{prog}/{tipo}', 'App\Http\Controllers\Usuario\ProgrFlotaController@index')->middleware('can:proflo.user.index');
Route::post('/progrflotaregist', 'App\Http\Controllers\Usuario\ProgrFlotaController@store')->middleware('can:proflo.user.desactivar');
//Route::delete('/programa/{id}', 'App\Http\Controllers\Usuario\ProgrFlotaController@destroy')->middleware('can:proflo.user.destroy');
//Route::get('/progrflota/{flo?}/', 'App\Http\Controllers\Usuario\ProgrFlotaController@index')->middleware('can:proflo.user.edit');
//Route::get('/progrflota/{id}/edit', 'App\Http\Controllers\Usuario\ProgrFlotaController@edit')->middleware('can:proflo.user.edit');
//Route::put('/progrflota/{progra}/{acti?}', 'App\Http\Controllers\Usuario\ProgrFlotaController@update')->middleware('can:proflo.user.edit');

Route::get('/areaser', 'App\Http\Controllers\Usuario\AreaServicioController@index')->middleware('can:insti.user.index');
//Route::post('/areaserregist', 'App\Http\Controllers\Usuario\AreaServicioController@store')->middleware('can:admin.role.create');
//Route::delete('/areaser/{id}', 'App\Http\Controllers\Usuario\AreaServicioController@destroy')->middleware('can:admin.role.destroy');
//Route::get('/areaser/{id}/edit', 'App\Http\Controllers\Usuario\AreaServicioController@edit')->middleware('can:admin.role.edit');
//Route::put('/areaser/{areaser}', 'App\Http\Controllers\Usuario\AreaServicioController@update')->middleware('can:admin.role.edit');

Route::get('/parroquia', 'App\Http\Controllers\Usuario\ParroquiaController@index')->middleware('can:insti.user.index');
//Route::post('/parroquiaregist', 'App\Http\Controllers\Usuario\ParroquiaController@store')->middleware('can:admin.role.create');
//Route::delete('/parroquia/{id}', 'App\Http\Controllers\Usuario\ParroquiaController@destroy')->middleware('can:admin.role.destroy');
//Route::get('/parroquia/{id}/edit', 'App\Http\Controllers\Usuario\ParroquiaController@edit')->middleware('can:admin.role.edit');
//Route::put('/parroquia/{parroquia}', 'App\Http\Controllers\Usuario\ParroquiaController@update')->middleware('can:admin.role.edit');

//Route::resource('users', UserController::class);


Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');


/* Route::get('/', function () {
    return view('welcome');
}); */

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
