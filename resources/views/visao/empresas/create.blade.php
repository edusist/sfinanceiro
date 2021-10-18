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
            <a href="{{route('empresa.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
            <!-- Formulário utilizado tanto para cadastrar, quanto para editar -->
            @if(isset($objEmpresa) && isset($objEmpresa->id) )
            <!-- Envia para Tela para editar -->
            {!! Form::model($objEmpresa, ['route' => ['empresa.update', $objEmpresa->id], 'class' => 'form', 'method' => 'put'])  !!}
            @else
            <!-- Envia para Tela para Salvar-->
            {!! Form::open(['route' => 'empresa.store', 'class' => 'form']) !!}
            @endif 

            <div class="form-group">
                {!! Form::text('nome', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}          
            </div>

            <div class="form-group">
                {!! Form::text('cnpj_cpf', null, ['class' => 'form-control', 'placeholder' => 'Cnpj/cpf:']) !!}
            </div>

            <div class="form-group">
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email:']) !!}
            </div>

            <div class="form-group">
                {!! Form::text('telefone_fixo', null, ['class' => 'form-control', 'placeholder' => 'Telefone fixo:']) !!}
            </div>        

            <div class="form-group">
                {!! Form::text('telefone_celular', null, ['class' => 'form-control', 'placeholder' => 'Telefone celular:']) !!}
            </div>

            <div class="form-group">
                {!! Form::text('endereco', null, ['class' => 'form-control', 'placeholder' => 'Endereco:']) !!}
            </div>

            <div class="form-group">
                {!! Form::text('cidade', null, ['class' => 'form-control', 'placeholder' => 'Cidade:']) !!}
            </div>

            <div class="form-group">
                {!! Form::text('estado', null, ['class' => 'form-control', 'placeholder' => 'Estado:']) !!}
            </div>

            <div class="form-group">
                {!! Form::checkbox('status') !!}
                Status?
               
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