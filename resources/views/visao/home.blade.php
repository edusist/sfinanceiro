@extends('layouts.usuario.usuario-app')

@section('content')

<div class="container">
    <div class="jumbotron">
        <h2 style="text-align: center;">Sistema financeiro</h2> 
        <div class="row">

            <!--Recebimento-->
            <div class="col-sm-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h4>Recebimento: <strong>R$ {{$recebimento}}</strong></h4>
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
                                <h4>Pagamento: <strong>R${{$pagamento}}</strong></h4>
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
                                <h4>Fluxo de caixa: <strong>R${{$fluxo_caixa}}</strong></h4>
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

</div>

@endsection
