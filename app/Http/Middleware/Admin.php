<?php

namespace App\Http\Middleware;

use \Illuminate\Support\Facades\Auth;
use Closure;

class Admin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {

                switch ($guard) {
            case 'admin':

                if ($request->path() == "admin/logout"):

                    //Limpa a sessão
                    $request->session()->flush(); //echo "{$sessao }";
                    $request->session()->regenerate();
                    //Manda o usuário para tela inicial
                    return redirect()->route('admin.login');

                elseif ($request->path() == "admin/register"):                    
                    
                    dd(Auth::guard($guard)->check());
//                    $request->session()->flush();

                    //$request->session()->regenerate();
                    return redirect()->route('admin.register');


                //Verifica se usuário admin está realmente autênticado.
                elseif (Auth::guard($guard)->check()):
                    return redirect()->route('admin.painel');

                endif;

                break;
            default :
                
                //dd($guard);
                //guard web
                if (Auth::guard($guard)->check()):

                    return redirect('home');
                endif;
                break;
        }
        //dd($next($request));
        return $next($request);
    } 
    

}

//dd($guard);
//        if (Auth::guard($guard)->check()):
//            //dd($guard);
//            switch ($guard):
//                
//                case 'admin':
//
//                    return redirect('/admin-home');
//                    break;
//                default :
//
//                    return redirect('/home');
//                    break;
//            endswitch;
//        endif;

//        return $next($request);