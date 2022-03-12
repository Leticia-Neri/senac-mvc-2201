@extends('layouts.exericio-layout')
@section('title', 'Raças de cachorro')
@section('sidebar')
    @parent
    <hr>
@endsection
@section('content')

    @if($mostrar)
    <div class="alert alert-danger" role="alert">
        Atenção:segue raças de cachorros abaixo
    </div>
    @else
    <div></div>
    @endif

    <table class="table">
        <tr><td>Quadro de Avisos de {{$nome}}</td></tr>

        @foreach($racas as $raca)
        <tr><td>Raça #{{$raca['id']}} <br> {{$raca['raca']}}</td></tr>
        @endforeach

        <?php
            foreach($nomes as $nome){
                echo "<tr><td>Apelido #{$nome['id']} <br>{$nome['nome']} <td></tr>\n";

            }
        ?>

        

    </table>

@endsection