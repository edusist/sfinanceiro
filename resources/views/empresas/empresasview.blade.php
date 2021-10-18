@extends('layouts.admin-home')

@section('content')

<!--Mensagem de erro-->
@if( isset($errors) && count($errors) > 0 )
<div class="alert alert-danger">
    @foreach($errors->all() as $err)
    <p>{{$err}}</p>
    @endforeach
</div>         
@endif 

<!--Mensagem de sucesso-->
@if(session()->has('sucesso'))
<div class="alert alert-success">
    {{ session()->get('sucesso') }}
</div>
@endif

<!--Tabela Zebrada-->
@push('scripts')
<link rel="stylesheet" href="{{url('assets/css/table-striped.css')}}"/>
@endpush

<!-- Link para voltar -->
<a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

<h2 class="title-pg">{{$title}}</h2>
<a href="{{route('empresa.create')}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon-plus"></span>    
    Cadastrar
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
            <th>Data da criação</th>
            <th>Ações</th>

        </tr>
    </thead>
    <tbody>
        @foreach($objEmpresa as $valor)
        <tr>
            <td>{{$valor->id}}</td>
            <td>{{$valor->nome_empresa}}</td>                    
            <td>{{$valor->cnpj_cpf}}</td>
            <td>{{$valor->email}}</td>
            <td>{{$valor->descricao}}</td>
            <td>{{$valor->telefone_fixo}}</td>
            <td>{{$valor->endereco}}</td>   
            <td>{{$valor->cidade}}</td>
            <td>{{$carbon->parse($valor->created_at)->format('d/m/Y')}}</td>

            <td><a href="{{route('empresa.edit', $valor->id)}}" class="edit">
                    <span class=""></span>
                    Alterar
                </a>                
            </td>

            <td><a href="{{route('empresa.show', $valor->id)}}" class="delete">
                    <span class=""></span>
                    Excluir
                </a>
            </td>
            @endforeach            
        </tr>        
    </tbody>    
</table>

{!! $objEmpresa !!}

@endsection
