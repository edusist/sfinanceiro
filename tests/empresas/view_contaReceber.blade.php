@extends('layouts.admin-app')

@section('content')

<h2 class="title-pg">{{$title}}</h2>
<a href="{{route('recebimento.create')}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon-plus"></span>    
    Cadastrar
</a>

<!--Mensagem de sucesso-->
@if(session()->has('sucesso'))
<div class="alert alert-success">
    {{ session()->get('sucesso') }}
</div>
@endif

<!-- Pesquisar com angularjs -->
<!--<div class="input-group custom-search-form pull-right">
    <input class="form-control" type="text" name="pesquisa" placeholder="Pesquisar...."/>
</div>-->

<table class="table table-striped" id="id_tabela">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Data de Vencimento</th>   
            <th>Nota Fiscal</th>
            <th>Valor</th>
            <th>Status</th>
            <th>Descrição</th>            
            <th>Empresa</th>
            <th>Cliente</th>
            <th>Categoria</th>            
            <th>Data da alteração</th>
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
            <td>{{$valor->status}}</td>
            <td>{{$valor->descricao}}</td> 
            <td>{{$valor->nome_empresa}}</td> 
            <td>{{$valor->nome_cliente}}</td>    
            <td>{{$valor->nome_cat_rec}}</td>            
            <td>{{date('d/m/Y', strtotime($valor->updated_at))}}</td>

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