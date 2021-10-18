@extends('layouts.admin-home')

@section('content')

<div class="container-fluid">

    <!-- Link para voltar -->
    <a href="{{route('sub_categoria_recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

    <h2 class="title-pg"><b>{{$title}}</b></h2>

    {{--Tratamento de erros--}}
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
                <!-- Formulário utilizado tanto para cadastrar, quanto para editar -->
                @if(isset($objSubCatRec) && isset($objSubCatRec->id) )
                <!-- Envia para Tela para editar -->
                {!! Form::model($objSubCatRec, ['route' => ['sub_categoria_recebimento.update', $objSubCatRec->id], 'class' => 'form', 'method' => 'put'])  !!}
                @else
                <!-- Envia para Tela para Salvar-->
                {!! Form::open(['route' => 'sub_categoria_recebimento.store', 'class' => 'form']) !!}
                @endif 
                <h4 class="modal-title"> Sub-Categoria Recebimentos</h4>
            </div><!-- /.modal header -->

            <div class="modal-body">
                <div class="form-group">
                    <label>Nome Sub-categoria:</label>     
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></div>
                        {!! Form::text('nome', null, ['class' => 'form-control', 'placeholder' => 'Digite a sub categoria']) !!} 
                    </div>
                </div>

                <div class="form-group">       
                    <label>Categoria: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></div>
                        <select  name="category_receipt_id" id="category_receipt_id" class="form-control">  
                            <option selected="">Escolha uma Categoria</option>                        
                            @foreach($categoria_rec as $categoria)
                                <option value="{{$categoria->id}}"
                                            @if(isset($objSubCatRec->category_receipt_id) && ($objSubCatRec->category_receipt_id == $categoria->id))
                                                selected
                                            @endif                                        
                                        >{{$categoria->nome_cat_rec}}

                                </option> 
                            @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Descricao:</label> 
                    {!! Form::textarea('descricao', null, ['class' => 'form-control', 'cols' => '20', 'rows' => '5', 'placeholder' => 'Digite aqui...:']) !!}
                </div>   

            </div><!-- /.modal-body -->
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