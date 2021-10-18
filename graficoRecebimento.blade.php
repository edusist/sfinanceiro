@extends('layouts.admin-home')

@section('content')
<a href="{{route('admin.painel')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
    <canvas class="linha-chart"></canvas>
@endsection()   

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<script>

    $('document').ready(function () {

        arr = [];
        var dados;
        $.ajax({
            url: "{{route('getGrafico')}}",
            type: "GET",
            success: function (data) {

                dados = data.length;
                for (var i = 0; i < dados; i++) {

                    arr = data[i].valor;
                    console.log(arr);

                }
                var contexto = document.getElementsByClassName('linha-chart');
                //Type, data, options
                var graficoChart = new Chart(contexto, {

                    type: 'line',
                    data: {
                    labels: [<?php
                            $dias = implode(",", $arr_dia);
                            print_r($dias);
                            ?>],
                            datasets: [
                            {
                                label: 'Valor do Recebimento - 2017',
                                data: [
                                <?php
                                
                                $valores = implode(",", $Array_rec);                               
                                
                                  print_r($valores);                                 
                                
                                ?>
                                 ],
                                borderWidth: 3,
                                borderColor: '#00FF00',
                                backgroundColor: 'transparent'
                            }
                        ]
                    },
                    options: {
                        title: {
                            display: true,
                            fontSize: 20,
                            text: 'Recebimentos do Mês atual'

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
         