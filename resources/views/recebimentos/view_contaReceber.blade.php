        @extends('layouts.admin-home')

@section('content')
<!-- Link para voltar -->
  <a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
  
<h4>Seja bem vindo(a) à <strong style="text-transform:capitalize;">{{Auth::user()->name }}</strong>!</h4>

<h1 class="title">{{$title}}</h1>
<h3 class="text-center">Periódo do Mês:<strong>{{$data_carbon->now()->format('m/Y')}}</strong></h3>
<h4> Nº de recebimentos({{$quant_rec}})</h4>

@if( isset($errors) && count($errors) > 0 )
<div class="alert alert-danger">
    @foreach($errors->all() as $err)
    <p>{{$err}}</p>
    @endforeach
</div>         
@endif 
<!--Mensagem de sucesso-->
@if(session()->has('sucesso'))
<div class="alert alert-success">
    {{ session()->get('sucesso') }}
</div>
@endif

<div class="row"><!-- row do nav2-->
    <!--col-md-12-->
    <div class="col-md-12">
        <!--navbar 2-->
        <nav class="navbar navbar-default">
            <div class="container-fluid">           

                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand visible-xs" href="#" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">Cadastro e pesquisa</a>
                </div>
                <!--Cadastro-->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                    <ul class="nav navbar-nav">                                            
                        <li>
                            <!-- Cadastrar -->
                            <a href="{{route('recebimento.create')}}" class="">
                                <span class="Glyphicon glyphicon-plus"></span>    
                                Novo
                            </a>
                        </li>
                        <li>
                            <!-- Cadastrar parcelamento-->
                            <a href="{{route('formCadParcelamentoRec', 1)}}" class="">
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

            </div><!--/ fim container-fluid-->
        </nav><!--/ fim row do nav2-->

    </div><!--/fim col-md-12-->
</div><!--/ fim row do nav2-->

<!-- Extrutura do modal -->
<div class="modal fade bs-example-modal-sm" id="modal-calendario" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pesquisar no Calendário Receber</h4>
            </div>

            <!-- Calendário dentro do modal -->            
            <div class="modal-body">          
                <form method="post" action="{{route('pesquisarDataReceber')}}">
                    {{ csrf_field() }}
                    <div class="input-group date data-calendario">
                        <input type="text" id="data-calendario" name="data-calendario"  required="required" placeholder="00/00/000" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                        <button type="submit" class="btn btn-success">Pesquisar</button>

                    </div>
                </form>
            </div>

            <!--/fim Calendário modal -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog-->
</div><!-- /.modal -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">        
            <table class="table table-hover" id="id_tabela">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data de Vencimento</th>                          
                        <th>Nome</th>                       
                        <th>Nota Fiscal</th>
                        <th>Valor</th>                    
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($obj_Rec_tab as $valor)
                    <tr>
                        <td>{{$valor->id}}</td>
                        <td>{{$data_carbon->parse($valor->data_vencimento)->format('d/m/Y')}}</td>                        
                        <td>{{$valor->nome_recebimento}}</td>                          
                        <td>{{$valor->nota_fiscal_cr}}</td>                        
                        <td>R${{number_format($valor->valor, 2, ',', '.')}}</td>                  
                        <td>{{$valor->nome}}</td>
                        <td class="status">{{$valor->status}}</td>
                        <td><a href="{{route('recebimento.edit', $valor->id)}}" class="edit">Alterar</a></td>
                        <td><a href="{{route('recebimento.show', $valor->id)}}" class="delete">Excluir</a></td> 
                        <td><a href="{{route('recebido', $valor->id)}}"><span class="recebido">Receber</span></a></td> 
                    </tr>   
                    @endforeach 
                </tbody>    
            </table>
            @if($soma_moeda_real)
            <h3>Total de recebimentos: R${{$soma_moeda_real}}</h3>
            @endif

        </div><!-- /fim da div table-responsive-->    
    </div><!-- /fim da div col-md-12-->
</div><!-- /fim da div row-->
{{ $obj_Rec_tab->links() }}
<!--<div class="resultado">

</div>-->
@endsection
@push('scripts')
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/modal-calendario.js')}}"></script>
{{-- Verificar o status do Recebimento --}}
<script type="text/javascript" src="{{url('assets/js/status_recebim_pagam.js')}}"></script>
@endpush