@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg">{{$title}}</h2>
<a href="{{route('categoria_pagamento.create')}}" class="btn btn-primary">
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
            <th>Descrição</th>           
            <th>Data da alteração</th>
            <th>Ações</th>

        </tr>
    </thead>
    <tbody>
        @foreach($objCatPagamento as $valor)
        <tr>
            <td>{{$valor->id}}</td>
            <td>{{$valor->nome_cat_pag}}</td> 
            <td>{{$valor->descricao}}</td>            
            <td>{{$data_carbon->parse($valor->updated_at)->format('d/m/Y')}}</td>
            <td><a href="{{route('categoria_pagamento.edit', $valor->id)}}" class="edit">
                    <span class=""></span>
                    Alterar
                </a>                
            </td>

            <td><a href="{{route('categoria_pagamento.show', $valor->id)}}" class="delete">
                    <span class=""></span>
                    Excluir
                </a>
            </td>
            @endforeach            
        </tr>        
    </tbody>    
</table>

{!! $objCatPagamento !!}

@endsection
