@extends('layouts.admin-app')

@section('content')
@if( isset($errors) && count($errors) > 0 )
<div class="alert alert-danger">
    @foreach($errors->all() as $err)
    <p>{{$err}}</p>
    @endforeach
</div>         
@endif 

<form action="{{route('informacaoPesquisa')}}" method="get" id="form-pesquisa" class="form-horizontal">
    <div class="input-group">
        <input type="text" name="pesquisar" class="form-control" placeholder="Pesquisar..."/>
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
        </span>
    </div>    
</form> 
<div class="result">

</div>
@endsection

@section('scripts')

<script type="text/javascript">
    $('form-pesquisa').on('submit', function (e) {

        e.preventDefault();
        var url = ('this').attr('action');
        var data = ('this').serializeArray();
        var get = ('this').attr('method');
        $.ajax({
            type: get,
            url: url,
            data: data
        }).done(function (data) {

            console.log(data);
        });
    });

</script>

@endsection()