@extends('layouts.admin-home')

@section('content')
<div class="container-fluid">

    <!-- Link para voltar -->
    <a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

    <h2 class="title-pg">{{$title}}</h2>
    @if( isset($errors) && count($errors) > 0 )
    <div class="alert alert-danger">
        @foreach($errors->all() as $err)
        <p>{{$err}}</p>
        @endforeach
    </div>         
    @endif       

    <!-- Inicio da modal-->
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header bg-primary">
                <!-- Envia para Tela para editar ['route' => ['recebimento.update', $obj_rec->id],-->
                <div class="form-group">
                    {!! Form::open(['route' => 'postParcelamento', 'method' => 'post'])  !!}
                </div>         

                <h4 class="modal-title">Recebimentos parcelados</h4>
            </div><!-- /.modal header -->

            <div class="modal-body">  
                <!-- Envia o para o bd Status pagamento em aberto-->
                {!! Form::hidden('status', 0) !!}
                <div class="form-group">
                    {!! Form::hidden('companie_id', $id_empresa, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    <label>Nome recebimento: </label>     
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></div>

                        {!! Form::text('nome_recebimento', null, ['class' => 'form-control', 'placeholder' => 'Nome:']) !!} 
                    </div>
                </div>

                <div class="form-group">
                    <label>Nota fiscal: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></div>
                        {!! Form::text('nota_fiscal_cr', null, ['class' => 'form-control', 'placeholder' => 'Nota fiscal:']) !!}  
                    </div>
                </div>

                <div class="form-group">
                    <label>Valor: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></div>
                        {!! Form::text('valor', null, ['class' => 'form-control', 'placeholder' => '0,00']) !!} 
                    </div>
                </div>
                <div class="form-group">
                    <label>Tipo de Parcelas: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></div>
                        <select name="nome_parcela" id="nome_parcela" class="form-control">
                            <option value="">Escolha tipo de parcelamento</option>
                            @foreach($parcelamentos as $parcelamento)
                            <option>{{$parcelamento}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Quantidade de parcelas: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></div>
                        {!! Form::number('quant_parcelas', 'value', ['class' => 'form-control', 'placeholder' => 'Nº parcelas']) !!}  
                    </div>
                </div>

                <label>Descricao:</label>                                  
                {!! Form::textarea('descricao', null, ['class' => 'form-control', 'cols' => '20', 'rows' => '5', 'placeholder' => 'Digite aqui...']) !!}

                <div class="form-group">
                    <label>Data vencimento: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                        {!! Form::text('data_vencimento', null, ['class' => 'form-control', 'id' => 'data_vencimento',  'placeholder' => '00/00/00']) !!}   
                    </div>
                </div>

                <div class="form-group">      
                    <label>Cliente: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                        <select  name="customer_id" id="customer_id" class="form-control">  
                            <option value="">Escolha um Cliente</option>                        
                            @foreach($obj_cliente as $cliente)
                            <option value="{{$cliente->id}}"
                                    @if(isset($obj_rec->customer_id) && ($obj_rec->customer_id == $cliente->id))
                                    selected
                                    @endif
                                    >{{$cliente->nome_cliente}}
                        </option> 
                        @endforeach
                    </select>
                </div>
            </div>  

            <div class="form-group">       
                <label>Categoria: </label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></div>
                    <select  name="category_receipt_id" id="category_receipt_id" class="form-control">  
                        <option value="">Escolha uma Categoria</option>                        
                        @foreach($obj_cat_rec as $cat_rec)
                        <option value="{{$cat_rec->id}}"
                                @if(isset($obj_rec->category_receipt_id) && ($obj_rec->category_receipt_id == $cat_rec->id))
                                selected
                                @endif
                                >{{$cat_rec->nome_cat_rec}}
                    </option> 
                    @endforeach
                </select>
            </div>
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
</div><!-- /fim da div container-fluid -->

@endsection
@push('scripts')
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/data-calendario.js')}}"></script>
@endpush