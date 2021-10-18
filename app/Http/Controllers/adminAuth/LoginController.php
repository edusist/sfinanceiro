<?php

namespace App\Http\Controllers\adminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin', ['except' => 'logout']);
    }

    public function login() {

        return view('admin-auth.admin-login');
    }

    //Quando submete o formulário de login
    public function postLogin(Request $requisicao) {

        $validacao = validator($requisicao->all(), [

            'email' => 'required|min:3|max:100',
            'password' => 'required|min:3|max:8'
        ]);
        //dd($validacao);
    }
    

}
