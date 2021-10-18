<!DOCTYPE html>
<html>
    <head>
        <title>{{$title or '.::Sistema financeiro - Home::.'}}</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Bootstrap-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="{{url('css/style.css')}}"/>
        <link rel="stylesheet" href="{{url('css/bootstrap.css')}}"/>
        <link rel="stylesheet" href="{{url('Https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css')}}"/>
        <link rel="stylesheet" href="{{url('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css')}}"/>


    </head>
    <body class="container">            
        <!--Menu-->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand e toggle get agrupados para melhor exibição móvel-->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"></a>
                </div>

                <!-- Recolher os links de navegação, formulários e outros conteúdos para alternar -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="{{url('/')}}">Home<span class="sr-only">(current)</span></a></li> 
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cadastros<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{route('usuarios.index')}}">Usuários</a></li>
                                <li><a href="#/ListaFuncionarios">Funcionários</a></li>
                                <li><a href="#/TelaFornecedor">Fornecedores</a></li>
                                <li><a href="{{route('cliente.index')}}">Clientes</a></li>
                                <li><a href="{{route('banco_ctrl.index')}}">Bancos</a></li>
                                <li><a href="{{route('empresa_banco_ctrl.index')}}">Conta Bancária
                                    </a></li>
                                <li><a href="{{route('empresa.index')}}">Empresa</a></li>
                            </ul>
                        </li>
                        <li><a href="#"></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pagamento<span class="caret"></span></a>                          
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#">Contas a Pagar</a>
                                <li><a href="#">Categoria Pagamento</a></li> 
                            </ul>
                        </li>
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Recebimento<span class="caret"></span></a>                          
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="{{route('recebimento.index')}}">Contas a Receber</a>
                                <li><a href="{{route('categoria_recebimento.index')}}">Categoria Recebimento</a></li> 
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relatórios<span class="caret"></span></a>                          
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#/TelaFluxoCaixa">Fluxo de Caixa</a></li>
                                <li><a href="#">Extrato</a></li>
                            </ul>
                        </li>

                    </ul>    


                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        @yield('content')
        <!--Obs:. Sempre carregar o jquery antes do boostrap, linha acima do boostrap -->
<!--        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
<!--        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->
        <script src="{{url('https://code.jquery.com/jquery-3.1.1.min.js')}}" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

        <script src="{{url('js/bootstrap.min.js')}}"></script>
        <script src="{{url('js/datepicker_formato_pt_br.js')}}"></script>
        <script src="{{url('http://code.jquery.com/ui/1.10.3/jquery-ui.js')}}"></script>
    </body>
</html>
