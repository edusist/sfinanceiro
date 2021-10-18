@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg">{{$title}}</h2>

<!-- Pesquisar -->
@if( isset($errors) && count($errors) > 0 )
<div class="alert alert-danger">
    @foreach($errors->all() as $err)
    <p>{{$err}}</p>
    @endforeach
</div>         
@endif 
<table class="table table-striped" id="id_tabela">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Data de Vencimento</th>   
            <th>Nota Fiscal</th>
            <th>Valor</th>            
            <th>Cliente</th>


        </tr>
    </thead>
    <tbody>
        @foreach($rec_empresa as $valor)
        <tr>
            <td>{{$valor->id}}</td>
            <td>{{$valor->nome_recebimento}}</td>   
            <td>{{date('d/m/Y', strtotime($valor->data_vencimento))}}</td>
            <td>{{$valor->nota_fiscal_cr}}</td>
            <td>R${{number_format($valor->valor, 2, ',', '.')}}</td>              
            <td>{{$valor->nome_cliente}}</td>                             
        </tr>   
        @endforeach
    </tbody>    
</table>      
@stop