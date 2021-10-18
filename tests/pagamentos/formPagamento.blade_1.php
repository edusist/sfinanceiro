@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg"><b>{{$title}}</b></h2>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Tratamento de erros -->
            @if( isset($errors) && count($errors) > 0 )
            <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                <p>{{$err}}</p>
                @endforeach
            </div>         
            @endif    

            <!-- Link para voltar -->
            <a href="{{route('pagamento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

            <!-- Formulário utilizado tanto para cadastrar, quanto para editar -->
            @if(isset($obj_pag) && isset($obj_pag->id))
            <!-- Envia para Tela para editar -->        
            {!! Form::model($obj_pag, ['route' => ['pagamento.update', $obj_pag->id], 'class' => 'form', 'method' => 'put'])  !!}
            {!! Form::hidden('companie_id', $obj_pag->companie_id, ['class' => 'form-control']) !!} 
            @else
            <!-- Envia para Tela para Salvar-->
            <!-- Recebe o id da empresa-->
                      
            {!! Form::open(['route' => 'pagamento.store', 'class' => 'form']) !!}
            {!! Form::hidden('companie_id', $id_empresa, ['class' => 'form-control']) !!} 
            @endif         

            <div class="form-group">
                {!! Form::text('nome_pagamento', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}          
            </div>

            <div class="form-group">
                {!! Form::text('nota_fiscal_cp', null, ['class' => 'form-control', 'placeholder' => 'Nota fiscal:']) !!}          
            </div>

            <div class="form-group">
                {!! Form::text('valor', null, ['class' => 'form-control', 'placeholder' => 'Valor:']) !!}          
            </div>

            <div class="form-group">
                {!! Form::checkbox('status') !!}
                Status?
            </div>

            <div class="form-group">
                {!! Form::textarea('descricao', null, ['class' => 'form-control', 'placeholder' => 'Descricao:']) !!}
            </div>   

            <div class="form-group">
                {!! Form::text('data_vencimento', null, ['class' => 'form-control', 'id' => 'data_vencimento',  'placeholder' => 'Data vencimento:']) !!}     
            </div>

            <div class="form-group">       
                <select  name="provider_id" id="provider_id" class="form-control">  
                    <option value="">Escolha um fornecedor</option>                        
                    @foreach($obj_fornecedor as $fornecedor)
                    <option value="{{$fornecedor->id}}"
                            @if(isset($obj_pag->provider_id) && ($obj_pag->provider_id == $fornecedor->id))
                            selected
                            @endif
                            >{{$fornecedor->nome_fornecedor}}
                </option> 
                @endforeach
            </select>
        </div>  

    <div class="form-group">       
        <select  name="category_payment_id" id="category_payment_id" class="form-control">  
            <option value="">Escolha uma Categoria</option>                        
            @foreach($obj_cat_pag as $cat_pag)
            <option value="{{$cat_pag->id}}"
                    @if(isset($obj_pag->category_payment_id) && ($obj_pag->category_payment_id == $cat_pag->id))
                    selected
                    @endif
                    >{{$cat_pag->nome_cat_pag}}
        </option> 
        @endforeach
    </select>
</div>
<div class="form-group">
    {!! Form::submit('Enviar', ['class' => 'btn btn-primary'] ) !!}
</div>
{!! Form::close() !!}
</div>
</div>
</div>

@endsection