@extends('layouts.admin-home')

@section('content')

<div class="container-fluid">

    <!-- Link para voltar -->
    <a href="{{route('forma-pagamento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>


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
                @if(isset($objformaPag) && isset($objformaPag->id) )
                <!-- Envia para Tela para editar -->
                {!! Form::model($objformaPag, ['route' => ['forma-pagamento.update', $objformaPag->id], 'class' => 'form', 'method' => 'put'])  !!}
                @else
                <!-- Envia para Tela para Salvar-->
                {!! Form::open(['route' => 'forma-pagamento.store', 'class' => 'form']) !!}
                @endif 
                <h4 class="modal-title">Forma de pagamento</h4>
            </div><!-- /.modal header -->

            <div class="modal-body">  

                <div class="form-group">
                    <label>Tipo de pagamento:</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></div>
                        {!! Form::text('tipo', null, ['class' => 'form-control', 'placeholder' => 'Forma de pagamento:']) !!}   
                    </div>
                </div>

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