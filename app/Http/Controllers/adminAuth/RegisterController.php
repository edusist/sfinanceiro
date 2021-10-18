<?php

namespace App\Http\Controllers\adminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use App\Http\Controllers\adminAuth\RegisterController\testaCredenciais;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      |Este controler lida com o registro de novos usuários, bem como
           | Validação e criação. Por padrão, esse controler usa uma
           | Fornecer esta funcionalidade sem exigir qualquer código adicional.
      |
     */

//    use RedirectsUsers;

    /**
     * Onde redirecionar os usuários após o registro.
     *
     * @var string
     */
    //protected $redirectTo = '/admin-home';
    private $admin;

    /**
     * Criar uma nova instância do controller.
     *
     * @return void
     */
    public function __construct(Admin $Administrador) {

        $this->middleware('admin');
        $this->admin = $Administrador;
    }

    public function showRegistrationForm() {

       //return 'admin register';
        return view('admin-auth.register');
    }

    //Obter um validador para uma solicitação de requisição de entrada.
    public function register(Request $requisicao) {

        //dd($requisicao->all());
        $requisicao->session()->flush();
        
        $requisicao->session()->regenerate();
        
        $validacao = validator($requisicao->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6|confirmed',
        ]);
        //dd($validacao);
        if ($validacao->fails()):

            return redirect()
                            ->back()
                            ->witherrors($validacao)
                            ->withInput();
        else:

            $this->admin->create([
                'name' => $requisicao->name,
                'email' => $requisicao->email,
                'password' => bcrypt($requisicao->password),
                'remember_token' => $requisicao->_token,
            ]);
            //dd($cadastro);

            Auth::guard('admin')->attempt(['email' => $requisicao->email, 'password' => $requisicao->password], $requisicao->remember_token);
            //if (auth()->guard('admin')->attempt($credenciais)):

            return redirect()->intended(route('admin.painel'));

        endif;
    }

}
