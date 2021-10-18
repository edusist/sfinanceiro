@extends('layouts.admin-home')

@section('content')
<h4 style="margin-top: -30px; padding-top: 10px; padding-bottom: 20px;">Seja bem vindo(a) à <strong style="text-transform:capitalize;">{{$nome_empresa}}</strong>!</h4>
<h4 class="title-pg">{{$title}}</h4>
<h4><strong> Nº de recebimentos({{$quant_rec}})</strong></h4>

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

<div class="row">
    <div class="col-md-6">

        <!-- Cadastrar -->
        <a href="{{route('recebimento.create')}}" class="btn btn-primary">
            <span class="Glyphicon glyphicon-plus"></span>    
            Cadastrar
        </a>

        <!-- Cadastrar parcelamento-->
        <a href="{{route('formCadParcelamentoRec', $empresa_id)}}" class="btn btn-primary">
            <span class="Glyphicon glyphicon glyphicon-download-alt"></span>    
            Parcelamento do contas à receber
        </a>

    </div><!-- /fim da div col-md-6 -->

    <div class="col-md-6">
        <!-- Pesquisar -->
        <form action="{{route('informacaoPesquisa')}}" method="get" id="form-pesquisa" class="pull-right">
            <div class="input-group">
                <input type="text" name="pesquisar" class="form-control" required="required" placeholder="Pesquisar..."/>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </span>           
            </div>    
        </form> 

        <!-- Botão para chamar o modal -->
        <button type="button" id="btn-modal" name="modal-calendario" class="btn btn-primary pull-right" data-target="#modal-calendario">Pesquisa por data</button>

        <!-- Extrutura do modal -->
        <div class="modal fade bs-example-modal-sm" id="modal-calendario" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Pesquisar no Calendário</h4>
                    </div>

                    <!-- Calendário dentro do modal -->            
                    <div class="modal-body">          
                        <form method="post" action="{{route('pesquisarDataReceber')}}">
                            {{ csrf_field() }}
                            <div class="input-group date data-calendario-pag">
                                <input type="text" id="data-calendario" name="data-calendario"  placeholder="00/00/000" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
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


    </div><!-- /fim da div col-md-6 -->
</div><!-- /fim da div row -->


<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-striped table-condensed" id="id_tabela">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Data de Vencimento</th>   
                    <th>Nota Fiscal</th>
                    <th>Valor</th>
                    <th>Fornecedor</th>           
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($obj_Rec_tab as $valor)
                <tr>
                    <td>{{$valor->id}}</td>
                    <td>{{$valor->nome_recebimento}}</td>   
                    <td>{{$data_carbon->parse($valor->data_vencimento)->format('d/m/Y')}}</td>
                    <td>{{$valor->nota_fiscal_cr}}</td>
                    <td>R${{number_format($valor->valor, 2, ',', '.')}}</td>          
                    <td>{{$valor->nome_cliente}}</td>    
                    <td><a href="{{route('recebimento.edit', $valor->id)}}" class="edit">Alterar</a></td>
                    <td><a href="{{route('recebimento.show', $valor->id)}}" class="delete">Excluir</a></td> 
                    <td><a href="{{route('recebido', $valor->id)}}" class="">Recebido</a></td> 
                </tr>   
                @endforeach 
            </tbody>    
        </table>
        @if($soma_moeda_real)
        <h3>Total de recebimentos: R${{$soma_moeda_real}}</h3>
        @endif

        {!! $obj_Rec_tab  !!}
    </div><!-- /fim da div col-md-12-->
</div><!-- /fim da div row -->

@endsection
@push('scripts')

<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.pt-BR.min.js')}}"></script>

<script>
$('#btn-modal').click(function () {
    $('#modal-calendario').modal();
});

$('.data-calendario-pag').datepicker({
    format: "dd/mm/yyyy",
    clearBtn: true,
    language: "pt-BR"
});


</script>
@endpush