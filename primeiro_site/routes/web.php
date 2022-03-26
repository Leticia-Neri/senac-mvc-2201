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

Route::get('/avisos', function(){
    return view('avisos', ['nome' => 'Leticia', 'mostrar' => true, 'avisos' => [['id' => 1, 'aviso'=>'lalalal'],
                                                                               ['id' => 2, 'aviso' => 'dscjsdjc'],
                                                                               ['id' => 3, 'aviso'=>'dskfvndkvnkdnvkdnvkndvkndkvndk']]]);
});


Route::get('/cachorro', function(){
    return view('cachorros', ['nome' => 'Raças de Doguinhos', 'mostrar' => true, 'racas' => [['id' => 1, 'raca'=>'Golden'],
                                                                                            ['id' => 2, 'raca' => 'Shih tzu'],
                                                                                            ['id' => 3, 'raca'=>'Srd']],
                                                                                'nomes'=> [['id' => 1, 'nome'=>'Le'],
                                                                                          ['id' => 2, 'nome' => 'Leo'],
                                                                                          ['id' => 3, 'nome'=>'Ra'],['id' => 4, 'nome'=>'Gui'] ] ]);
});




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('clientes')->group(function(){
    Route::get('/listar', [App\Http\Controllers\ClientesController::class, 'listar'])->middleware('auth'); //Listando os dados do banco de dados. 
});
