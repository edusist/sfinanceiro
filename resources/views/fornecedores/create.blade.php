@extends('layouts.admin-home')

@section('content')

<div class="container-fluid">
    <!-- Link para voltar -->
    <a href="{{route('fornecedor.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

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
                @if(isset($objFornecedor) && isset($objFornecedor->id) )
                <!-- Envia para Tela para editar -->
                {!! Form::model($objFornecedor, ['route' => ['fornecedor.update', $objFornecedor->id], 'class' => 'form', 'method' => 'put'])  !!}
                @else
                <!-- Envia para Tela para Salvar-->
                {!! Form::open(['route' => 'fornecedor.store', 'class' => 'form']) !!}
                @endif 
                  <h4 class="modal-title">Fornecedor</h4>
            </div><!-- /.modal header -->
            <div class="modal-body">    

                <div class="form-group">
                    <label>Nome fornecedor: </label>     
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-user"></i></div>
                        {!! Form::text('nome_fornecedor', null, ['class' => 'form-control', 'placeholder' => 'Digite o fornecedor']) !!} 
                    </div>
                </div>
                <div class="form-group">
                    <label>CNPJ/CPF: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-certificate"></i></div>
                        {!! Form::text('cnpj_cpf', null, ['class' => 'form-control', 'placeholder' => 'Digite cnpj ou cpf']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label>E-mail: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'meu_email@mail.com.br']) !!}
                    </div>
                </div>                

                <div class="row">                  
                    <div class="col-xs-6">
                        <label>Telefone Fixo: </label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></div>
                            {!! Form::text('telefone_fixo', null, ['class' => 'form-control', 'placeholder' => '(31)0000-0000']) !!}
                        </div>

                    </div>
                    <div class="col-xs-6">
                        <label>Telefone celular: </label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></div>
                            {!! Form::text('telefone_celular', null, ['class' => 'form-control', 'placeholder' => '(31)9999-9999']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-9">
                        <label>Endereco:</label>  
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></div>
                            {!! Form::text('endereco', null, ['class' => 'form-control', 'placeholder' => 'Rua: um']) !!}
                        </div>
                    </div>

                    <div class="col-xs-3">
                        <label>Número:</label>
                        <div class="input-group">                             
                            <div class="input-group-addon"><i class="">Nº</i></div>
                            {!! Form::text('numero', null, ['class' => 'form-control', 'placeholder' => '000']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-9">
                        <label>Cidade:</label>  
                        <div class="input-group">
                            <div class="input-group-addon"><i class="glyphicon glyphicon-list"></i></div>
                            {!! Form::text('cidade', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-xs-3">
                        <label>Estado:</label>
                        <div class="input-group">                             
                            <div class="input-group-addon"><i class="">UF</i></div>
                            {!! Form::text('Estado:', null, ['class' => 'form-control']) !!}
                        </div>
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
                {!! Form::close() !!}

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div><!-- /fim da div container-fluid -->

@endsection