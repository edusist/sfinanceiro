<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Sistema financeiro</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="{{url('css/app.css')}}"/> 
        <link rel="stylesheet" href="{{url('css/bootstrap.css')}}"/>
        <link rel="stylesheet" href="{{url('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css')}}"/> 
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css"/>
    </head>
    <body>
        <header>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid bg-primary">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">logo</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{url('/home')}}">Home</a></li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Cadastro<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#/ListaFuncionarios">Funcionários</a></li>
                            <li><a href="#/TelaFornecedor">Fornecedores</a></li>
                            <li><a href="{{url('/clientes')}}">Clientes</a></li>
                            <li><a href="#">Bancos</a></li>
                            <li><a href="{{url('empresa_banco_ctrl.index')}}">Conta Bancária</a></li>
                            <li><a href="{{url('empresa.index')}}">Empresa</a></li>
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
                            <li><a href="recebimento.index')}}">Contas a Receber</a>
                            <li><a href="categoria_recebimento.index')}}">Categoria Recebimento</a></li> 
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
                            <li><a href="{{url('admin/register')}}">Administrador</a></li>                                
                            <li><a href="usuarios.index')}}">Usuário comum</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span>Cadastro</a></li>                   
                    <li><a href="admin.logout')}}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
        </nav>    
        </header>
        @yield('content')

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>   
        @stack('scripts')

    </body>
</html>