@extends('layouts.admin-home')

@section('content')
<a href="{{route('admin.painel')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
<!-- Gráfico-->
<div id="piechart" style="width: 900px; height: 500px;"></div>   


@endsection()   

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages': ['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    var data = google.visualization.arrayToDataTable([
    ['Categoria', 'Total'],
    
        <?php foreach ($array_rec as $valor): ?>

            <?php
               echo "['" .$valor->nome. "', ".$valor->total_rec."],"; 
            ?>

        <?php endforeach; ?>

    ]);

    var options = {
        title: 'Valores em Reais por categoria',
        is3D: true
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
}
</script>
@endpush
