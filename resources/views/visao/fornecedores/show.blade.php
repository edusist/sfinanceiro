@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg">Fornecedor: <b>{{$objFornecedor->nome_fornecedor}}</b></h2>

<a href="{{route('fornecedor.index')}}"><span class="glyphicon glyphicon-fast-backward"></span></a>
<p><b>Id:</b>{{$objFornecedor->id}}</p>
<p><b>Nome: </b>{{$objFornecedor->nome_fornecedor}}</p>
<p><b>Cnpj/cpf: </b>{{$objFornecedor->cnpj_cpf}}</p>
<p><b>Email: </b>{{$objFornecedor->email}}</p>
<p><b>Descrição: </b>{{$objFornecedor->descricao}}</p>
<p><b>Cidade: </b>{{$objFornecedor->cidade}}</p>
<p><b>Estado: </b>{{$objFornecedor->estado}}</p>
<p><b>Data Criação: </b>{{date('d/m/Y', strtotime($objFornecedor->created_at))}}</p>

<hr>
<!--Tratamento de erros-->
@if( isset($errors) && count($errors)> 0 )
    <div class="alert alert-danger">
        @foreach($errors->all() as $err)
            <p>{{$err}}</p>
        @endforeach
    </div>
@endif

<!--Formuláriario do deletar 
Unica maneira de deletar um item
-->

{!! Form::open(['route' => ['fornecedor.destroy', $objFornecedor->id], 'method' => 'DELETE']) !!}

    {!! Form::submit('Excluir Fornecedor', ['class' => 'btn btn-danger']) !!}

{!! Form::close() !!}

@endsection