<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Sistema financeiro</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{url('css/style.css')}}"/>
        <link rel="stylesheet" href="{{url('css/bootstrap.css')}}"/>
        <link rel="stylesheet" href="{{url('Https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css')}}"/>
        <link rel="stylesheet" href="{{url('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css')}}"/> 

    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid bg-primary">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">logo</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Cadastro<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#/ListaFuncionarios">Funcionários</a></li>
                            <li><a href="#/TelaFornecedor">Fornecedores</a></li>
                            <li><a href="{{route('cliente.index')}}">Clientes</a></li>
                            <li><a href="{{route('banco_ctrl.index')}}">Bancos</a></li>
                            <li><a href="{{route('empresa_banco_ctrl.index')}}">Conta Bancária</a></li>
                            <li><a href="{{route('empresa.index')}}">Empresa</a></li>
                        </ul>
                    </li>
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
                            <li><a href="{{route('recebimento.index')}}">Empresas</a>

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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuários<span class="caret"></span></a>                          
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">                                
                            <li><a href="">Administrador</a></li>                                
                            <li><a href="{{route('usuarios.index')}}">Usuário comum</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span>{{Auth::user()->name}}</a></li>                     
                    <li><a href="{{route('admin.logout')}}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <h3></h3>

        </div>
        @yield('content')
        <!-- Scripts -->
        <script src="{{url('https://code.jquery.com/jquery-3.1.1.min.js')}}" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="{{url('js/datepicker_formato_pt_br.js')}}"></script>
        <script src="{{url('http://code.jquery.com/ui/1.10.3/jquery-ui.js')}}"></script> 
        @stack('scripts')

    </body>
</html>



