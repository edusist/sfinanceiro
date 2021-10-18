@extends('layouts.admin-home')
@section('content')
<!--Tabela Zebrada-->
@push('scripts')
<link rel="stylesheet" href="{{url('assets/css/table-striped.css')}}"/>

@endpush

<a href="{{route('admin.painel')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
            
<h2 class="title-pg">{{$title}}</h2>
<a href="{{route('fornecedor.create')}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon-plus"></span>    
    Cadastrar
</a>
<a href="{{route('pdf')}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon glyphicon-download-alt"></span>    
    Relatório de fornecedores
</a>
<!--Mensagem de sucesso-->
@if(session()->has('sucesso'))
<div class="alert alert-success">
    {{ session()->get('sucesso') }}
</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Cnpj/Cpf</th>
            <th>Email</th>
            <th>Descrição</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Cidade</th>
            <th>Data da alteração</th>
            <th>Ações</th>

        </tr>
    </thead>
    <tbody>
        @foreach($objFornecedor as $valor)
        <tr>
            <td>{{$valor->id}}</td>
            <td>{{$valor->nome_fornecedor}}</td>                    
            <td>{{$valor->cnpj_cpf}}</td>
            <td>{{$valor->email}}</td>
            <td>{{$valor->descricao}}</td>
            <td>{{$valor->telefone_fixo}}</td>
            <td>{{$valor->endereco}}</td>   
            <td>{{$valor->cidade}}</td>
            <td>{{date('d/m/Y', strtotime($valor->updated_at))}}</td>
            <td><a href="{{route('fornecedor.edit', $valor->id)}}" class="edit">
                    <span class=""></span>
                    Alterar
                </a>                
            </td>

            <td><a href="{{route('fornecedor.show', $valor->id)}}" class="delete">
                    <span class=""></span>
                    Excluir
                </a>
            </td>
            @endforeach            
        </tr>        
    </tbody>    
</table>

{!! $objFornecedor !!}

@endsection
