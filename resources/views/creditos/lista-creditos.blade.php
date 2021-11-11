@extends('layouts.admin-home')

@section('content')

<!--Tabela Zebrada-->
@push('scripts')
<link rel="stylesheet" href="{{url('assets/css/table-striped.css')}}"/>
@endpush
<h4>Seja bem vindo(a) à <strong style="text-transform:capitalize;">{{Auth::user()->name }}</strong>!</h4>
<h2 class="title-pg">{{$title}}</h2>
<h3 class="text-center">Periódo do Mês:<strong>{{$carbon->now()->format('m/Y')}}</strong></h3>

<!--Mensagem de sucesso-->
@if(session()->has('sucesso'))
<div class="alert alert-success">
    {{ session()->get('sucesso') }}
</div>
@endif

<!-- Link para voltar -->
<a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

{!! Form::open(['route' => 'filtroFormaRecebimento', 'class' => 'form-horizontal', 'method' => 'get']) !!}
<div class="form-group">       
    <label>Forma de pagamento:</label>
    <div class="input-group">       
        <select name="forma-pag" id="forma-pag">
            <option>Filtro pagamento:</option>
            <option value="1">Dinheiro</option>
            <option value="2">Banco</option>
        </select>       

    </div>
</div>
<button class="btn btn-primary" type="submit">Filtrar</button>
{!! Form::close() !!}


<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cód. Recebimento</th>
                        <th>Nome Crédito</th>
                        <th>Data recebida</th>
                        <th>Valor</th>
                        <th>Forma de pagamento</th>                 
                        <th>Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($obj_cred as $valor)
                    <tr>
                        <td>{{$valor->id}}</td>
                        <td><strong>{{$valor->receipt_id}}</strong></td>
                        <td>{{$valor->nome_credito}}</td>  
                        <td>{{$carbon->parse($valor->data_recebimento)->format('d/m/Y')}}</td>
                        <td>R${{number_format($valor->valor, 2, ',', '.')}}</td>       
                        <td>{{$valor->tipo}}</td>                               
                        <td>{{$valor->nome}}</td>
                        @endforeach            
                    </tr>        
                </tbody>    
            </table>
            <h3>Total de créditos: R${{$somatorio}}</h3>

        </div><!-- /fim da table-responsive-->
    </div><!-- /fim da div col-md-12-->
</div><!-- /fim da div row -->


@endsection

