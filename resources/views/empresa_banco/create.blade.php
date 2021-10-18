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
            <a href="{{route('empresa_banco_ctrl.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
            <!-- Formulário utilizado tanto para cadastrar, quanto para editar -->
            @if(isset($objEmpBanco) && isset($objEmpBanco->id) )
            <!-- Envia para Tela para editar -->
            {!! Form::model($objEmpBanco, ['route' => ['empresa_banco_ctrl.update', $objEmpBanco->id], 'class' => 'form', 'method' => 'put'])  !!}
            @else
            <!-- Envia para Tela para Salvar-->
            {!! Form::open(['route' => 'empresa_banco_ctrl.store', 'class' => 'form']) !!}
            @endif 

            <div class="form-group">
                {!! Form::text('agencia', null, ['class' => 'form-control', 'placeholder' => 'Agência:']) !!}          
            </div>    

            <div class="form-group">
                {!! Form::text('conta_corrente', null, ['class' => 'form-control', 'placeholder' => 'Conta/corrente:']) !!}
            </div>

            <div class="form-group">
                {!! Form::text('digito', null, ['class' => 'form-control', 'placeholder' => 'Digito:']) !!}          
            </div>

            <div class="form-group">
                {!! Form::text('saldo', null, ['class' => 'form-control', 'placeholder' => 'Saldo:']) !!}
            </div>

            <div class="form-group">       
                <select  name="bank_id" id="bank_id" class="form-control">  
                    <option value="">Escolha um banco</option>                        
                    @foreach($obj_banco as $banco)
                    <option value="{{$banco->id}}"
                            @if(isset($objEmpBanco->bank_id) && ($objEmpBanco->bank_id == $banco->id))
                            selected
                            @endif
                            >{{$banco->nome}}
                </option> 
                @endforeach
            </select>
        </div>
        <div class="form-group">       
            <select  name="companie_id" id="companie_id" class="form-control">  
                <option value="">Escolha uma empresa</option>                        
                @foreach($obj_empresa as $empresa)
                <option value="{{$empresa->id}}"
                        @if(isset($objEmpBanco->companie_id) && ($objEmpBanco->companie_id == $empresa->id))
                        selected
                        @endif
                        >{{$empresa->nome}}
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