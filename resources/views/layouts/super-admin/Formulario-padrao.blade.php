@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg"><b>{{$title}}</b></h2>
{{--Tratamento de erros--}}

<div class="container-fluid">
    <div class="row linha-form">
        <!-- Link para voltar -->
        <a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
        <div class="col-md-12 formulario">            

            @if( isset($errors) && count($errors) > 0 )
            <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                <p>{{$err}}</p>
                @endforeach
            </div>         
            @endif    

            <!-- Formulário utilizado tanto para cadastrar, quanto para editar -->
            @if(isset($obj_rec) && isset($obj_rec->id) )

            <!-- Envia para Tela para editar -->
            {!! Form::model($obj_rec, ['route' => ['recebimento.update', $obj_rec->id], 'class' => 'form-horizontal', 'method' => 'put'])  !!}

            {!! Form::hidden('companie_id', $obj_rec->companie_id, ['class' => 'form-control']) !!}  
            <div class="form-group">
                {!! Form::text('status', $obj_rec->status, ['class' => 'form-control', 'placeholder' => 'Status:']) !!} 
            </div>
            @else

            <!-- Envia para Tela para Salvar-->
            {!! Form::open(['route' => 'recebimento.store', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('companie_id', $id_empresa, ['class' => 'form-control']) !!} 
            <!-- Envia o para o bd Status pagamento em aberto-->
            {!! Form::hidden('status', 0) !!}
            @endif            

            <div class="form-group">
                <label for="nome_recebimento">Nome recebimento: </label>                               
                {!! Form::text('nome_recebimento', null, ['class' => 'form-control', 'placeholder' => 'Informe o nome:']) !!}          

            </div>

            <div class="form-group">
                <label for="nome_recebimento">Nota fiscal: </label>
                {!! Form::text('nota_fiscal_cr', null, ['class' => 'form-control', 'placeholder' => 'Informe a NF:']) !!}          
            </div>
            

            <div class="form-group">
                <label for="nome_recebimento">Valor: </label>
                {!! Form::text('valor', null, ['class' => 'form-control', 'placeholder' => '0,00']) !!}          
            </div>            

            <div class="form-group">
                <label for="nome_recebimento">Descricao:</label>
                {!! Form::textarea('descricao', null, ['class' => 'form-control', 'placeholder' => 'Digite...']) !!}
            </div>   

            <div class="form-group">
                <label for="nome_recebimento">Data vencimento: </label>
                {!! Form::text('data_vencimento', null, ['class' => 'form-control', 'id' => 'data_vencimento',  'placeholder' => '00/00/00']) !!}     
            </div>

            <div class="form-group">      
                <label for="nome_recebimento">Cliente: </label>
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
            <label for="nome_recebimento">Categoria: </label>
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
</div><!-- /fim da div col-md-12-->
</div><!-- /fim da div row-->
</div><!-- /fim da div container-fluid -->

@endsection

@push('scripts')
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/data-calendario.js')}}"></script>
@endpush