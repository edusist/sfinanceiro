<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Sistema financeiro</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{url('Https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css')}}"/>

    </head>
    <body>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Data de Vencimento</th>   
                    <th>Nota Fiscal</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Descrição</th>                        
                    <th>Data da alteração</th>
                    <th>Ações</th>

                </tr>
            </thead>
            <tbody>
                @foreach($pagar as $valor)
                <tr>
                    <td>{{$valor->id}}</td>
                    <td>{{$valor->nome_pagamento}}</td>   
                    <td>{{$valor->data_vencimento}}</td>
                    <td>{{$valor->nota_fiscal_cp}}</td>
                    <td>R${{$valor->valor}}</td>
                    <td>{{$valor->status}}</td>
                    <td>{{$valor->descricao}}</td>                            
                    <td>{{$valor->updated_at}}</td>

                    @endforeach            
                </tr>   
            </tbody>    
        </table>
        @if($soma_moeda_real)

            <h3>Total de pagamentos: R${{$soma_moeda_real}}</h3>

        @endif
        <!-- Scripts -->
        <script src="{{url('https://code.jquery.com/jquery-3.1.1.min.js')}}" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js')}}"></script>
        <script src="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js')}}"></script>


    </body>
</html>