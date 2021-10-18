<?php

/*
|--------------------------------------------------------------------------
| Criar o aplicativo
| ------------------------------------------------- -------------------------
|
| A primeira coisa que vamos fazer é criar uma nova instância de aplicação Laravel
| Que serve como a "cola" para todos os componentes de Laravel, e é
| O contêiner IoC para o sistema que liga todas as várias partes.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Vincular Interfaces Importantes
| ------------------------------------------------- -------------------------
|
| Em seguida, precisamos vincular algumas interfaces importantes no
| Seremos capazes de resolvê-los quando necessário. Os grãos servem
| Solicitações de entrada para este aplicativo da Web e da CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

//$app->register(
//        \Barryvdh\DomPDF\ServiceProvider::class
//);

//$app->configure('dompdf');

/*
|--------------------------------------------------------------------------
| Retornar o aplicativo
| ------------------------------------------------- -------------------------
|
| Esse script retorna a instância do aplicativo. A instância é dada a
| O script de chamada para que possamos separar a construção das instâncias
| A partir da execução real da aplicação e enviar respostas.
|
*/
//dd($app);
return $app;
