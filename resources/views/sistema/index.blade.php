@extends('layouts.admin.admin-app')

@section('content')

<h1 class="title-pg">{{$title}}</h1>
<a href="{{route('usuarios.create')}}" class="btn btn-primary">
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
            <th>Sobrenome</th>
            <th>Email</th>
            <th>Senha</th>
            <th>Id Colabor</th>
            <th>Data da criação</th>
            <th>Data da alteração</th>
            <th style="">Ações</th>

        </tr>
    </thead>
    <tbody>
        @foreach($objUser as $valor)
        <tr>
            <td>{{$valor->id}}</td>
            <td>{{$valor->nome}}</td>                    
            <td>{{$valor->sobrenome}}</td>
            <td>{{$valor->email}}</td>
            <td>{{$valor->senha}}</td>
            <td>{{$valor->official_id}}</td>            
            <td>{{--Chamada da função Data no formato Brasileiro --}}
                @php 
                print_r($objData->getDateOfBirthAttribute($valor->created_at));
                @endphp
            </td>
            <td>
                @php 
                print_r($objData->getDateOfBirthAttribute($valor->updated_at));
                @endphp
            </td>
            <td><a href="{{route('usuarios.edit', $valor->id)}}" class="edit">
                    <span class=""></span>
                    Alterar
                </a>                
            </td>

            <td><a href="{{route('usuarios.show', $valor->id)}}" class="delete">
                    <span class=""></span>
                    Excluir
                </a>
            </td>
            @endforeach            
        </tr>        
    </tbody>    
</table>

{!! $objUser !!}

@endsection
