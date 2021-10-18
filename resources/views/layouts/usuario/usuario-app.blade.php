<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>.::Sistema financeiro - Usuário::.</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="{{url('https://code.jquery.com/jquery-3.1.1.min.js')}}"></script>
        <link rel="stylesheet" href="{{url('assets/css/style.css')}}"/>
        <link rel="stylesheet" href="{{url('assets/css/bootstrap.css')}}"/>
        <link rel="stylesheet" href="{{url('assets/datepicker/css/bootstrap.min.css')}}"/>      
        <link rel="stylesheet" href="{{url('assets/datepicker/css/bootstrap-datepicker.css')}}"/>

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>
    <body>

        <nav class="navbar navbar-inverse">
            <div class="container-fluid bg-primary">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">logo</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>             
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
                <ul class="nav navbar-nav navbar-right">                  

                    <li class="dropdown">
                        <a href="{{ route('logout') }}" class="dropdown-toggle" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="glyphicon glyphicon-log-out">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                </ul>
                </li>

                </ul>
            </div>
        </nav>

        <div class="container">
            <h3></h3>

        </div>
        @yield('content')
        <!-- Scripts -->        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="{{url('http://code.jquery.com/ui/1.10.3/jquery-ui.js')}}"></script>       
        @stack('scripts')

    </body>
</html>
