@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg">Empresa: <b>{{$objEmpresa->nome}}</b></h2>

<a href="{{route('empresa.index')}}"><span class="glyphicon glyphicon-fast-backward"></span></a>
<p><b>Id:</b>{{$objEmpresa->id}}</p>
<p><b>Nome: </b>{{$objEmpresa->nome}}</p>
<p><b>Cnpj/cpf: </b>{{$objEmpresa->cnpj_cpf}}</p>
<p><b>Email: </b>{{$objEmpresa->email}}</p>
<p><b>Descrição: </b>{{$objEmpresa->descricao}}</p>
<p><b>Cidade: </b>{{$objEmpresa->cidade}}</p>
<p><b>Estado: </b>{{$objEmpresa->estado}}</p>
<p><b>Data Criação: </b>{{$objEmpresa->created_at}}</p>

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

{!! Form::open(['route' => ['empresa.destroy', $objEmpresa->id], 'method' => 'DELETE']) !!}

    {!! Form::submit("Excluir Empresa", ['class' => 'btn btn-danger']) !!}

{!! Form::close() !!}

@endsection