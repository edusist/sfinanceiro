@extends('layouts.admin-home')

@section('content')

    <canvas class="bar-chart"></canvas>
@endsection()   

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<script>

    $('document').ready(function () {

        arr = [];
        var dados;
        $.ajax({
            url: "{{route('getGraficoPagamento')}}",
            type: "GET",
            success: function (data) {

                dados = data.length;
                for (var i = 0; i < dados; i++) {

                    arr = data[i].valor;
                    console.log(arr);

                }
                var contexto = document.getElementsByClassName('bar-chart');
                //Type, data, options
                var graficoChart = new Chart(contexto, {

                    type: 'bar',//bar, line, pie
                    data: {
                    labels: [
                            <?php
                            
//                                $categorias = $array_categoria;
                                $arr = $arr_dia;
                                $dias = implode(",", $arr);
                                print_r($dias);
                            ?>
                            ],
                            datasets: [
                            {
                                label: 'Valores em Reais',
                                data: [
                                <?php                                
                                   
                                    //dd($dados);
                                    $valores = implode(",", $Array_pag);                               

                                    print_r($valores);                                 
                                
                                ?>
                                 ],
                           
                                borderWidth: '1',
                                borderColor: '#000000',
                                backgroundColor: [ "#3e95cd" , "#8e5ea2" , "#3cba9f" , "#c45850" , "#008B8B", "#FF4500" ]
                            }
                            ]                                    
                    },
                    options: {
                    
                        title: {
                            display: true,
                            fontSize: 20,
                            text: 'Pagamentos do Mês atual: valores em Reais x dias'

                        }
                    }
                });
            },
            error: function (data) {
                alert("Erro no gráfico!");

            }
        });
    });

</script>
@endpush
         