<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
|
     | Este controlador é responsável pelo processamento de solicitações de redefinição de senha
     | E usa um traço simples para incluir esse comportamento. Você é livre para
     | Explorar essa característica e substituir qualquer método que você deseja ajustar.
    |
    */

    use ResetsPasswords;

    /**
     * Onde redirecionar os usuários após redefinir sua senha.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Criar uma nova instância do controlador.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    

}
