@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg">Fornecedor: <b>{{$objCatPagamento->nome_cat_pag}}</b></h2>

<a href="{{route('categoria_pagamento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span></a>
<p><b>Id:</b>{{$objCatPagamento->id}}</p>
<p><b>Nome: </b>{{$objCatPagamento->nome_cat_pag}}</p>
<p><b>Descrição: </b>{{$objCatPagamento->descricao}}</p>
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

{!! Form::open(['route' => ['categoria_pagamento.destroy', $objCatPagamento->id], 'method' => 'DELETE']) !!}

    {!! Form::submit("Excluir Categoria", ['class' => 'btn btn-danger']) !!}

{!! Form::close() !!}

@endsection