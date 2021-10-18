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

<form action="{{route('informacaoPesquisa')}}" method="get" id="form-pesquisa" class="navbar-form navbar-left pull-right">
    <div class="input-group">
        <input type="text" name="pesquisar" class="form-control" required="required" placeholder="Pesquisar..."/>
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
        </span>
    </div>    
</form> 

<!-- Cadastrar -->
<a href="{{route('recebimento.create')}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon-plus"></span>    
    Cadastrar
</a>

<a href="{{route('receber.pdf')}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon glyphicon-download-alt"></span>    
    Relatório de Recebimentos
</a>

<!--Mensagem de sucesso-->
@if(session()->has('sucesso'))
<div class="alert alert-success">
    {{ session()->get('sucesso') }}
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
            <th>Empresa</th>
            <th>Cliente</th>
            <th>Categoria</th>
            <th>Ações</th>

        </tr>
    </thead>
    <tbody>
        @foreach($obj_Rec_tab as $valor)
        <tr>
            <td>{{$valor->id}}</td>
            <td>{{$valor->nome_recebimento}}</td>   
            <td>{{date('d/m/Y', strtotime($valor->data_vencimento))}}</td>
            <td>{{$valor->nota_fiscal_cr}}</td>
            <td>R${{number_format($valor->valor, 2, ',', '.')}}</td>           
            <td>{{$valor->nome_empresa}}</td> 
            <td>{{$valor->nome_cliente}}</td>    
                
            

            <td><a href="{{route('recebimento.edit', $valor->id)}}" class="edit">
                    <span class=""></span>
                    Alterar
                </a>                
            </td>

            <td><a href="{{route('recebimento.show', $valor->id)}}" class="delete">
                    <span class=""></span>
                    Excluir
                </a>
            </td>
            @endforeach            
        </tr>   
    </tbody>    
</table>

@if($soma_moeda_real)

<h3>Total de recebimentos: R${{$soma_moeda_real}}</h3>

@endif
{!! $obj_Rec_tab !!}

@endsection()