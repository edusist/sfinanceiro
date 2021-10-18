@extends('layouts.admin-app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">    
            <h2 class="title-pg">{{$title}}</h2>
            
            <!--Tratamento de erros-->
            @if( isset($errors) && count($errors) > 0 )
            <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                <p>{{$err}}</p>
                @endforeach
            </div>         
            @endif  
            <!-- Envia para Tela para Salvar-->
            {!! Form::open(['route' => 'categoria_recebimento.store', 'class' => 'form']) !!}

            <div class="form-group">
                {!! Form::text('nome', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}          
            </div>

            <div class="form-group">
                {!! Form::textarea('descricao', null, ['class' => 'form-control', 'placeholder' => 'Descricao:']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Enviar', ['class' => 'btn btn-primary'] ) !!}
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection