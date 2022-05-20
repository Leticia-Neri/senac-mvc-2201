<?php

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
    return view('welcome');
});

Route::get('/avisos', function (){
    return view('avisos', ['nome' => 'Clientes', 'mostrar' => true,
                'avisos' =>[['id'=> 1, 'cliente' => 'Leticia Lima'],
                            ['id'=> 2, 'aviso' => 'Intervalo'],
                            ['id'=> 3, 'aviso' => 'Final da aula']
                        ]]);
});

Route::get('/index', function () {
    return view('index', ['carousel' => true,
                'forms' => ['nome', 'sobrenome', 'cidade']]);

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('clientes')->group(function(){

    Route::get('listar', [App\Http\Controllers\ClientesController::class, 'listar'])->middleware('auth');
});

Route::group(['middleware' => ['auth']], function(){
    Route::resource('/users', App\Http\Controllers\UserController::class);
    Route::resource('/roles', App\Http\Controllers\RoleController::class);
    Route::resource('/clients', App\Http\Controllers\ClientesController::class);

});

