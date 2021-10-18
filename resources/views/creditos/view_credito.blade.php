@extends('layouts.admin-home')

@section('content')
@push('scripts')

<script>
    $('document').ready(function () {

        $("#id-forma-pagamento").change(function () {
            var selecionado = $("#id-forma-pagamento option:selected");

            if ((selecionado.text() === 'Transferência bancária' || selecionado.text() === 'Débito Automático' || selecionado.text() === 'Cheques')) {

                $('#resultado').show();

            } else {
                $('#resultado').hide();
            }
          
        });

    });

</script>

@endpush

@if( isset($errors) && count($errors) > 0 )
<div class="alert alert-danger">
    @foreach($errors->all() as $err)
    <p>{{$err}}</p>
    @endforeach
</div>         
@endif 

<a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <h4 class="title-pg">{{$title.":".$nome_cliente}} </h4>
            <table class="table table-hover table-striped table-condensed" id="id_tabela">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Data vencimento</th>  
                        <th>Nome</th>                
                        <th>Nota Fiscal</th>
                        <th>Valor</th>                              

                    </tr>
                </thead>
                <tbody>                
                    <tr>
                        <td>{{$arr_cred->id}}</td>
                        <td>{{$dataFormatoBr->parse($arr_cred->data_vencimento)->format('d/m/Y')}}</td>
                        <td>{{$arr_cred->nome_recebimento}}</td>                       
                        <td>{{$arr_cred->nota_fiscal_cr}}</td>
                        <td>R${{number_format($arr_cred->valor, 2, ',', '.')}}</td>                    
                    </tr>                   
                </tbody>    
            </table>
        </div>
        <div class="col-md-4 formulario">
            <!-- Envia para Tela para Salvar-->
            <form method="post" class="form-group" action="{{route('postRecebido')}}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$arr_cred->id}}" name="id-recebimento" id="id-recebimento" />

                <div class="form-group">
                    <select  name="id-forma-pagamento" id="id-forma-pagamento" class="form-control" required="required">  
                        <option value="">Selecione o pagamento:</option>
                        @foreach($forma_pagamento as $forma_pag)                        
                        <option value="{{$forma_pag->id}}">{{$forma_pag->tipo}}</option>
                        @endforeach

                    </select>
                </div>                  
                <div class="form-group" id="resultado" required="required" style="display:none">
                    <select name="id-banco" id="id-banco">                            
                        <option>Banco:</option>
                        @foreach($nome_banco as $banco)
                        <option value="{{$banco->id}}">{{$banco->nome}}</option>
                        @endforeach
                    </select>
                </div>                
                <div class="form-group">
                    <input type="submit" class="btn btn-primary"  name="bto" id="bto" value="Receber">
                </div>
            </form>

        </div>
    </div>
</div>
{{ $arr_cred->links() }}
@endsection
