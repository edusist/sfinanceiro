//Janela de Modal
$('#btn-modal').click(function () {
    $('#modal-calendario').modal();
});
$('.data-calendario').datepicker({
    format: "dd/mm/yyyy",
    clearBtn: true,
    language: "pt-BR"
});