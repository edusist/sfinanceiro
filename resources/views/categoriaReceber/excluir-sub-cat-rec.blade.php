@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg">Sub-Categoria Recebimento: <b>{{$obj_sub_cat->nome}}</b></h2>

<a href="{{route('sub_categoria_recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span></a>
<p><b>Id:</b>{{$obj_sub_cat->id}}</p>
<p><b>Nome: </b>{{$obj_sub_cat->nome}}</p>
<p><b>Descrição: </b>{{$obj_sub_cat->descricao}}</p>
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

{!! Form::open(['route' => ['sub_categoria_recebimento.destroy', $obj_sub_cat->id], 'method' => 'DELETE']) !!}

    {!! Form::submit("Excluir", ['class' => 'btn btn-danger']) !!}

{!! Form::close() !!}

@endsection