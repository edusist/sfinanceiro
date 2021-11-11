//Verificar o status do Recebimento
$('document').ready(function () {

    $('.status').each(function() {

        if ($(this).text().trim() == 0) {            
            $(this).parent('tr').css('background', '#ffffff');//Branco

        }else if ($(this).text().trim() == 1) {
            $(this).parent('tr').css('background', '#f8e452');//Amarelo  
        
        }else if ($(this).text().trim() == 2) {
            $(this).parent('tr').css('background', '#98FB90');//Verde 

        } else {
            $(this).parent('tr').css('background', '#f7cfcf');//vermelho

        }
    });

});