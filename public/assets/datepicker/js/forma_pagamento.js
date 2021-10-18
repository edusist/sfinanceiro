    //Verifica o tipo de pagamento
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