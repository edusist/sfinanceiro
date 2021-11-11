@if(count($recebi_filtro) > 0)
   @extends('layouts.admin-home')
@section('content')

<!--Tabela Zebrada-->
@push('scripts')
<link rel="stylesheet" href="{{url('assets/css/table-striped.css')}}"/>

@endpush

<div class="row">
    <div class="col-md-12">
        <div class="panel-body"> 
            <!--Mensagem de sucesso-->
            @if(session()->has('sucesso'))
            <div class="alert alert-success">
                {{ session()->get('sucesso') }}
            </div>
            @endif
            <!-- Link para voltar -->
            <a href="{{route('pagamento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
            
            <h1 class="title-pg">{{$title}}</h1>
            <h4><strong> Nº de pagamento({{$quant_pag}})</strong></h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data de Vencimento</th>                        
                        <th>Nome</th>                    
                        <th>Valor</th>   
                        <th>Nota Fiscal</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recebi_filtro as $valor)
                    <tr>
                       
                        <td>{{$valor->id}}</td>
                        <td>{{date('d/m/Y', strtotime($valor->data_vencimento))}}</td>                        
                        <td>{{$valor->nome_pagamento}}</td>
                        <td>R${{number_format($valor->valor, 2, ',', '.')}}</td>                                
                        <td>{{$valor->nota_fiscal_cp}}</td>

                        <td><a href="{{route('pagamento.edit', $valor->id)}}" class="edit">
                                <span class=""></span>
                                Alterar
                            </a>                
                        </td>

                        <td><a href="{{route('pagamento.show', $valor->id)}}" class="delete">
                                <span class=""></span>
                                Excluir
                            </a>
                        </td>
                        @endforeach            
                    </tr>   
                </tbody>               
            </table>
            <h3>Total de pagamentos: R${{$soma_moeda_real}}</h3>
        </div>
    </div>
</div>

@endsection
@else
<div class="alert alert-danger">
    <h4>Não existe pagamento para este período!</h4>
</div>
<a href="{{route('pagamento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

@endif



