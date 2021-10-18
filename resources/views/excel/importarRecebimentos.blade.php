@extends('layouts.admin-home')

@section('content')

<!--Mensagem de sucesso-->
@if(session()->has('sucesso'))
<div class="alert alert-success">
    {{ session()->get('sucesso') }}
</div>
@endif 

<!--Mensagem de erro-->
@if(isset($errors) && count($errors) > 0 )
<div class="alert alert-danger">
    @foreach($errors->all() as $err)
    <p>{{$err}}</p>
    @endforeach
</div>         
@endif 
<a href="{{route('admin.painel')}}"><span class="glyphicon glyphicon-fast-backward"></span>Voltar</a>
<h3>Importar arquivo</h3>

{!! Form::open(['route' => 'postImportar', 'class' => 'form', 'method' => 'post']) !!}

<div class="form-group">    
    {!! Form::file('arquivo') !!}
</div>

<div class="form-group">
    {!! Form::submit('importar', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

@endsection

