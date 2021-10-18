<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Sistema Financeiro') }}</title>
        <link rel="stylesheet" href="{{url('css/style.css')}}"/>
        <link rel="stylesheet" href="{{url('css/bootstrap.css')}}"/>
        <link rel="stylesheet" href="{{url('Https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css')}}"/>
        <link rel="stylesheet" href="{{url('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css')}}"/> 

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(), //Sempre que for atualizado seta fica separada | =   > | 
            ]) !!};
        </script>
    </head>
    <body>    

        <div class="container">
            <div class="navbar-header">
                <!-- Authentication Links -->
                @if (Auth::guest()) <!-- Verifica se usuário não está autênticado -->
                <h3 style="text-align: center;">Tela login</h3>
                @endif
                @yield('content')
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>            
        <script src="{{url('https://code.jquery.com/jquery-3.1.1.min.js')}}" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="{{url('js/datepicker_formato_pt_br.js')}}"></script>
        <script src="{{url('http://code.jquery.com/ui/1.10.3/jquery-ui.js')}}"></script> 
    </body>
</html>
