@extends('layouts.admin-home')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h1 class="title-pg"><b>{{$title}}</b></h1>

        <!-- Tratamento de erros -->
        @if( isset($errors) && count($errors) > 0 )
        <div class="alert alert-danger">
            @foreach($errors->all() as $err)
            <p>{{$err}}</p>
            @endforeach
        </div>         
        @endif    

        <!-- Link para voltar -->
        <a href="{{route('pagamento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

        <!-- Inicio da modal-->
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-primary">

                    <!-- Formulário utilizado tanto para cadastrar, quanto para editar -->
                    @if(isset($obj_pag) && isset($obj_pag->id))
                    <!-- Envia para Tela para editar -->        
                    {!! Form::model($obj_pag, ['route' => ['pagamento.update', $obj_pag->id], 'class' => 'form', 'method' => 'put'])  !!}
                    {!! Form::hidden('companie_id', $obj_pag->companie_id, ['class' => 'form-control']) !!} 
                    @else
                    <!-- Envia para Tela para Salvar-->
                    <!-- Recebe o id da empresa-->
                    {!! Form::open(['route' => 'pagamento.store', 'class' => 'form']) !!}
                    {!! Form::hidden('companie_id', $id_empresa, ['class' => 'form-control']) !!} 
                    <!-- Envia o para o bd Status pagamento em aberto-->
                    {!! Form::hidden('status', 0) !!}

                    @endif         
                    <h4 class="modal-title">Pagamento</h4>
                </div><!-- /.modal header -->

                <div class="modal-body">  
                    <div class="form-group">
                        <label>Nome Pagamento:</label>     
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></div>
                            {!! Form::text('nome_pagamento', null, ['class' => 'form-control', 'placeholder' => 'Digite o pagamento:']) !!} 
                        </div>
                    </div>

                    <div class="form-group">
                        <label> Cadastrar Nota fiscal? </label> 
                        <input type="checkbox" name="exibe-nf" id="exibe-nf">               
                    </div>

                    <div class="form-group">

                        <div id="nota-fiscal" hidden>   
                            <label>Nota Fiscal:</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></div>                        
                                <input type="text" name="nota_fiscal_cp" id="nota_fiscal_cp" class="form-control" placeholder="Digite o número da NF:"/> 
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Valor: </label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></div>
                            {!! Form::text('valor', null, ['class' => 'form-control', 'id' => 'valor',  'placeholder' => 'R$9.999,99', 'data-thousands' => '.', 'data-decimal' => ',']) !!}               
                        </div>
                    </div>   
                    
                    <div class="form-group">
                        <label>Data vencimento: </label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                            {!! Form::text('data_vencimento', null, ['class' => 'form-control', 'id' => 'data_vencimento',  'placeholder' => '00/00/00']) !!} 
                        </div>
                    </div>

                    <div class="form-group">       
                        <label>Categoria: </label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></div>
                            <select  name="subcat_pag_id" id="subcat_pag_id" class="form-control">  
                                <option value="">Escolha uma Categoria</option>                        
                                @foreach($obj_cat_pag as $cat_pag)
                                <option value="{{$cat_pag->id}}"
                                        @if(isset($obj_pag->subcat_pag_id) && ($obj_pag->subcat_pag_id == $cat_pag->id))
                                        selected
                                        @endif
                                        >{{$cat_pag->nome}}
                            </option> 
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Descricao:</label> 
                    {!! Form::textarea('descricao', null, ['class' => 'form-control', 'cols' => '20', 'rows' => '5', 'placeholder' => 'Digite aqui...:']) !!}
                </div> 
            </div> <!-- /.modal-body -->
            <div class="modal-footer">
                <div class="form-group">

                    {!! Form::submit('Salvar', ['class' => 'btn btn-primary'] ) !!}
                </div>
            </div>  <!-- /.modal footer -->       


            {!! Form::close() !!}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>  <!-- /fim da col-md-12 -->
</div><!-- /fim da row -->
@endsection

@push('scripts')
<script>
    $(function () {
        $('#valor').maskMoney();
    });
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script type="text/javascript" src="{{url('assets/js/exibe_nota_fiscal.js')}}"></script>
<!-- Scripts para Abrir o calendário no formato Brasileiro  -->
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/calendario_Brasil.js')}}"></script>
@endpush