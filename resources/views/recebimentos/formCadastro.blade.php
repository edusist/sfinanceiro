@extends('layouts.admin-home')

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Mensagem de erros-->
        @if( isset($errors) && count($errors) > 0 )
        <div class="alert alert-danger">
            @foreach($errors->all() as $err)
            <p>{{$err}}</p>
            @endforeach
        </div>         
        @endif   

        <h1 class="title-pg"><b>{{$title}}</b></h1>

        <!-- Link para voltar -->
        <a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

        <!-- Inicio da modal-->
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <!-- Formulário utilizado tanto para cadastrar, quanto para editar -->
                    @if(isset($obj_rec) && isset($obj_rec->id))         

                    <!-- Envia para Tela para editar -->
                    {!! Form::model($obj_rec, ['route' => ['recebimento.update', $obj_rec->id], 'method' => 'put'])  !!}
                    {!! Form::hidden('companie_id', $obj_rec->companie_id, ['class' => 'form-control']) !!}  

                    @else

                    <!-- Envia para Tela para Salvar-->
                    {!! Form::open(['route' => 'recebimento.store', 'class' => 'form-horizontal']) !!}
                    {!! Form::hidden('companie_id', $id_empresa, ['class' => 'form-control']) !!} 
                    <!-- Envia o para o bd Status pagamento em aberto-->
                    {!! Form::hidden('status', 0) !!}
                    @endif 

                    <h4 class="modal-title">Recebimento</h4>
                </div><!-- /.modal header -->

                <div class="modal-body">               

                    <div class="form-group">
                        <label>Nome recebimento: </label>     
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></div>
                            {!! Form::text('nome_recebimento', null, ['class' => 'form-control', 'placeholder' => 'Digite o recebimento:']) !!}          
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
                                <input type="text" name="nota_fiscal_cr" id="nota_fiscal_cr" class="form-control" placeholder="Digite o número da NF:"/> 
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label>Valor: </label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></div>
                            <input class="form-control" type="text" name="valor" id="valor" data-thousands="." data-decimal="," placeholder="R$9.999,99" />      
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
                        <label>Categoria:</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></div>
                            <select  name="subcat_rec_id" id="subcat_rec_id" class="form-control">  
                                <option value="">Escolha uma Categoria</option>                        
                                @foreach($obj_cat_rec as $cat_rec)
                                <option value="{{$cat_rec->id}}"
                                        @if(isset($obj_rec->subcat_rec_id) && ($obj_rec->subcat_rec_id == $cat_rec->id))
                                        selected
                                        @endif
                                        >{{$cat_rec->nome}}
                            </option> 
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Descricao:</label>                                  
                    {!! Form::textarea('descricao', null, ['class' => 'form-control', 'cols' => '20', 'rows' => '5', 'placeholder' => 'Digite aqui...']) !!}
                </div>
            </div><!-- /.modal-body -->

            <!-- Inicio modal footer -->
            <div class="modal-footer">
                <div class="form-group">
                    {!! Form::submit('Salvar', ['class' => 'btn btn-primary'] ) !!}
                </div>
            </div><!-- /.modal footer -->  
            {!! Form::close() !!}

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>  <!-- /fim da col-md-12 -->
</div><!-- /fim da row -->
@endsection

@push('scripts')
<!-- Mascára do campo valor moeda -->
<script>
    $(function () {
        $('#valor').maskMoney();
    });
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script type="text/javascript" src="{{url('assets/js/exibe_nota_fiscal.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/calendario_Brasil.js')}}"></script>

@endpush