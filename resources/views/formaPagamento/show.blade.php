@extends('layouts.admin-home')

@section('content')
<!--Tratamento de erros-->
@if( isset($errors) && count($errors) > 0 )
    <div class="alert alert-danger">
        @foreach($errors->all() as $err)
            <p>{{$err}}</p>
        @endforeach
    </div>
@endif


<h2>{{$title}}</h2>

<p><b>Id:</b>{{$objformaPag->id}}</p>
<p><b>Tipo: </b>{{$objformaPag->tipo}}</p>
<p><b>Data Criação: </b>{{ $carbon->parse($objformaPag->created_at)->format('d/m/Y')}}</p>


<!--Formuláriario do deletar 
Unica maneira de deletar um item
-->
{!! Form::open(['route' => ['forma-pagamento.destroy', $objformaPag->id], 'method' => 'DELETE']) !!}

    {!! Form::submit("Excluir Forma de pagamento", ['class' => 'btn btn-danger']) !!}

{!! Form::close() !!}

@endsection