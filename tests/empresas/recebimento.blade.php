@extends('layouts.admin-app')

@section('content')

<div class="table-responsive">
    <table class="table table-striped" id="idtabela">
        <thead>
            <tr>
                <th>Id</th>
                <th>Recebimento</th>
                <th>NF</th>   
                <th>Valor</th>                
                <th>Data da atualização</th>                        
            </tr>
        </thead>
        <tbody> 
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#idtabela').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('get.recebimento') !!}',
            columns: [
                {data: 'id',                name: 'id'},
                {data: 'nome_recebimento',  name: 'nome_recebimento'},
                {data: 'nota_fiscal_cr',    name: 'nota_fiscal_cr'},
                {data: 'valor',             name: 'valor'}               
                
                //data_atualizacao {data: 'updated_at',        name: 'updated_at'}
            ],
            "bJQueryUI": true,
            "oLanguage": {
                "sProcessing": "Processando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "Não foram encontrados resultados",
                "sInfo": "Mostrando de _INÍCIO_ até _FIM_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando de 0 até 0 de 0 registros",
                "sInfoFiltered": "",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext": "Seguinte",
                    "sLast": "Último"
                }
            }
        });
    });
</script>
@endpush