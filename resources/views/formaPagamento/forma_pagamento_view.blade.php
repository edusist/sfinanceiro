@extends('layouts.admin-home')

@section('content')
<!--Tabela Zebrada-->
@push('scripts')
<link rel="stylesheet" href="{{url('assets/css/table-striped.css')}}"/>

@endpush
<!-- Link para voltar -->
<a href="{{route('admin.painel')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
<h2 class="title-pg">{{$title}}</h2>
<a href="{{route('forma-pagamento.create')}}" class="btn btn-primary">
    <span class="Glyphicon glyphicon-plus"></span>    
    Novo
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
            <th>Tipo</th>      
            <th>Data da alteração</th>
            <th>Ações</th>

        </tr>
    </thead>
    <tbody>
        @foreach($forma_pag as $valor)
        <tr>
            <td>{{$valor->id}}</td>
            <td>{{$valor->tipo}}</td>                    

            <td>{{$carbon->parse($valor->updated_at)->format('d/m/Y')}}</td>
            <td><a href="{{route('forma-pagamento.edit', $valor->id)}}" class="edit">
                    <span class=""></span>
                    Alterar
                </a>                
            </td>

            <td><a href="{{route('forma-pagamento.show', $valor->id)}}" class="delete">
                    <span class=""></span>
                    Excluir
                </a>
            </td>
            @endforeach            
        </tr>        
    </tbody>    
</table>

{{ $forma_pag->links() }}

@endsection
