@extends('layouts.admin-home')

@section('content')

<!--Tabela Zebrada-->
@push('scripts')
<link rel="stylesheet" href="{{url('assets/css/table-striped.css')}}"/>
@endpush

<h2 class="title-pg">{{$title}}</h2>

<!--Mensagem de sucesso-->
@if(session()->has('sucesso'))
<div class="alert alert-success">
    {{ session()->get('sucesso') }}
</div>
@endif

<!-- Link para voltar -->
<a href="{{route('listaCreditos')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome Crédito</th>
                        <th>Data recebida</th>
                        <th>Valor</th>
                        <th>Forma de pagamento</th>                 
                        <th>Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($retorno_pag as $valor)
                    <tr>
                        <td>{{$valor->id}}</td>
                        <td>{{$valor->nome_credito}}</td>  
                        <td>{{$carbon->parse($valor->data_recebimento)->format('d/m/Y')}}</td>
                        <td>R${{number_format($valor->valor, 2, ',', '.')}}</td>       
                        <td>{{$valor->tipo}}</td>                               
                        <td>{{$valor->nome}}</td>
                        @endforeach            
                    </tr>        
                </tbody>    
            </table>
            <h3>Total: R${{number_format($somatorio, 2, ',', '.')}}</h3>

        </div><!-- /fim da table-responsive-->
    </div><!-- /fim da div col-md-12-->
</div><!-- /fim da div row -->


@endsection

