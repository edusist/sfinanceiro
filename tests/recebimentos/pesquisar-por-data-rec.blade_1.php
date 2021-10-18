@extends('layouts.admin-home')

@section('content')

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
                <form method="Post" action="{{route('postPesquisarPorDataReceber')}}">                   
                    <div class="input-group date data-calendario">
                        <input type="text" id="data-calendario" name="data-calendario" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                        <button type="button" class="btn btn-success">Enviar</button>

                    </div>
                </form>
            </div>

            <!--/fim Calendário modal -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@push('scripts')

<link rel="stylesheet" href="{{url('assets/datepicker/css/bootstrap.min.css')}}">
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/datepicker/js/bootstrap-datepicker.pt-BR.min.js')}}"></script>
<!--<script src="{{url('assets/datepicker/js/modal-calendario.js')}}"></script>-->

<script>
$('#btn-modal').click(function () {

    $('#modal-calendario').modal();
});
$('.data-calendario').datepicker({
    format: "dd/mm/yyyy",
    clearBtn: true,
    language: "pt-BR"
});
</script>
@endpush