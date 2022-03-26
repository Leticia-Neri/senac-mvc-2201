<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;


class ClientesController extends Controller
{

    /*
    public function __construct(){
        $this->middleware('auth');
    }
    */

    public function listar(){
        $clientes = Clientes::all();
        //Atenção! clientes/listar.blade.php vira clientes.listar
        return view('clientes.listar', ['clientes'=>$clientes]);
    }
}