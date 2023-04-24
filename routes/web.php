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
Route::post('/registrar', 'App\Http\Controllers\Auth\RegisterController@register')->middleware(['permission:admin.user.create']);;
//para admin de usuarios
Route::get('/getroles', 'App\Http\Controllers\Admin\UserController@getRoles');
Route::get('/users', 'App\Http\Controllers\Admin\UserController@index')->middleware(['permission:admin.user.index']);
Route::get('/users/{user}/edit', 'App\Http\Controllers\Admin\UserController@edit')->middleware(['permission:admin.user.edit']);
Route::put('/users/{user}', 'App\Http\Controllers\Admin\UserController@update')->middleware(['permission:admin.user.edit']);
Route::delete('/users/{user}', 'App\Http\Controllers\Admin\UserController@destroy')->middleware(['permission:admin.user.destroy']);
Route::post('/changepass/{id}', 'App\Http\Controllers\Admin\UserController@changepass')->middleware(['permission:admin.user.edit']);

Route::get('/roles', 'App\Http\Controllers\Admin\RoleController@index')->middleware(['permission:admin.role.index']);
Route::post('/rolesregist', 'App\Http\Controllers\Admin\RoleController@store')->middleware(['permission:admin.role.create']);
Route::delete('/roles/{role}', 'App\Http\Controllers\Admin\RoleController@destroy')->middleware(['permission:admin.role.destroy']);
Route::get('/roles/{role}/edit', 'App\Http\Controllers\Admin\RoleController@edit')->middleware(['permission:admin.role.edit']);
Route::put('/roles/{role}', 'App\Http\Controllers\Admin\RoleController@update')->middleware(['permission:admin.role.edit']);

Route::get('/institu', 'App\Http\Controllers\Usuario\InstitucionController@index')->middleware(['permission:insti.user.index|insti.user.consul|vehi.user.index']);
Route::get('/institu/{id?}/', 'App\Http\Controllers\Usuario\InstitucionController@index')->middleware(['permission:insti.user.index']);
Route::post('/instituregist', 'App\Http\Controllers\Usuario\InstitucionController@store')->middleware(['permission:insti.user.create']);
//Route::delete('/institu/{id}', 'App\Http\Controllers\Usuario\InstitucionController@destroy')->middleware(['permission:insti.user.destroy']);
Route::get('/institu/{id}/edit', 'App\Http\Controllers\Usuario\InstitucionController@edit')->middleware(['permission:insti.user.edit']);
Route::put('/institu/{id}/{acti?}', 'App\Http\Controllers\Usuario\InstitucionController@update')->middleware(['permission:insti.user.desactivar']);

Route::get('/internacional', 'App\Http\Controllers\Usuario\AtencionEstIntController@index')->middleware(['permission:inter.user.index']);
Route::post('/internalista', 'App\Http\Controllers\Usuario\AtencionEstIntController@lista')->middleware(['permission:inter.user.index']);
Route::post('/internaregist', 'App\Http\Controllers\Usuario\AtencionEstIntController@store')->middleware(['permission:inter.user.create']);

Route::post('/usuinstregist', 'App\Http\Controllers\Admin\UsuInstController@store')->middleware(['permission:asiginsti.admin.desactivar']);

Route::get('/programa', 'App\Http\Controllers\Usuario\ProgramacionController@index')->middleware(['permission:program.user.index|program.user.consul']);
Route::post('/programaregist', 'App\Http\Controllers\Usuario\ProgramacionController@store')->middleware(['permission:program.user.create']);
//Route::delete('/programa/{id}', 'App\Http\Controllers\Usuario\ProgramacionController@destroy')->middleware(['permission:program.user.destroy']);
Route::get('/programa/{flo?}/', 'App\Http\Controllers\Usuario\ProgramacionController@index')->middleware(['permission:program.user.edit|proflo.user.index']);
Route::get('/programa/{id}/edit', 'App\Http\Controllers\Usuario\ProgramacionController@edit')->middleware(['permission:program.user.edit|proflo.user.desactivar']);
Route::get('/programa/{despa?}/{comb?}/comb', 'App\Http\Controllers\Usuario\ProgramacionController@index')->middleware(['permission:despacho.user.index']);
Route::get('/programaxesta', 'App\Http\Controllers\Usuario\ProgramacionController@programaxesta')->middleware(['permission:despaxesta.user.index']);
Route::put('/programa/{progra}/{acti?}', 'App\Http\Controllers\Usuario\ProgramacionController@update')->middleware(['permission:program.user.desactivar']);

Route::get('/persona', 'App\Http\Controllers\Usuario\PersonaController@index')->middleware(['permission:perso.user.index']);
Route::post('/personaregist', 'App\Http\Controllers\Usuario\PersonaController@store')->middleware(['permission:perso.user.create']);
Route::get('/personabyid/{id}', 'App\Http\Controllers\Usuario\PersonaController@consultar')->middleware(['permission:perso.user.edit']);
Route::put('/persona/{id}/{acti?}', 'App\Http\Controllers\Usuario\PersonaController@update')->middleware(['permission:perso.user.desactivar|perso.user.edit']);

