@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg">Pagamento: <b>{{$obj_pag->nome_pagamento}}</b></h2>

<a href="{{route('pagamento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span></a>
<p><b>Id:</b>{{$obj_pag->id}}</p>
<p><b>Nome: </b>{{$obj_pag->nome_pagamento}}</p>
<p><b>NF: </b>{{$obj_pag->nota_fiscal_cp}}</p>
<p><b>valor: </b>R$ {{$obj_pag->valor}}</p>
<p><b>Cliente:</b>{{$obj_pag->provider_id}}</p>
<p><b>Categoria:</b>{{$obj_pag->category_payment_id}}</p>
<p><b>Data Atualização:</b>{{$data_carbon->parse($obj_pag->updated_at)->format('d/m/Y')}}</p>
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

{!! Form::open(['route' => ['pagamento.destroy', $obj_pag->id], 'method' => 'DELETE']) !!}

    {!! Form::submit("Excluir Pagamento", ['class' => 'btn btn-danger']) !!}

{!! Form::close() !!}



@endsection