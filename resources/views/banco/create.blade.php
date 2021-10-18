@extends('layouts.admin-home')

@section('content')

<div class="container-fluid">
    <!-- Link para voltar -->
    <a href="{{route('banco.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

    <h2 class="title-pg"><b>{{$title}}</b></h2>

    {{--Tratamento de erros--}}
    @if( isset($errors) && count($errors) > 0 )
    <div class="alert alert-danger">
        @foreach($errors->all() as $err)
        <p>{{$err}}</p>
        @endforeach
    </div>         
    @endif

    <!-- Inicio da modal-->
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <!-- Formulário utilizado tanto para cadastrar, quanto para editar -->
                @if(isset($objBanco) && isset($objBanco->id) )
                <!-- Envia para Tela para editar -->
                {!! Form::model($objBanco, ['route' => ['banco.update', $objBanco->id], 'class' => 'form', 'method' => 'put'])  !!}
                @else
                <!-- Envia para Tela para Salvar-->
                {!! Form::open(['route' => 'banco.store', 'class' => 'form']) !!}
                @endif 
                <h4 class="modal-title">Bancos</h4>
            </div><!-- /.modal header -->

            <div class="modal-body">
                <div class="form-group">
                    <label>Nome banco:</label>     
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-piggy-bank"></i></div>
                        {!! Form::text('nome', null, ['class' => 'form-control', 'placeholder' => 'Digite um banco']) !!}  
                    </div>
                </div>

                <div class="form-group">
                    <label>Código:</label>     
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-class-by-order">Nº</i></div>
                        {!! Form::text('codigo_banco', null, ['class' => 'form-control', 'placeholder' => '000']) !!}

                    </div>
                </div>

                 <div class="form-group">
                    <label>Descricao:</label>                                  
                    {!! Form::textarea('descricao', null, ['class' => 'form-control', 'cols' => '20', 'rows' => '5', 'placeholder' => 'Digite aqui...']) !!}

                </div>   
            </div><!-- /.modal-body -->

            <!-- Inicio modal footer -->
            <div class="modal-footer">
                <div class="form-group">
                    {!! Form::submit('Salvar', ['class' => 'btn btn-primary'] ) !!}
                </div>
            </div><!-- /.modal footer -->  
            {!! Form::close() !!}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div><!-- /fim da div container-fluid -->
@endsection