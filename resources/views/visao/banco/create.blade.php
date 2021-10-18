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
            <a href="{{route('banco_ctrl.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
            <!-- Formulário utilizado tanto para cadastrar, quanto para editar -->
            @if(isset($objBanco) && isset($objBanco->id) )
            <!-- Envia para Tela para editar -->
            {!! Form::model($objBanco, ['route' => ['banco_ctrl.update', $objBanco->id], 'class' => 'form', 'method' => 'put'])  !!}
            @else
            <!-- Envia para Tela para Salvar-->
            {!! Form::open(['route' => 'banco_ctrl.store', 'class' => 'form']) !!}
            @endif 

            <div class="form-group">
                {!! Form::text('nome', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}          
            </div>

            <div class="form-group">
                {!! Form::text('codigo_banco', null, ['class' => 'form-control', 'placeholder' => 'Código banco:']) !!}
            </div>

            <div class="form-group">
                {!! Form::textarea('descricao', null, ['class' => 'form-control', 'placeholder' => 'Descricao:']) !!}
            </div>

            {!! Form::submit('Salvar', ['class' => 'btn btn-primary'] ) !!}
            {!! Form::close() !!}

        </div>
    </div>

</div>
@endsection