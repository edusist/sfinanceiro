<?php

namespace App\Http\Controllers\adminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;


class AdminLoginController extends Controller {

    public function __construct() {

        $this->middleware('guest');
    }

    public function showLoginForm() {

        return view('admin-auth.admin-login');
    }

    //Exibir o formulário de login
    public function login(Request $request) {


        //Validação de formulário
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        //Tentativa de login do usuário, verifica se tem o usuario cadastrado no BD.
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])):

            //Se tiver sucesso será direcionado para painel do administrador(home-admin)e uma sessão sera criada,autenticada para o usuário administrador.
            return redirect()
                            ->intended(route('admin.painel'));
        endif;

        //Se não for autenticado retorna para formulário de login com os dados
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }
    //Chama a função function handle
    // C:\xampp\htdocs\sistemaLaravel\app\Http\Middleware\RedirectIfAuthenticated.php
    public function logout(Request $request) {        

        //dd($request);
        //$this->guard()->logout();        

        $request->session()->flush();

        $request->session()->regenerate();
        return redirect()->route('admin.login');
    }

}
