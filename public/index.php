<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
|O Composer fornece um carregador de classe conveniente e gerado
| Nossa aplicação. Só precisamos utilizá-lo! Vamos simplesmente requerê-lo
| No script aqui para que não precisemos nos preocupar com o manual
| Carregando qualquer uma das nossas aulas mais tarde. É agradável para relaxar.
|
*/

require __DIR__.'/../bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Acenda as luzes
| ------------------------------------------------- -------------------------
|
| Precisamos iluminar o desenvolvimento do PHP, então vamos ligar as luzes.
| Este bootstraps o quadro e fica pronto para uso, então ele
| Irá carregar este aplicativo para que possamos executá-lo e enviar
| As respostas de volta para o navegador e encantar nossos usuários.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';
//    dd($app);
//        echo "<pre>";
//        print_r($app);        
//        echo "</pre>";
//        echo "<br />";

//$app->bind('path.public', function() {
//    return base_path().'/public_html/financeiro/';
//});



/*
|--------------------------------------------------------------------------
| Executar o aplicativo
| ------------------------------------------------- -------------------------
|
| Uma vez que temos o aplicativo, podemos lidar com o pedido de entrada
| Através do kernel e enviar a resposta associada de volta para
| O navegador do cliente, permitindo-lhes desfrutar da criatividade
| E aplicação maravilhosa nós preparamos para eles.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
