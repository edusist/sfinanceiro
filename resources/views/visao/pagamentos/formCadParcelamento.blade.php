@extends('layouts.admin-home')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-pg">{{$title}}</h2>
            @if( isset($errors) && count($errors) > 0 )
            <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                <p>{{$err}}</p>
                @endforeach
            </div>         
            @endif    
            <!-- Link para voltar -->


            <a href="{{route('pagamento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
            <!-- Envia para Tela para editar ['route' => ['pagamento.update', $obj_pag->id],-->
            <div class="form-group">
                {!! Form::open(['route' => 'postParcelamento', 'method' => 'post'])  !!}
            </div>

<!--                <input type="text" name="companie_id" value="{{$id_empresa}}"/>-->
            <div class="form-group">
                {!! Form::hidden('companie_id', $id_empresa, ['class' => 'form-control']) !!}
            </div>


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
                <select name="nome_parcela" id="nome_parcela" class="form-control">
                    <option value="">Escolha tipo de parcelamento</option>
                    @foreach($parcelamentos as $parcelamento)
                    <option>{{$parcelamento}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                {!! Form::number('quant_parcelas', 'value', ['class' => 'form-control', 'placeholder' => 'Quantidade parcelas:']) !!}          
            </div>


            <div class="form-group">
                {!! Form::checkbox('status') !!}
                Status?
            </div>

            <div class="form-group">
                {!! Form::textarea('descricao', null, ['class' => 'form-control', 'placeholder' => 'Descrição:']) !!}
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
                        >{{$cat_pag->nome}}
            </option> 
            @endforeach
        </select>
    </div>
    <div class="form-group">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary'] ) !!}
    </div>
    {!! Form::close() !!}
</div>
</div>
</div>

@endsection