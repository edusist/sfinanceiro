@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg">Excluir</h2>

<a href="{{route('categoria_recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span></a>
<p><b>Id:</b>{{$objCatReceber->id}}</p>
<p><b>Nome: </b>{{$objCatReceber->nome_cat_rec}}</p>
<p><b>Descrição: </b>{{$objCatReceber->descricao}}</p>
<p><b>Data Criação: </b>{{$carbon->parse($objCatReceber->created_at)->format('d-m-Y')}}</p>

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

{!! Form::open(['route' => ['categoria_recebimento.destroy', $objCatReceber->id], 'method' => 'DELETE']) !!}

    {!! Form::submit("Excluir Categoria", ['class' => 'btn btn-danger']) !!}

{!! Form::close() !!}

@endsection