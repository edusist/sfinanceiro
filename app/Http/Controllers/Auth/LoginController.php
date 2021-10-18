<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador lida com usuários de autenticação para o aplicativo e
      Redirecionando-os para a sua tela inicial. O controlador usa uma característica
      Para fornecer convenientemente a sua funcionalidade para as suas aplicações.
    |
     * 
     * Chamada da função handle($request, Closure $next, $guard = null) para verificar teste de  autênticação 
     * Diretorio Middleware/RedirectIfAuthenticated.php
     * 
    */ 

    use AuthenticatesUsers;

    /**
     * Onde redirecionar os usuários após o login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     *Crie uma nova instância do controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

}
