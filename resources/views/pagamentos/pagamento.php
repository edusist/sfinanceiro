@extends('templates.templates')

@section('content')

<h2 class="title-pg">{{$title}}</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Nota Fiscal</th>
            <th>Valor</th>
            <th>Status</th>
            <th>Descrição</th>
            <th>Data de Vencimento</th>
            <th>Empresa</th>
            <th>Cliente</th>
            <th>Categoria</th>
            <th>Data da criação</th>
            <th>Data da alteração</th>
            <th style="">Ações</th>

        </tr>
    </thead>
    <tbody>
        @foreach($obj_rec as $valor)
        <tr>
            <td>{{$valor->id}}</td>
            <td>{{$valor->nome}}</td>                    
            <td>{{$valor->nota_fiscal_cr}}</td>
            <td>{{$valor->valor}}</td>
            <td>{{$valor->status}}</td>
            <td>{{$valor->descricao}}</td>
            <td>{{$valor->data_vencimento}}</td>
            <td>{{$valor->companie_id}}</td> 
            <td>{{$valor->customer_id}}</td>    
            <td>{{$valor->categorys_receipt_id}}</td>    
            <td>{{$valor->created_at}}</td>
            <td>{{$valor->updated_at}}</td>

            <td><a href="#" class="edit">
                    <span class=""></span>
                    Alterar
                </a>                
            </td>

            <td><a href="#" class="delete">
                    <span class=""></span>
                    Excluir
                </a>
            </td>
            @endforeach            
        </tr>        
    </tbody>    
</table>

@endsection