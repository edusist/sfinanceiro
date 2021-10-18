<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Sistema financeiro</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="{{url('https://code.jquery.com/jquery-3.1.1.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{url('assets/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('assets/css/style.css')}}"/>   
        <link rel="stylesheet" type="text/css" href="{{url('assets/css/stilo-form.css')}}"/>  
        <link rel="stylesheet" type="text/css" href="{{url('assets/datepicker/css/bootstrap-datepicker.css')}}"/>

    </head>
    <body>
        <header>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand visible-xs" href="#" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">Menu 2</a>
                    </div>
                    <!--Cadastro-->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="{{route('admin.painel')}}">Home</a></li>                        
                            <li>
                                <!-- Cadastrar -->
                                <a href="{{route('recebimento.create')}}" class="">
                                    <span class="Glyphicon glyphicon-plus"></span>    
                                    Cadastrar
                                </a>
                            </li>
                            <li>
                                <!-- Cadastrar parcelamento-->
                                <a href="{{route('formCadParcelamentoRec', $empresa_id)}}" class="">
                                    <span class="Glyphicon glyphicon-plus"></span>    
                                    Parcelar
                                </a>
                            </li>
                            <li>
                                <!-- Excluir -->
                                <a href="{{route('getExcluirTodasRec')}}" class="">
                                    <span class="glyphicon glyphicon-remove"></span>    
                                    Excluir Todos
                                </a>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="">
                                    <span class="caret"></span>  
                                    Filtrar por período
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{route('filtroPorPeriodo', 1)}}">Diário</a></li>
                                    <li><a href="{{route('filtroPorPeriodo', 2)}}">Semanal</a></li>
                                    <li><a href="{{route('filtroPorPeriodo', 3)}}">Mensal</a></li>
                                    <li><a href="{{route('filtroPorPeriodo', 4)}}">Anual</a></li>     
                                    <li><a href="{{route('filtroPorPeriodo', 5)}}">Todos</a></li> 
                                </ul>
                            </li>
                        </ul>
                        <!-- Pesquisar geral -->
                        <form action="{{route('informacaoPesquisaReceber')}}" method="get" id="form-pesquisa" class="navbar-form navbar-right">            
                            <div class="form-group">
                                <input type="text" name="pesquisar" class="form-control" required="required" placeholder="Nome/valor/categoria..."/>                      
                                <button class="btn btn-default" type="submit">Pesquisar</button>                                
                            </div>    
                        </form> 

                        <!-- Pesquisar por data -->
                        <!-- Botão para chamar o modal -->
                        <button type="button" id="btn-modal" name="modal-calendario" class="btn btn-default navbar-btn" data-target="#modal-calendario">Pesquisar por data de vencimento</button>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </header>
        <!-- Contéudo principal -->
        <div class="container-fluid">


        </div>
        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="{{url('http://code.jquery.com/ui/1.10.3/jquery-ui.js')}}"></script>        



    </body>
</html>


