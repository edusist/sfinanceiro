@extends('layouts.admin-home')

@section('content')

<!-- Link para voltar -->
<a href="{{route('empresa.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

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
            @if(isset($objEmpresa) && isset($objEmpresa->id) )
            <!-- Envia para Tela para editar -->
            {!! Form::model($objEmpresa, ['route' => ['empresa.update', $objEmpresa->id], 'class' => 'form', 'method' => 'put'])  !!}
            @else
            <!-- Envia para Tela para Salvar-->
            {!! Form::open(['route' => 'empresa.store', 'class' => 'form']) !!}
            @endif 

            <h4 class="modal-title">Empresa</h4>
        </div><!-- /.modal header -->

        <div class="modal-body">  

            <div class="form-group">
                <label>Nome empresa: </label>     
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></div>
                    {!! Form::text('nome_empresa', null, ['class' => 'form-control', 'placeholder' => 'Digite o nome da empresa:']) !!}   
                </div>
            </div>

            <div class="form-group">
                <label>CNPJ/CPF: </label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-certificate"></i></div>
                    {!! Form::text('cnpj_cpf', null, ['class' => 'form-control', 'placeholder' => 'Digite cnpj ou cpf:']) !!}
                </div>
            </div>

            <div class="form-group">
                <label>E-mail: </label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></div>
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'novo_email@mail.com.br']) !!}
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
                <div class="col-xs-8">
                    <label>Logradouro:</label>  
                    <div class="input-group">
                        <div class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></div>
                        {!! Form::text('endereco', null, ['class' => 'form-control', 'placeholder' => 'Rua: um']) !!}
                    </div>
                </div>
                <div class="col-xs-4">                       
                    <label>Número:</label>
                    <div class="input-group">                             
                        <div class="input-group-addon"><i class="">Nº</i></div>
                        {!! Form::text('numero', null, ['class' => 'form-control', 'placeholder' => '000']) !!}
                    </div>                   
                </div>
            </div>
        
        <div class="row">
            <div class="col-xs-6">
                <label>Bairro:</label>
                <div class="input-group">                             
                    <div class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></div>
                    {!! Form::text('bairro', null, ['class' => 'form-control', 'placeholder' => 'seu bairro']) !!}
                </div>
            </div>
            <div class="col-xs-6">
                <label>Complemento:</label>
                <div class="input-group">                             
                    <div class="input-group-addon"><i class="">Nº</i></div>
                    {!! Form::text('complemento', null, ['class' => 'form-control', 'placeholder' => 'Apto']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3">
                <label>Estado:</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-list"></i></div>
                    <input id="uf" name="uf" default="UF:" class="form-control">

                </div>
            </div>

            <div class="col-xs-9">
                <label>Cidade:</label>  
                <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></div>
                    <input id="cidade" name="cidade" class="form-control">

                </div>
            </div>
        </div><!-- /fim do row -->
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
    </div><!-- /    .modal footer -->  
    {!!Form::close() !!}
</div><!-- /.modal-content -->
</div><!--/.modal-dialog -->
@endsection
<!--Java Script -->
@push('scripts')
<script type="text/javascript" src="{{url('/vendor/artesaos/cidades/js/scripts.js')}}"></script>
<script>
$('#uf').ufs({
    onChange: function (uf) {
        $('#cidade').cidades({uf: uf});
    }
});
</script>
@endpush

