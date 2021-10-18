@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg"><b>{{$title}}</b></h2>
{{--Tratamento de erros--}}

<div class="container">
    <div class="row">
        <div class="col-md-12">

            @if( isset($errors) && count($errors) > 0 )
            <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                <p>{{$err}}</p>
                @endforeach
            </div>         
            @endif    

            <!-- Link para voltar -->
            <a href="{{route('categoria_pagamento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
            <!-- Formulário utilizado tanto para cadastrar, quanto para editar -->
            @if(isset($objCatPagamento) && isset($objCatPagamento->id) )
            <!-- Envia para Tela para editar -->
            {!! Form::model($objCatPagamento, ['route' => ['categoria_pagamento.update', $objCatPagamento->id], 'class' => 'form', 'method' => 'put'])  !!}
            @else
            <!-- Envia para Tela para Salvar-->
            {!! Form::open(['route' => 'categoria_pagamento.store', 'class' => 'form']) !!}
            @endif 

            <div class="form-group">
                {!! Form::text('nome_cat_pag', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}          
            </div>

            <div class="form-group">
                {!! Form::textarea('descricao', null, ['class' => 'form-control', 'placeholder' => 'Descricao:']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Salvar', ['class' => 'btn btn-primary'] ) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection