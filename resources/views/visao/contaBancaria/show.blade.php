@extends('templates.templates')

@section('content')

<h2 class="title-pg">Banco: <b>{{$objBanco->nome}}</b></h2>

<a href="{{route('banco_ctrl.index')}}"><span class="glyphicon glyphicon-fast-backward"></span></a>
<p><b>Id:</b>{{$objBanco->id}}</p>
<p><b>Nome: </b>{{$objBanco->nome}}</p>
<p><b>Código banco: </b>{{$objBanco->codigo_banco}}</p>
<p><b>Descricao: </b>{{$objBanco->descricao}}</p>

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

{!! Form::open(['route' => ['banco_ctrl.destroy', $objBanco->id], 'method' => 'DELETE']) !!}

    {!! Form::submit("Excluir Banco", ['class' => 'btn btn-danger']) !!}

{!! Form::close() !!}



@endsection