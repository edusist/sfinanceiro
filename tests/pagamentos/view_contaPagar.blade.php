@extends('layouts.admin-home')

@section('content')

<h1 class="title-pg">{{$title}}</h1>

<h4><strong> Nº de pagamentos({{$quant_pag}})</strong></h4>
<!--Mensagem de sucesso-->
@if(session()->has('sucesso'))
<div class="alert alert-success">
    {{session()->get('sucesso')}}
</div>
@endif

<!-- Tratamento de erros -->
@if( isset($errors) && count($errors) > 0 )
<div class="alert alert-danger">
    @foreach($errors->all() as $err)
    <p>{{$err}}</p>
    @endforeach
</div>         
@endif 

<!-- Cadastrar -->
<a href="{{route('pagamento.create')}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon-plus"></span>    
    Cadastrar
</a>

<!-- Cadastrar parcelamento-->
<a href="{{route('formCadParcelamentoPag', $empresa_id)}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon glyphicon-download-alt"></span>    
    Parcelamento do contas à pagar
</a>

<!-- Pesquisar -->
<div class="table-responsive">
    <form>
        <div class="input-group">        

        </div>
    </form>

    <form action="{{route('informacaoPesquisa')}}" method="get" id="form-pesquisa" class="navbar-form navbar-left pull-right">
        <div class="input-group">
            <input type="text" name="pesquisar" class="form-control" required="required" placeholder="Pesquisar..."/>
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>

            </span>           
        </div>    
    </form> 
    <form class="form-group">  
        <div class="form-group">            
            <div class="input-group date">
                <input type="text" class="form-control" name="data-calendario" id="data-calendario">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
        </div>
    </form>
    <table class="table table-hover table-striped table-condensed" id="id_tabela">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Data de Vencimento</th>   
                <th>Nota Fiscal</th>
                <th>Valor</th>
                <th>Fornecedor</th>           
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($obj_Pag_tab as $valor)
            <tr>
                <td>{{$valor->id}}</td>
                <td>{{$valor->nome_pagamento}}</td>   
                <td>{{$data_carbon->parse($valor->data_vencimento)->format('d/m/Y')}}</td>
                <td>{{$valor->nota_fiscal_cp}}</td>
                <td>R${{number_format($valor->valor, 2, ',', '.')}}</td>          
                <td>{{$valor->nome_fornecedor}}</td>    
                <td><a href="{{route('pagamento.edit', $valor->id)}}" class="edit">Alterar</a></td>
                <td><a href="{{route('pagamento.show', $valor->id)}}" class="delete">Excluir</a></td>                       
            </tr>   
            @endforeach 
        </tbody>    
    </table>
</div>

@if($soma)
<h3>Total de Pagamentos: R${{$soma}}</h3>
@endif

{!! $obj_Pag_tab !!}
@endsection
@push('scripts')
    <link rel="stylesheet" href="{{url('assets/datepicker/css/bootstrap-datepicker.css')}}"/>
    <script src="{{url('assets/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{url('assets/datepicker/js/bootstrap-datepicker.pt-BR.min.js')}}"> </script>
    <script>
        $('#data-calendario').datepicker({
            language: 'pt-BR',
            format:'dd/mm/yyyy'
        });
    </script>
@endpush