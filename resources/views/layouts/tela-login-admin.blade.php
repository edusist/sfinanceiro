<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', '.::Login Administrador::.') }}</title>
        <!-- Scripts -->
        <script src="{{url('https://code.jquery.com/jquery-3.1.1.min.js')}}"></script>

        <!-- Css -->
        <link rel="stylesheet" type="text/css" href="{{url('assets/css/form-login-admin.css')}}">
        <link rel="stylesheet" type="text/css" href="{{url('assets/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <script>
window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!};
        </script>
    </head>
    <body>
        
        <div class="container-fluid" style="margin-top: 10px;">
            
            <h1 class="title-pg" style="text-align: center;">Sistema de Gestão Financeira - AIO</h1>
            @yield('content')
        </div><!-- /fim da div container-fluid -->

            <!-- Scripts -->            
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </body>
</html>
