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


            <a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
            <!-- Envia para Tela para editar ['route' => ['recebimento.update', $obj_rec->id],-->
            <div class="form-group">
                {!! Form::open(['route' => 'postParcelamento', 'method' => 'post'])  !!}
            </div>

<!--                <input type="text" name="companie_id" value="{{$id_empresa}}"/>-->
            <div class="form-group">
                {!! Form::hidden('companie_id', $id_empresa, ['class' => 'form-control']) !!}
            </div>


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
                {!! Form::textarea('descricao', null, ['class' => 'form-control', 'placeholder' => 'Descricao:']) !!}
            </div>   

            <div class="form-group">
                {!! Form::text('data_vencimento', null, ['class' => 'form-control', 'id' => 'data_vencimento',  'placeholder' => 'Data vencimento:']) !!}     
            </div>

<!--            <div class="form-group">       
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
        </div>      -->

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
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary'] ) !!}
    </div>
    {!! Form::close() !!}
</div>
</div>
</div>

@endsection