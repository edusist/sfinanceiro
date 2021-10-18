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
        
        <h2>Sistema de Gestão Financeira - AIO</h2><br/><br/>
        <div class="row">

            <!--Recebimento-->
            <div class="col-sm-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h4>À receber: <strong>R$ {{$areceber}}</strong></h4>
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
                                <h4>À pagar: <strong>R${{$apagar}}</strong></h4>
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
                                <h3>Saldo</h3>
                                <h4> Fluxo Caixa: <strong>R${{$saldo_fluxo}}</strong> </h4>
                                <h4> Dinheiro:  <strong>R${{$saldo_dinheiro}}</strong> <br />Banco: <strong>R${{$saldo_banco}}</strong></h4>                                
                                <h4>Total: <strong>R${{$saldo}}</strong></h4>
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
