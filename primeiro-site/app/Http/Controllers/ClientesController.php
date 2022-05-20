<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;

class ClientesController extends Controller
{
    private int $qtd_por_pagina = 5;

    public function __construct(){

        $this->middleware('permission:cliente-list|cliente-create|cliente-edit|cliente-delete',
                           ['only' => ['index', 'store']]);

        $this->middleware('permission:cliente-create',
                         ['only' => ['create', 'store']]);

        $this->middleware('permission:cliente-edit',
                          ['only' => ['edit', 'update']]);


        $this->middleware('permission:cliente-delete',
                          ['only' => ['destroy']]);
        //Só usuário logado pode acessar
        //$this->middleware('auth');
    }

    public function index(Request $request){

        $clientes = Clientes::orderBy('id', 'DESC')->paginate($this->qtd_por_pagina);

        return view('clients.index', compact('clientes'))
                    ->with('i', ($request->input('page', 1) -1) * $this->qtd_por_pagina);
    }

    public function create(){

        return view('clients.create');
    }

    public function store(Request $request){

        $this->validate($request, ['nome' => 'required',
                                   'email' => 'required |email|unique:clientes,email',
                                   'telefone' => 'required|',
                                   ]);

        $input = $request->all();

        $cliente = Clientes::create($input);

        if(!$cliente){

            return redirect()->route('clients.index')->with('error', 'Erro ao criar o cliente');

        }

        return redirect()->route('clients.index')->with('success', 'Cliente criado com sucesso');

    }

    public function show($id){

        $cliente = Clientes::find($id);

        return view('clients.show', compact('cliente'));
    }

    public function edit($id){

        $cliente = Clientes::find($id);

        return view('clients.edit', compact('cliente'));
    }

    public function update(Request $request, $id){

        $this->validate($request, ['nome' => 'required',
                                   'email' => 'required |email',
                                   'telefone' => 'required']);


        $cliente = Clientes::find($id);
        $input = $request->all();
        $cliente->update($input);

        return redirect()->route('clients.index')->with('success', 'Cliente Atualizado');

    }

    public function destroy($id){

        Clientes::find($id)->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente removido com sucesso');
    }
 }
