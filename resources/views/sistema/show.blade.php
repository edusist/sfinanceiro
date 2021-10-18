@extends('layouts.admin.admin-app')

@section('content')

<h2 class="title-pg">Usuário: <b>{{$objUser->nome}}</b></h2>

<a href="{{route('usuarios.index')}}"><span class="glyphicon glyphicon-fast-backward"></span></a>
<p><b>Id:</b>{{$objUser->id}}</p>
<p><b>Nome: </b>{{$objUser->nome}}</p>
<p><b>Sobrenome: </b>{{$objUser->sobrenome}}</p>
<p><b>Email: </b>{{$objUser->email}}</p>
<p><b>Senha: </b>{{$objUser->senha}}</p>
<p><b>Id Colaborador: </b>{{$objUser->official_id}}</p>
<hr>
<!--Tratamento de erros-->
@if( isset($errors) && count($errors) > 0 )
    <div class="alert alert-danger">
        @foreach($errors->all() as $err)
            <p>{{$err}}</p>
        @endforeach
    </div>
@endif

<!--Formuláriario do deletar 
Unica maneira de deletar um item
-->

{!! Form::open(['route' => ['usuarios.destroy', $objUser->id], 'method' => 'DELETE']) !!}

    {!! Form::submit("Excluir Usuário", ['class' => 'btn btn-danger']) !!}

{!! Form::close() !!}



@endsection