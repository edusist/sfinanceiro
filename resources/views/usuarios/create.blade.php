@extends('layouts.usuario.usuario-app')

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
            <a href="{{route('usuarios.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
            <!-- Formulário utilizado tanto para cadastrar, quanto para editar -->
            @if(isset($objUser) && isset($objUser->id) )
            <!-- Envia para Tela para editar -->
            {!! Form::model($objUser, ['route' => ['usuarios.update', $objUser->id], 'class' => 'form', 'method' => 'put'])  !!}
            @else
            <!-- Envia para Tela para Salvar-->
            {!! Form::open(['route' => 'usuarios.store', 'class' => 'form']) !!}
            @endif 

            <div class="form-group">
                {!! Form::text('nome', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}          
            </div>

            <div class="form-group">
                {!! Form::text('sobrenome', null, ['class' => 'form-control', 'placeholder' => 'Sobrenome:']) !!}
            </div>

            <div class="form-group">
                {!! Form::text('senha', null, ['class' => 'form-control', 'placeholder' => 'Senha:']) !!}
            </div>

            <div class="form-group">
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email:']) !!}
            </div>
            <div class="form-group">       
                <select  name="official_id" id="official_id" class="form-control">  
                    <option value="">Escolha o Funcionário</option>                        
                    @foreach($objOff as $func)
                    <option value="{{$func->id}}"
                            @if(isset($objUser->official_id) && ($objUser->official_id == $func->id))
                                selected
                            @endif
                            >{{$func->nome}}
                    </option> 
                    @endforeach
                </select>
            </div>
            {!! Form::submit('Salvar', ['class' => 'btn btn-primary'] ) !!}
            {!! Form::close() !!}

        </div>
    </div>

</div>
@endsection