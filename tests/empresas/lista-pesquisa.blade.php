<!--Pesquisar-->
@extends('layouts.admin-app')
@section('content')
@if(count($receber) > 0)
<p>{{$receber}}</p>
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
            <a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data de Vencimento</th> 
                        <th>Nota Fiscal</th>
                        <th>Nome</th>                    
                        <th>Valor</th>
                        <th>Status</th>                                    
                        <th>Empresa</th>
                        <th>Cliente</th>
                        <th>Categoria</th>                    
                        <th>Ações</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($receber as $valor)
                    <tr>
                        <td>{{$valor->id}}</td>
                        <td>{{date('d/m/Y', strtotime($valor->data_vencimento))}}</td>
                        <td>{{$valor->nota_fiscal_cr}}</td>
                        <td>{{$valor->nome_recebimento}}</td>
                        <td>R${{number_format($valor->valor, 2, ',', '.')}}</td>                            
                        <td>{{$valor->status}}</td>                           
                        <td>{{$valor->nome_empresa}}</td> 
                        <td>{{$valor->nome_cliente}}</td>    
                        <td>{{$valor->nome_cat_rec}}</td>     

                        <td><a href="{{route('recebimento.edit', $valor->id)}}" class="edit">
                                <span class=""></span>
                                Alterar
                            </a>                
                        </td>

                        <td><a href="{{route('recebimento.show', $valor->id)}}" class="delete">
                                <span class=""></span>
                                Excluir
                            </a>
                        </td>
                        @endforeach            
                    </tr>   
                </tbody>    
            </table>
        </div>
    </div>
</div>

@else
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <p><b> {{$pesquisa_rec}} </b>Pesquisa não encontrada!</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection()