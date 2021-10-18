@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg">Banco: <b>{{$objEmpBanco->nome}}</b></h2>

<a href="{{route('empresa_banco_ctrl.index')}}"><span class="glyphicon glyphicon-fast-backward"></span></a>
<p><b>Id:</b>{{$objEmpBanco->id}}</p>
<p><b>Nome: </b>{{$objEmpBanco->nome}}</p>
<p><b>Código banco: </b>{{$objEmpBanco->codigo_banco}}</p>
<p><b>Descricao: </b>{{$objEmpBanco->descricao}}</p>

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

{!! Form::open(['route' => ['empresa_banco_ctrl.destroy', $objEmpBanco->id], 'method' => 'DELETE']) !!}

    {!! Form::submit("Excluir Banco", ['class' => 'btn btn-danger']) !!}

{!! Form::close() !!}

@endsection