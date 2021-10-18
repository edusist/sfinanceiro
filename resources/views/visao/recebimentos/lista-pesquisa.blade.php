@if(count($receber) > 0)
@extends('layouts.admin-home')
@section('content')
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
            
            <h1 class="title-pg">{{$title}}</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data de Vencimento</th> 
                        <th>Nota Fiscal</th>
                        <th>Nome</th>                    
                        <th>Valor</th>
                        <th>Status</th>        
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
                <tfoot>
                    <tr>
                        <td colspan="10">{{$receber->render()}}</td>
                    </tr>
                    
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
@else
{{count($receber)}}
<p>{{pesquisa_rec}} não encontrada</p>
@endif



