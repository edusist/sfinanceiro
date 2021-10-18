@extends('layouts.admin-home')

@section('content')

<!--Tabela Zebrada-->
@push('scripts')
<link rel="stylesheet" href="{{url('assets/css/table-striped.css')}}"/>

@endpush

<h1 class="title-pg">{{$title}}</h1>
<a href="{{route('banco.create')}}" class="btn btn-primary">
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
            <th>Data da criação</th>           
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($objBanco as $valor)
        <tr>
            <td>{{$valor->id}}</td>
            <td>{{$valor->nome}}</td>                    
         
            <td>{{$data_carbon->parse($valor->created_at)->format('d/m/Y')}}</td>                      
     
            <td><a href="{{route('banco.edit', $valor->id)}}" class="edit">
                    <span class=""></span>
                    Alterar
                </a>                
            </td>
            <td><a href="{{route('banco.show', $valor->id)}}" class="delete">
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
