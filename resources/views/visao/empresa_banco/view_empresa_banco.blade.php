@extends('layouts.admin-home')

@section('content')

<h1 class="title-pg">{{$title}}</h1>
<a href="{{route('empresa_banco_ctrl.create')}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon-plus"></span>    
    Cadastrar
</a>
<!--Tratamento de sucesso-->
@if(session()->has('sucesso'))
<div class="alert alert-success">
    {{ session()->get('sucesso') }}
</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>Empresa</th> 
            <th>Banco</th>              
            <th>agencia</th>
            <th>Conta/corrente</th>
            <th>Saldo</th>              
            <th>Data da criação</th>
            <th>Data da alteração</th>         

        </tr>
    </thead>
    <tbody>
        @foreach($objEmpBanco as $valor)
        <tr>
            <td>{{$valor->companie_id}}</td>
            <td>{{$valor->bank_id}}</td>            
            <td>{{$valor->agencia}}</td>                    
            <td>{{$valor->conta_corrente}}</td>    
            <td>{{$valor->saldo}}</td>
            <td>{{$data_carbon->parse($valor->updated_at)->format('d/m/Y')}}</td>
            <td>{{$data_carbon->parse($valor->created_at)->format('d/m/Y')}}</td>            

            @endforeach            
        </tr>        
    </tbody>    
</table>

{!! $objEmpBanco !!}

@endsection
