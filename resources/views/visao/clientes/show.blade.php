@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg">Cliente: <b>{{$objCliente->nome_cliente}}</b></h2>

<a href="{{route('cliente.index')}}"><span class="glyphicon glyphicon-fast-backward"></span></a>
<p><b>Id:</b>{{$objCliente->id}}</p>
<p><b>Nome: </b>{{$objCliente->nome_cliente}}</p>
<p><b>Cnpj/cpf: </b>{{$objCliente->cnpj_cpf}}</p>
<p><b>Email: </b>{{$objCliente->email}}</p>
<p><b>Descrição: </b>{{$objCliente->descricao}}</p>
<p><b>Cidade: </b>{{$objCliente->cidade}}</p>
<p><b>Estado: </b>{{$objCliente->estado}}</p>
<p><b>Data Criação: </b>{{date('d/m/Y', strtotime($objCliente->created_at))}}</p>

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

{!! Form::open(['route' => ['cliente.destroy', $objCliente->id], 'method' => 'DELETE']) !!}

    {!! Form::submit("Excluir Cliente", ['class' => 'btn btn-danger']) !!}

{!! Form::close() !!}

@endsection