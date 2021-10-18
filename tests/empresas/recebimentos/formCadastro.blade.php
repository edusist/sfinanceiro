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
            <a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

            <!-- Formulário utilizado tanto para cadastrar, quanto para editar -->
            @if(isset($obj_rec) && isset($obj_rec->id) )

            <!-- Envia para Tela para editar -->
            {!! Form::model($obj_rec, ['route' => ['recebimento.update', $obj_rec->id], 'class' => 'form', 'method' => 'put'])  !!}
            @else

            <!-- Envia para Tela para Salvar-->
            {!! Form::open(['route' => 'recebimento.store', 'class' => 'form']) !!}
            @endif 

            <div class="form-group">
                {!! Form::text('nome_recebimento', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!}          
            </div>

            <div class="form-group">
                {!! Form::text('nota_fiscal_cr', null, ['class' => 'form-control', 'placeholder' => 'Nota fiscal:']) !!}          
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
                <select  name="customer_id" id="customer_id" class="form-control">  
                    <option value="">Escolha um Cliente</option>                        
                    @foreach($obj_cliente as $cliente)
                    <option value="{{$cliente->id}}"
                            @if(isset($obj_rec->customer_id) && ($obj_rec->customer_id == $cliente->id))
                            selected
                            @endif
                            >{{$cliente->nome_cliente}}
                </option> 
                @endforeach
            </select>
        </div>
        <div class="form-group">       
            <select  name="companie_id" id="companie_id" class="form-control">  
                <option value="">Escolha uma empresa</option>                        
                @foreach($obj_empresa as $empresa)
                <option value="{{$empresa->id}}"
                        @if(isset($obj_rec->companie_id) && ($obj_rec->companie_id == $empresa->id))
                        selected
                        @endif
                        >{{$empresa->nome_empresa}}
            </option> 
            @endforeach
        </select>
    </div>  

    <div class="form-group">       
        <select  name="category_receipt_id" id="category_receipt_id" class="form-control">  
            <option value="">Escolha uma Categoria</option>                        
            @foreach($obj_cat_rec as $cat_rec)
            <option value="{{$cat_rec->id}}"
                    @if(isset($obj_rec->category_receipt_id) && ($obj_rec->category_receipt_id == $cat_rec->id))
                    selected
                    @endif
                    >{{$cat_rec->nome_cat_rec}}
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