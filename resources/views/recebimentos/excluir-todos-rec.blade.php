@if(count($quant_rec) > 0)

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
            <a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

            <h1 class="title-pg">{{$title}}</h1>
            <h4><strong> Nº de recebimento({{$quant_rec}})</strong></h4>


            {!! Form::open(['route' => ['DeleteTodasRec'], 'method' => 'DELETE']) !!}

            {!! Form::submit("Excluir todos recebimentos", ['class' => 'btn btn-danger btn-lg']) !!}

            {!! Form::close() !!}

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data de Vencimento</th>                        
                        <th>Nome</th>                    
                        <th>Valor</th>                                        
                        <th>Categoria</th>
                        <th>Nota Fiscal</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($obj_rec as $valor)
                    <tr>

                        <td>{{$valor->id}}</td>
                        <td>{{date('d/m/Y', strtotime($valor->data_vencimento))}}</td>                        
                        <td>{{$valor->nome_recebimento}}</td>
                        <td>R${{number_format($valor->valor, 2, ',', '.')}}</td>                                               
                        <td>{{$valor->nome}}</td>     
                        <td>{{$valor->nota_fiscal_cr}}</td>                       

                        <td><a href="{{route('recebimento.show', $valor->id)}}" class="delete">
                                <span class=""></span>
                                Excluir
                            </a>
                        </td>
                        @endforeach            
                    </tr>   
                </tbody>               
            </table>
            <h3>Total de recebimentos: R${{$soma_moeda_real}}</h3>
        </div>
    </div>
</div>
@endsection
@else
<div class="alert alert-danger">
    <h4>Não existe recebimento para este dia!</h4>
</div>
<a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

@endif



