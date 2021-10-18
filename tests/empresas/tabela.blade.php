@extends('layouts.app')

@section('content')

<div class="table-responsive">
    <table class="table table-striped" id="id_tabela">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome Cliente</th>
                <th>Email</th>   
                <th>Data da atualização</th>                        
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

@endsection

@push('scripts')
<script>
    $(function () {
        $('#id_tabela').DataTable({
        processing: true,
                serverSide: true,
                ajax: '{{ route("dados.cliente") }}',
                columns: [
                {data: 'id', name: 'id'},
                {data: 'nome_cliente', name: 'nome_cliente'},
                {data: 'email', name: 'email'},
                {data: 'updated_at', name: 'updated_at'}
                ],
         
                "bJQueryUI": true,
                        "oLanguage": {
                        "sProcessing": "Processando...",
                                "sLengthMenu": "Mostrar _MENU_ registros",
                                "sZeroRecords": "Não foram encontrados resultados",
                                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
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