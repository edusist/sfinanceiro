@extends('layouts.admin-home')

@section('content')
<h4 style="margin-top: -30px; padding-top: 10px; padding-bottom: 20px;">Seja bem vindo(a) à <strong style="text-transform:capitalize;">{{$nome_empresa}}</strong>!</h4>
<h4 class="title-pg">{{$title}}</h4>
 <h4><strong> Nº de recebimentos({{$quant_rec}})</strong></h4>

@if( isset($errors) && count($errors) > 0 )
<div class="alert alert-danger">
    @foreach($errors->all() as $err)
    <p>{{$err}}</p>
    @endforeach
</div>         
@endif 


<!-- Cadastrar -->
<a href="{{route('recebimento.create')}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon-plus"></span>    
    Cadastrar
</a>
<a href="{{route('formCadParcelamentoRec', $empresa_id)}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon glyphicon-download-alt"></span>    
    Parcelamento do contas à receber
</a>

<!--Mensagem de sucesso-->
@if(session()->has('sucesso'))
<div class="alert alert-success">
    {{ session()->get('sucesso') }}
</div>
@endif

<!-- Pesquisar -->
<div class="table-responsive">
    <form action="{{route('informacaoPesquisaReceber')}}" method="get" id="form-pesquisa" class="navbar-form navbar-left pull-right">
        <div class="input-group">
            <input type="text" name="pesquisar" class="form-control" required="required" placeholder="Pesquisar..."/>
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </span>
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
                <td>{{$data_carbon->parse($valor->data_vencimento)->format('d/m/Y')}}</td>
                <td>{{$valor->nota_fiscal_cr}}</td>
                <td>R${{number_format($valor->valor, 2, ',', '.')}}</td>          
                <td>{{$valor->nome_cliente}}</td>    
                <td><a href="{{route('recebimento.edit', $valor->id)}}" class="edit">Alterar</a></td>
                <td><a href="{{route('recebimento.show', $valor->id)}}" class="delete">Excluir</a></td>                       
            </tr>   
            @endforeach 
        </tbody>    
    </table>
</div>

@if($soma_moeda_real)

<h3>Total de recebimentos: R${{$soma_moeda_real}}</h3>

@endif
{!! $obj_Rec_tab !!}

@endsection()