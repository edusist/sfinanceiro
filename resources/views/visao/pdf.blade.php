<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Sistema financeiro</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{url('Https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css')}}"/>
        
    </head>
    <body>
        <div>
            <h1>Relatório de clientes</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Cnpj/Cpf</th>
                        <th>Email</th>
                        <th>Descrição</th>
                        <th>Telefone</th>
                        <th>Endereço</th>
                        <th>Cidade</th>
                        <th>Data da alteração</th>                    

                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $valor)
                    <tr>
                        <td>{{$valor->id}}</td>
                        <td>{{$valor->nome}}</td>                    
                        <td>{{$valor->cnpj_cpf}}</td>
                        <td>{{$valor->email}}</td>
                        <td>{{$valor->descricao}}</td>
                        <td>{{$valor->telefone_fixo}}</td>
                        <td>{{$valor->endereco}}</td>   
                        <td>{{$valor->cidade}}</td>
                        <td>{{date('d/m/Y', strtotime($valor->updated_at))}}</td>
                    </tr>
                    @endforeach
                </tbody>    
            </table>
        </div>
        <!-- Scripts -->
        <script src="{{url('https://code.jquery.com/jquery-3.1.1.min.js')}}" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script src="{{url('https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js')}}"></script>
        <script src="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js')}}"></script>


    </body>
</html>