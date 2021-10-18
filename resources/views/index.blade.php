@extends('layouts.tela-login-admin')

@section('content')

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
<!--            <img src="{!! url('img/financeiro.jpg') !!}" >-->
            <div class="panel-heading">Administrador</div>
            <div class="panel-body">
                <form class="form-group" role="form" method="POST" action="{{ route('admin.login.submit') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email:</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif

                    </div><!--/form-group-->

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">  
                        <label for="password">Senha:</label>
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif

                    </div><!--/form-group-->

                    <div class="form-group">                           
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Lembrar
                            </label>
                        </div>

                    </div><!--/form-group-->

                    <div class="form-group">                            
                        <button type="submit" class="btn btn-primary">Login</button>
                        <a class="btn btn-link" href="{{ route('admin.request') }}">Esqueceu sua senha?</a>
                    </div><!--/form-group-->

                </form><!--/form -->
            </div><!--/panel-body -->
        </div><!-- /panel-default -->
    </div><!-- /col-md-6 -->
</div><!-- /fim da div row -->

@endsection
