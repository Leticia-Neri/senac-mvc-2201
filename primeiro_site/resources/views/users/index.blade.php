@extends('layouts.app') // This is the layout file used for the application

@section('content') // This is the content section of the layout file

<div class="row"> // This is the row section of the page
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Usuários</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('users.create') }}"> + Novo usuário</a>
        </div>
    </div>
</div>

<br>

@if ($message = Session::get('success'))

<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>

@endif


<table class="table table-bordered">

 <tr>
   <th>ID</th>
   <th>Nome</th>
   <th>Email</th>
   <th>Perfil</th>
   <th width="280px">Ação</th>
 </tr>

 @foreach ($data as $key => $user)

  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>

      @if(!empty($user->getRoleNames())) // This is the method that returns the roles of the user

        @foreach($user->getRoleNames() as $v)

           <label class="badge badge-success">{{ $v }}</label>

        @endforeach

      @endif

    </td>

    <td>
       <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Mostrar</a>
       <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Editar</a>

        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}

            {!! Form::submit('Apagar', ['class' => 'btn btn-danger']) !!}

        {!! Form::close() !!}

    </td>
  </tr>

 @endforeach

</table>

{!! $data->render() !!}

@endsection