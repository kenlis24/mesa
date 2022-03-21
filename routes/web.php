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

//Route::resource('users', UserController::class);


Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');


/* Route::get('/', function () {
    return view('welcome');
}); */

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
