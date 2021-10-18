@extends('templates.templates')

@section('content')

<h1 class="title-pg">{{$title}}</h1>
<a href="{{route('banco_ctrl.create')}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon-plus"></span>    
    Cadastrar
</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Código Banco</th>
            <th>Descrição</th>         
            <th>Data da criação</th>
            <th>Data da alteração</th>
            <th>Ações</th>

        </tr>
    </thead>
    <tbody>
        @foreach($objBanco as $valor)
        <tr>
            <td>{{$valor->id}}</td>
            <td>{{$valor->nome}}</td>                    
            <td>{{$valor->codigo_banco}}</td>
            <td>{{$valor->descricao}}</td>
            <td>{{$data_carbon->parse($valor->updated_at)format('d/m/Y')}}</td> 
            <td><a href="{{route('banco_ctrl.edit', $valor->id)}}" class="edit">
                    <span class=""></span>
                    Alterar
                </a>                
            </td>

            <td><a href="{{route('banco_ctrl.show', $valor->id)}}" class="delete">
                    <span class=""></span>
                    Excluir
                </a>
            </td>
            @endforeach            
        </tr>        
    </tbody>    
</table>

{!! $objBanco !!}

@endsection
