    $(document).ready(function () {

        //Checkbox quando for marcado exibe input nota-fiscal
        $("#exibe-nf").click(function () {

            if ($(this).prop("checked")) {


                $('#nota-fiscal').show(function () {

                });
                //Desmarcado oculta input nota-fiscal
            } else {
                $('#nota-fiscal').hide(function () {

                });

            }
        });
    });