Route::get('/trabajador', 'App\Http\Controllers\Usuario\TrabajadorController@index')->middleware(['permission:trab.user.index']);
Route::put('/trabajadordesac/{id}/{acti?}', 'App\Http\Controllers\Usuario\TrabajadorController@update')->middleware(['permission:trab.user.desactivar']);
Route::post('/trabregist', 'App\Http\Controllers\Usuario\TrabajadorController@store')->middleware(['permission:trab.user.create']);
Route::post('/trabasinflota', 'App\Http\Controllers\Usuario\TrabajadorController@trabasinflota')->middleware(['permission:trab.user.edit']);
Route::get('/trabajador/{id}/edit', 'App\Http\Controllers\Usuario\TrabajadorController@edit')->middleware(['permission:trab.user.edit']);
Route::put('/trabajadorupdate/{id}', 'App\Http\Controllers\Usuario\TrabajadorController@trabupdate')->middleware(['permission:trab.user.edit']);

Route::get('/vehiculo', 'App\Http\Controllers\Usuario\VehiculoController@index')->middleware(['permission:vehi.user.index']);
Route::put('/vehiculodesac/{id}/{acti?}', 'App\Http\Controllers\Usuario\VehiculoController@vehiculodesac')->middleware(['permission:vehi.user.desactivar']);
Route::get('/vehixpers/{id}', 'App\Http\Controllers\Usuario\VehiculoController@consulxpers')->middleware(['permission:perso.user.asigauto']);
Route::get('/vehiculo/{id}/edit', 'App\Http\Controllers\Usuario\VehiculoController@edit')->middleware(['permission:perso.user.edit']);
Route::put('/vehixpers/{id}/{unico}', 'App\Http\Controllers\Usuario\VehiculoController@update')->middleware(['permission:perso.user.asigauto']);
Route::put('/vehiupdate/{id}', 'App\Http\Controllers\Usuario\VehiculoController@vehiupdate')->middleware(['permission:perso.user.edit']);
Route::post('/vehiregist', 'App\Http\Controllers\Usuario\VehiculoController@store')->middleware(['permission:vehi.user.create']);

Route::get('/persoymodel', 'App\Http\Controllers\Usuario\VehiculoController@persoymodel')->middleware(['permission:vehi.user.index']);

Route::get('/progrflota/{insti}/{prog}/{tipo}', 'App\Http\Controllers\Usuario\ProgrFlotaController@index')->middleware(['permission:proflo.user.index|despacho.user.index']);
Route::get('/progrflotaxesta/{fecha}/{insti}', 'App\Http\Controllers\Usuario\ProgrFlotaController@progflotxesta')->middleware(['permission:despaxesta.user.edit']);
Route::post('/progrflotaregist', 'App\Http\Controllers\Usuario\ProgrFlotaController@store')->middleware(['permission:proflo.user.desactivar|despacho.user.edit']);
Route::post('/progrflotaregistxesta', 'App\Http\Controllers\Usuario\ProgrFlotaController@storexesta')->middleware(['permission:despaxesta.user.edit']);
//Route::delete('/programa/{id}', 'App\Http\Controllers\Usuario\ProgrFlotaController@destroy')->middleware(['permission:proflo.user.destroy']);
//Route::get('/progrflota/{flo?}/', 'App\Http\Controllers\Usuario\ProgrFlotaController@index')->middleware(['permission:proflo.user.edit']);
//Route::get('/progrflota/{id}/edit', 'App\Http\Controllers\Usuario\ProgrFlotaController@edit')->middleware(['permission:proflo.user.edit']);
//Route::put('/progrflota/{progra}/{acti?}', 'App\Http\Controllers\Usuario\ProgrFlotaController@update')->middleware(['permission:proflo.user.edit']);

Route::get('/reporteproflota', 'App\Http\Controllers\Usuario\ProgrFlotaController@reporteParam')->middleware('can:proflorep.user.index');
Route::post('/progrflotarep', 'App\Http\Controllers\Usuario\ProgrFlotaController@reporte')->middleware('can:proflorep.user.index');

Route::get('/areaser', 'App\Http\Controllers\Usuario\AreaServicioController@index')->middleware(['permission:insti.user.index']);
//Route::post('/areaserregist', 'App\Http\Controllers\Usuario\AreaServicioController@store')->middleware(['permission:admin.role.create']);
//Route::delete('/areaser/{id}', 'App\Http\Controllers\Usuario\AreaServicioController@destroy')->middleware(['permission:admin.role.destroy']);
//Route::get('/areaser/{id}/edit', 'App\Http\Controllers\Usuario\AreaServicioController@edit')->middleware(['permission:admin.role.edit']);
//Route::put('/areaser/{areaser}', 'App\Http\Controllers\Usuario\AreaServicioController@update')->middleware(['permission:admin.role.edit']);

Route::get('/parroquia', 'App\Http\Controllers\Usuario\ParroquiaController@index')->middleware(['permission:insti.user.index']);
//Route::post('/parroquiaregist', 'App\Http\Controllers\Usuario\ParroquiaController@store')->middleware(['permission:admin.role.create']);
//Route::delete('/parroquia/{id}', 'App\Http\Controllers\Usuario\ParroquiaController@destroy')->middleware(['permission:admin.role.destroy']);
//Route::get('/parroquia/{id}/edit', 'App\Http\Controllers\Usuario\ParroquiaController@edit')->middleware(['permission:admin.role.edit']);
//Route::put('/parroquia/{parroquia}', 'App\Http\Controllers\Usuario\ParroquiaController@update')->middleware(['permission:admin.role.edit']);

//Route::resource('users', UserController::class);


Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');


/* Route::get('/', function () {
    return view('welcome');
}); */

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
