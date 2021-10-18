@extends('layouts.app')

@section('content_page')


<!--Pesquisar-->
<div class="row">
    <div class="col-md-12">
        <div class="panel-body">
            <h2 class="title-pg">{{$title}}</h2>  

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
                    @foreach($obj_Rec_tab as $valor)
                    <tr>
                        <td>{{$valor->id}}</td>
                        <td>
                            @php 
                            print_r($objDataBr->getDateOfBirthAttribute($valor->data_vencimento));
                            @endphp
                        </td>
                        <td>{{$valor->nota_fiscal_cr}}</td>
                        <td>{{$valor->nome_recebimento}}</td>
                        <td>
                            @php 
                            print_r('R$'.number_format($valor->valor, 2, ',', '.'));
                            @endphp
                        </td>                            
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
@endsection