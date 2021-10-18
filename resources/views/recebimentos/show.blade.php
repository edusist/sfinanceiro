@extends('layouts.admin-home')

@section('content')

<h2 class="title-pg">Recebimento: <b>{{$obj_rec->nome_recebimento}}</b></h2>

<a href="{{route('recebimento.index')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>

<p><b>Id:</b>{{$obj_rec->id}}</p>
<p><b>Nome: </b>{{$obj_rec->nome_recebimento}}</p>
<p><b>valor: </b>R${{$obj_rec->valor}}</p>
<p><b>Categoria:</b>{{$obj_rec->subcat_rec_id}}</p>
<p><b>Data Atualização:</b>{{$data_carbon->parse($obj_rec->updated_at)->format('d/m/Y')}}</p>


<hr>
<!--Tratamento de erros-->
@if( isset($errors) && count($errors) > 0 )
    <div class="alert alert-danger">
        @foreach($errors->all() as $err)
            <p>{{$err}}</p>
        @endforeach
    </div>
@endif

<!--Formuláriario do deletar 
Unica maneira de deletar um item
-->

{!! Form::open(['route' => ['recebimento.destroy', $obj_rec->id], 'method' => 'DELETE']) !!}

    {!! Form::submit("Excluir Recebimento", ['class' => 'btn btn-danger']) !!}

{!! Form::close() !!}

@endsection