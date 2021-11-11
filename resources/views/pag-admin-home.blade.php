@extends('layouts.admin-home')

@section('content')
<!--Mensagem de sucesso-->
@if(session()->has('sucesso'))
<div class="alert alert-success">
    {{ session()->get('sucesso') }}
</div>
@endif
<h4>Seja bem vindo(a) <strong>{{ucwords(Auth::user()->name)}}</strong>!</h4>
    <div class="jumbotron pg-home">
        
        <h2>Sistema de Gestão Financeira</h2><br/><br/>
        <div class="row">

            <!--Recebimento-->
            <div class="col-sm-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h3>Recebimento:</h3>
                                <h4>À receber: <strong>R$ {{$aReceber}}</strong></h4>
                                <h4>Recebido: <strong>R$ {{$recebido}}</strong></h4>
                            </div>
                        </div>

                    </div>

                    <div class="panel-heading">
                        <div class="row">                            
                            <div class="col-sm-12 text-center">                               
                                <img src="{!! asset('img/receber.png') !!}">
                            </div>                           
                        </div>

                    </div>
                </div>
            </div>


            <!--Pagamento-->
            <div class="col-sm-4">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h3>Pagamento:</h3>
                                <h4>À pagar: <strong>R${{$aPagar}}</strong></h4>
                                <h4>Pago: <strong>R${{$pago}}</strong></h4>
                            </div>
                        </div>

                    </div>

                    <div class="panel-heading">
                        <div class="row">                            
                            <div class="col-sm-12 text-center">                               
                                <img src="{!! asset('img/pagamento.png') !!}">
                            </div>                           
                        </div>

                    </div>
                </div>
            </div>


            <!--Fluxo de caixa-->
            <div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h3>Fluxo Caixa:</h3>
                                <h4>À receber - À pagar = <strong>R${{$saldo}}</strong> </h4>                               
                                <h4>Saldo Recebido - Pago = <strong>R${{$saldo_fluxo}}</strong></h4>
                            </div>
                        </div>

                    </div>

                    <div class="panel-heading">
                        <div class="row">                            
                            <div class="col-sm-12 text-center">                               
                                <img src="{!! asset('img/fluxo.png') !!}">
                            </div>                           
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
